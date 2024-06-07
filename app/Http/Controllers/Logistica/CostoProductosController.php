<?php

namespace App\Http\Controllers\Logistica;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CostoProductosController extends Controller
{
    public function ConsultaCostoProductosSAP(Request $request)
    {
        try {
            $sapAuthUrl = 'https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Login';
            $sapApiBaseUrl = 'https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/sml.svc';
            $sapCompanyDB = 'HBT_DOBLAMOS';
            $sapUsername = 'manager';
            $sapPassword = 'DOB890';

            $client = new Client();

            // Autenticación en la API de SAP B1
            $authResponse = $client->post($sapAuthUrl, [
                'json' => [
                    'CompanyDB' => $sapCompanyDB,
                    'Password' => $sapPassword,
                    'UserName' => $sapUsername,
                ],
            ]);

            $authData = json_decode($authResponse->getBody(), true);
            $sessionId = $authData['SessionId'];

            $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

            $ventasUrl = $sapApiBaseUrl . "/COSTO_PRODUCTOS"; // Usar el endpoint proporcionado

            // Consultar la API
            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            $groupedData = [];
            foreach ($data['value'] as $item) {
                $itemCode = $item['ItemCode'];

                if (!isset($groupedData[$itemCode])) {
                    $groupedData[$itemCode] = [
                        'SumOnHand' => 0,
                        'SumCostoCompleto' => 0,
                    ];
                }

                $groupedData[$itemCode]['SumOnHand'] += $item['OnHand'];
                $groupedData[$itemCode]['SumCostoCompleto'] += $item['Costo_Completo'];
            }

            $calculatedData = [];
            foreach ($data['value'] as $item) {
                $itemCode = $item['ItemCode'];
                $calculatedAvgPrice = 0;

                if ($groupedData[$itemCode]['SumOnHand'] != 0) {
                    $calculatedAvgPrice = $groupedData[$itemCode]['SumCostoCompleto'] / $groupedData[$itemCode]['SumOnHand'];
                }

                $newRow = [
                    'ItemCode' => $item['ItemCode'],
                    'ItemName' => $item['ItemName'],
                    'WhsCode' => $item['WhsCode'],
                    'WhsName' => $item['WhsName'],
                    'OnHand' => $item['OnHand'],
                    'originalAvgPrice' => $item['AvgPrice'], // Almacenar el precio original
                    'calculatedAvgPrice' => $calculatedAvgPrice,
                    'Costo_Completo' => $item['Costo_Completo'],
                    'id__' => $item['id__'],
                ];

                // Añadir fila revalorizada al arreglo de datos calculados
                $calculatedData[] = $newRow;
            }

            // Llamar al método sendRevaluation para enviar los datos a la API
            $this->sendRevaluation($calculatedData, $sessionId);

            return response()->json(['calculatedData' => $calculatedData]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ups, ocurrió un error: ' . $e->getMessage()], 500);
        }
    }

    public function sendRevaluation($calculatedData, $sessionId)
    {
        try {
            $apiUrl = 'https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/MaterialRevaluation';

            $revaluationData = [
                "DocDate" => now()->format('Y-m-d'),
                "Comments" => "Revalorizado por aplicativo GDT-FINANCIERO",
                "JournalMemo"=> "Revalorizado por aplicativo GDT-FINANCIERO",
                "MaterialRevaluationLines" => []
            ];

            $lineNum = 0; // Inicializar el número de línea
            foreach ($calculatedData as $row) {
                $warehouseCodes = explode(',', $row['WhsCode']);
                foreach ($warehouseCodes as $warehouseCode) {
                    // Obtener el precio original almacenado en $row['originalAvgPrice']
                    $originalAvgPrice = $row['originalAvgPrice'];
                    // Verificar si el Price es diferente al costo original antes de agregar la línea
                    if (round($row['calculatedAvgPrice'],2) === round($originalAvgPrice,2)) {
                        $this->logInfo("Descartando línea: ItemCode: " . $row['ItemCode'] . ", WarehouseCode: " . $warehouseCode . ",Costo actual sap: " .$originalAvgPrice. "Valor revalorizado: "  .$row['calculatedAvgPrice']. "stock actual SAP: " .$row['OnHand']. "stock con revalorizada:" .$row['OnHand']. "  - La revalorización no puede ser igual al costo actual. por eso no se enviara a sap");
                    } else {
                        $this->logInfo("SE AGREGA");
                        // Depuración: Imprimir información sobre el descarte de la línea
                        $revaluationData['MaterialRevaluationLines'][] = [
                            "LineNum" => $lineNum++, // Incrementar el número de línea en cada iteración
                            "ItemCode" => $row['ItemCode'],
                            "Price" => $row['calculatedAvgPrice'],
                            "OnHand" => $row['OnHand'],
                            "WarehouseCode" => $warehouseCode,
                            "RevaluationDecrementAccount" => "61209501",
                            "RevaluationIncrementAccount" => "61209501"
                        ];
                    }
                }
            }
            
            // Verificar si hay líneas para enviar
            if (!empty($revaluationData['MaterialRevaluationLines'])) {
                // Registrar los datos a enviar en el archivo de registro
                $this->logInfo("Datos a enviar a sap: " . json_encode($revaluationData));

                // Realizar el envío a SAP utilizando la librería Guzzle 
                $client = new Client();
                $response = $client->post($apiUrl, [
                    'headers' => [
                        'Cookie' => 'B1SESSION=' . $sessionId,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $revaluationData,
                ]);

                $responseBody = json_decode($response->getBody(), true);

                // Agregar la depuración detallada de la respuesta de SAP
                $this->logInfo("Respuesta de SAP: " . json_encode($responseBody));

                if (isset($responseBody['DocNum'])) {
                    // La operación fue exitosa, se recibió un DocNum en la respuesta
                    $this->logInfo("Operación exitosa. DocNum: " . $responseBody['DocNum']);
                    $this->logInfo("-----------------------------------------------------------------------------------------------------");
                    return response()->json(['success' => true]);
                } else {
                    // La operación no fue exitosa
                    $this->logError("Operación fallida. Respuesta: " . json_encode($responseBody));
                    return response()->json(['success' => false]);
                }
            } else {
                $this->logInfo("No hay líneas para enviar a SAP.");
                $this->logInfo("-----------------------------------------------------------------------------------------------------");
            }

        } catch (\Exception $e) {
            // Mostrar notificación de error usando SweetAlert2
            $this->logError("Error: " . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }

     // Define métodos para registrar en el canal personalizado
     protected function logInfo($message)
     {
         Log::channel('costo_productos')->info($message);
     }
 
     protected function logError($message)
     {
         Log::channel('costo_productos')->error($message);
     }

     public function Log_Revalorizaciones_SAP()
     {
         $logContent = File::get(storage_path('logs/costo_productos.log')); // Obtener el contenido del archivo de log
 
         return view('Logistica.Log_revalorizacion_sap', compact('logContent'));
     }


  
}
