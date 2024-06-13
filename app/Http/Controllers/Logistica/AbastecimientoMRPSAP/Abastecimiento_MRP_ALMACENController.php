<?php

namespace App\Http\Controllers\Logistica\AbastecimientoMRPSAP;

use App\Http\Controllers\Controller;
use App\Models\Logistica\AbastecimientoAlmacene;
use App\Models\Logistica\SolicitudesCompraHistorialeAlmacene;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class Abastecimiento_MRP_ALMACENController extends Controller
{


    public function Abastecimiento_MRP_SAP_Almacen()
    {

        $abastecimientoalmacen = AbastecimientoAlmacene::all();
        return view('Logistica.AbastecimientoMRP.MRP-ALMCEN', compact('abastecimientoalmacen'));
    }


    public function consumirpromedioventaSAPalmacen(Request $request)
    {
        try {
            // Configuración de SAP

            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');
            
            // Cliente Guzzle
            $client = new Client();

            // Iniciar sesión
            $loginUrl = $sapBaseUrl . '/Login';
            $loginBody = [
                'CompanyDB' => $sapCompanyDB,
                'Password' => $sapPassword,
                'UserName' => $sapUsername,
            ];

            $response = $client->post($loginUrl, [
                'json' => $loginBody,
            ]);

            $data = json_decode($response->getBody(), true);
            $sessionId = $data['SessionId'];
            $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

            $fechaInicio = $request->input('FechaInicio');
            $fechaFin = $request->input('FechaFin');
            $bodegaCompleta = $request->input('bodega');

            // Eliminar registros existentes 
            AbastecimientoAlmacene::truncate();

            // Construir la URL de la consulta con ambos valores de bodegas
            $ventasUrl = $sapBaseUrl . "/sml.svc/MRP_CONSUMIBLES?\$filter=Almacen eq '{$bodegaCompleta}'&\$select=ItemCode,Dscription,SWeight1,SubGrupo,Almacen,Stock,Comprometido,Pedido,Cantidad,id__";
            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            
            Log::info("Log 1".  $sessionId);
            // Nuevo array para almacenar los artículos filtrados
            $filteredItems = [];

            // Calcular el campo "Disponible" y "Sugerido" para cada artículo
            foreach ($data['value'] as &$item) {
                Log::info("Log 2".  $sessionId);
                // Filtrar artículos con "PROMO" o "REMASQUE"
                if (strpos($item['Almacen'], 'PROMO') !== false || strpos($item['Almacen'], 'REMASQUE') !== false) {
                    // Loggear los artículos excluidos
                    Log::channel('solcompraalmacen')->info('Artículo excluido: ' . json_encode($item));

                    // Almacenar el Pventa del artículo excluido para sumarlo después
                    $excludedItemsPventa[$item['ItemCode']] = $item['Cantidad'];

                    // Loggear información adicional sobre el Pventa excluido
                    Log::channel('solcompraalmacen')->info('Pventa excluido para ItemCode ' . $item['ItemCode'] . ': ' . $excludedItemsPventa[$item['ItemCode']]);
                } else {
                    // Verificar si hay Pventa excluido para este ItemCode y sumarlo al Pventa del artículo que pasa a la vista
                    if (isset($excludedItemsPventa[$item['ItemCode']])) {
                        // Sumar el Pventa del artículo excluido al Pventa del artículo que pasa a la vista
                        $item['Cantidad'] += $excludedItemsPventa[$item['ItemCode']];

                        // Dividir el Pventa resultante por 3
                        $item['Cantidad'] = intval($item['Cantidad'] / 3);

                        // Verificar si el resultado no es un número entero y redondear hacia arriba o hacia abajo según tus necesidades
                        if (!is_int($item['Cantidad'])) {
                            $item['Cantidad'] = round($item['Pventa']); // Puedes ajustar esto según tus necesidades
                        }

                        // Loggear información adicional sobre el artículo que pasa a la vista con Pventa actualizado
                        Log::channel('solcompraalmacen')->info('ItemCode ' . $item['ItemCode'] . ': Pventa después de la división por 3: ' . $item['Cantidad']);
                    } else {
                        // Si no hay Pventa excluido, simplemente dividir el Pventa por 3
                        $item['Cantidad'] = intval($item['Cantidad'] / 3);

                        // Verificar si el resultado no es un número entero y redondear hacia arriba o hacia abajo según tus necesidades
                        if (!is_int($item['Cantidad'])) {
                            $item['Cantidad'] = round($item['Pventa']); // Puedes ajustar esto según tus necesidades
                        }

                        // Loggear información después de la actualización
                        Log::channel('solcompraalmacen')->info('ItemCode ' . $item['ItemCode'] . ': Pventa después de la actualización: ' . $item['Cantidad']);

                        // Establecer la clave "Disponible" en el array
                        $item['Disponible'] = $item['Stock'] + $item['Pedido'] - $item['Comprometido'];

                        // Verificar si el Disponible es inferior o igual al Pventa después de la actualización
                        $porcentajeLimite = 0.5; // 50%
                        $limiteSugerido = $porcentajeLimite * $item['Cantidad'];
                        $item['Sugerido'] = ($item['Disponible'] <= $limiteSugerido) ? $item['Cantidad'] : 0;

                        // Loggear información adicional sobre el Sugerido
                        Log::channel('solcompraalmacen')->info('ItemCode ' . $item['ItemCode'] . ': Sugerido: ' . $item['Sugerido']);

                        // Agregar el artículo al array de artículos filtrados solo si cumple con la condición
                        if (isset($item['Sugerido']) && $item['Sugerido'] !== 0) {
                            $filteredItems[] = $item;
                        }
                    }
                }
            }

            // Eliminar elementos con Sugerido igual a 0 o no definido
            $filteredItems = array_filter($filteredItems, function ($item) {
                return isset($item['Sugerido']) && $item['Sugerido'] !== 0;
            });

            // Almacenar en la base de datos
            $this->almacenarEnBD($filteredItems);

            // Retornar la respuesta en formato JSON
            return response()->json(['value' => array_values($filteredItems)]);
        } catch (\Exception $e) {
            // Manejar errores y loggearlos
            Log::channel('solcompraalmacen')->info('Error en consumirpromedioventaSAP: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, ocurrió un error: ' . $e->getMessage()], 500);
        }
    }






    public function almacenarEnBD($data)
    {
        $docEntriesToVerify = [];

        foreach ($data as $item) {
            // Reemplazar la coma por un punto en 'Disponible' y 'Sugerido'
            $disponible = str_replace(',', '.', $item['Disponible']);
            $sugerido = str_replace(',', '.', $item['Sugerido']);

            // Verificar y asignar un valor específico para el campo 'Almacen'
            $almacen = ($item['Almacen'] == 'MEDELLIN') ? '01' : (($item['Almacen'] == 'SABANETA') ? '04' : (($item['Almacen'] == 'RIONEGRO') ? '08' : (($item['Almacen'] == 'COPACABANA') ? '15' : $item['Almacen'])));


            // Verificar si el artículo ya existe en la tabla historial y el almacén es igual
            $existingItem = SolicitudesCompraHistorialeAlmacene::where('item_id', $item['ItemCode'])
                ->where('WarehouseCode', $almacen)
                ->first();

            if ($existingItem) {
                // Obtener el doc_entry si existe
                $docEntry = $existingItem->doc_entry;

                // Registrar en el log solo el artículo, la bodega y el DocEntry
                $logDetails = [
                    'ItemCode' => $item['ItemCode'],
                    'Almacen' => $almacen,
                    'DocEntry' => $docEntry,
                ];
                Log::channel('solcompraalmacen')->info("Artículo ya existe en el historial con el mismo almacén. Detalles: " . json_encode($logDetails));

                // Almacenar $docEntry en el array
                $docEntriesToVerify[] = [
                    'docEntry' => $docEntry,
                    'bodega' => $almacen,
                ];
            }

            // El artículo no existe en la tabla historial con el mismo almacén, puedes proceder a almacenarlo en la tabla Abastesimiento
            $abastecimientoData = [
                'ItemCode' => $item['ItemCode'],
                'Dscription' => $item['Dscription'],
                'SWeight1' => $item['SWeight1'],
                'SubGrupo' => $item['SubGrupo'],
                'Almacen' => $item['Almacen'],
                'Stock' => $item['Stock'],
                'Comprometido' => $item['Comprometido'],
                'Pedido' => $item['Pedido'],
                'Disponible' => $disponible,
                'Sugerido' => $sugerido,
                'Cantidad' => $item['Cantidad'],
                'id_' => $item['id_'],
            ];

            AbastecimientoAlmacene::create($abastecimientoData);
        }

        // Llamar a verificarSolicitud para cada $docEntry válido
        foreach ($docEntriesToVerify as $verificationData) {
            $docEntry = $verificationData['docEntry'];
            $bodega = $verificationData['bodega'];

            $verificationResult = $this->verificarSolicitud($docEntry, $bodega);

            // Verificar si la respuesta contiene la clave 'DocumentLines'
            if (isset($verificationResult['solicitudLineItems'])) {
                // Iterar sobre los elementos de DocumentLines y actualizar la base de datos si es necesario
                foreach ($verificationResult['solicitudLineItems'] as $lineItem) {
                    // Obtener el ItemCode y el DocumentStatus de la respuesta
                    $itemCode = $lineItem['ItemCode'];
                    $documentStatus = $lineItem['DocumentStatus'] ?? null;

                    // Buscar el registro en la base de datos por ItemCode
                    $existingRecord = SolicitudesCompraHistorialeAlmacene::where('item_id', $itemCode)
                        ->where('WareHouseCode', $bodega)
                        ->first();

                    if ($existingRecord) {
                        // Actualizar DocumentStatus si el registro existe
                        $existingRecord->update(['DocumentStatus' => $documentStatus]);

                        // Verificar si DocumentStatus es 'bost_Open' y actualizar existencia_arti_historial en Abastesimiento
                        if ($documentStatus === 'bost_Open') {
                            $abastecimientoRecord = AbastecimientoAlmacene::where('ItemCode', $existingRecord->item_id)->first();

                            if ($abastecimientoRecord) {
                                $abastecimientoRecord->update(['existencia_arti_historial' => true]);
                                // Registrar en el log la actualización de existencia_arti_historial en Abastesimiento
                                Log::channel('solcompraalmacen')->info("Se actualizó existencia_arti_historial para ItemCode $itemCode en la tabla Abastesimiento.");
                            } else {
                                // Agregar un log si no se encontró el registro en la tabla Abastesimiento
                                Log::channel('solcompraalmacen')->info("No se encontró registro en la tabla Abastesimiento para ItemCode $itemCode.");
                            }
                        }

                        // Registrar en el log la actualización
                        Log::channel('solcompraalmacen')->info("Se actualizó DocumentStatus para ItemCode $itemCode y WareHouseCode $bodega. Nuevo valor: " . ($documentStatus ?? 'N/A'));
                    } else {
                        // Registrar en el log si no se encontró ningún registro en la base de datos
                        Log::channel('solcompraalmacen')->info("No se encontró registro en la base de datos para ItemCode $itemCode y WareHouseCode $bodega");
                    }
                }
            } else {
                // Agregar un log si la respuesta no contiene 'DocumentLines'
                Log::channel('solcompraalmacen')->info("La respuesta no contiene la clave 'DocumentLines'");
            }
        }
    }




    public function generarSolicitudCompraAPIalmacen(Request $request)
    {
        try {
            // Obtener el usuario autenticado y las credenciales SAP del usuario
            $user = Auth::user();
            $sapUsername = $user->usersap;
            $sapPassword = $user->usersappassword;

            // Configuración de SAP
            
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');

            // Cliente Guzzle para realizar solicitudes HTTP
            $client = new Client();

            // Iniciar sesión en SAP
            $loginUrl = $sapBaseUrl . '/Login';
            $loginBody = [
                'CompanyDB' => $sapCompanyDB,
                'Password' => $sapPassword,
                'UserName' => $sapUsername,
            ];

            $response = $client->post($loginUrl, ['json' => $loginBody]);
            $data = json_decode($response->getBody(), true);
            $sessionId = $data['SessionId'];
            $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

            // Obtener datos de la solicitud desde la solicitud HTTP
            $selectedItems = $request->input('selectedItems');
            $sugeridos = $request->input('sugeridos');
            $bodega = $request->input('bodega');
            $fechaRequerida = $request->input('fecharequerida');

            // Validar si se han seleccionado elementos
            if (empty($selectedItems)) {
                return response()->json(['error' => 'No se han seleccionado elementos para la solicitud de compra.'], 400);
            }

            // Estructura de datos para la solicitud de compra
            $purchaseRequestData = [
                "RequriedDate" => $fechaRequerida,
                "Comments" => "MRP-Almacen, Ejecutado por sistema GTD",
                "Document_ApprovalRequests" => [],
                "DocumentLines" => [],
            ];

            // Mapeo de valores para la bodega, sede y departamento
            $bodegaValues = [
                'SABANETA' => '04',
                'MEDELLIN' => '01',
                'COPACABANA' => '15',
                'RIONEGRO' => '08',
            ];
            $sedeValues = ['04' => 'SAB', '01' => 'MED', '15' => 'COP' , '08' => 'RIO'];
            $departamentoValues = ['SAB' => 'ALMA', 'MED' => 'ALMA', 'COP' => 'ALMA', 'RIO'=> 'ALMA'];

            // Mapear valores de bodega, sede y departamento
            $bodega = is_numeric($bodega) ? $bodega : ($bodegaValues[$bodega] ?? $bodega);
            $sede = $sedeValues[$bodega] ?? $bodega;
            $departamento = $departamentoValues[$sede] ?? $sede;

            $errors = [];
            $articulosConSolicitudesAbiertas = [];
            Log::channel('solcompraalmacen')->info('Inicio de la función generarSolicitudCompraAPI');


            // Procesar cada elemento seleccionado
            foreach ($selectedItems as $itemId) {
                Log::channel('solcompraalmacen')->info('Procesando elemento con ID: ' . $itemId);
                $abastecimiento = AbastecimientoAlmacene::find($itemId);

                // Validar si se encontró información para el elemento seleccionado
                if (!$abastecimiento) {
                    $errors[] = 'No se pudo encontrar información para el elemento seleccionado.';
                }

                // Verificar si el ItemCode validado está presente en solicitudes_comprahistoriales
                $existingHistoriales = SolicitudesCompraHistorialeAlmacene::where('item_id', $abastecimiento->ItemCode)
                    ->where('WareHouseCode', $bodega)
                    ->get();

                $sugeridoIndex = array_search($itemId, $selectedItems);
                $sugerido = isset($sugeridos[$sugeridoIndex]) ? $sugeridos[$sugeridoIndex] : $abastecimiento->Sugerido;

                // Verificar si no hay registros en solicitudes_comprahistoriales
                if ($existingHistoriales->isEmpty()) {
                    // No hay solicitudes de compra históricas, continuar sin ejecutar el metodo verificarSolicitud()
                    $purchaseRequestData['DocumentLines'][] = [
                        "ItemCode" => $abastecimiento->ItemCode,
                        "Quantity" => $sugerido,
                        "CostingCode4" => $departamento,
                        "ProjectCode" => $sede,
                        "CostingCode" => $sede,
                        "CostingCode3" => "CMS",
                        "TaxCode" => "IVAD01",
                        "WarehouseCode" => $bodega,
                        "TaxLiable"=> "Y",
                    ];

                    // Continuar con el siguiente elemento en el bucle
                    continue;
                }

                $latestDocEntry = null; // Variable para almacenar el último doc_entry

                // Mover la asignación de latestDocEntry aquí
                if ($existingHistoriales->isNotEmpty()) {
                    $latestDocEntry = $existingHistoriales->last()->doc_entry;
                }

                // Verificar si hay una solicitud de compra abierta para el mismo artículo y la misma bodega
                $verificationResult = $this->verificarSolicitud($latestDocEntry);

                // Obtener la respuesta JSON de la función
                $responseContent = json_decode($verificationResult['response']->getBody(), true);

                // Agregar un log para registrar la ejecución de la segunda consulta
                Log::channel('solcompraalmacen')->info('Ejecución de la segunda consulta para DocEntry ' . $latestDocEntry);

                // Verificar si la respuesta contiene la clave 'DocumentLines'
                if (isset($responseContent['DocumentLines'])) {
                    // Iterar sobre los elementos de DocumentLines y actualizar la base de datos si es necesario
                    foreach ($responseContent['DocumentLines'] as $lineItem) {
                        // Obtener el ItemCode y el DocumentStatus de la respuesta
                        $itemCode = $lineItem['ItemCode'];
                        $documentStatus = $lineItem['LineStatus'] ?? null;

                        // Buscar el registro en la base de datos por ItemCode
                        $existingRecord = SolicitudesCompraHistorialeAlmacene::where('item_id', $itemCode)
                            ->where('WareHouseCode', $bodega)
                            ->first();

                        if ($existingRecord) {
                            // Actualizar DocumentStatus si el registro existe
                            $existingRecord->update(['DocumentStatus' => $documentStatus]);
                            if ($documentStatus === 'bost_Open') {
                                AbastecimientoAlmacene::where('ItemCode', $existingRecord->item_id)
                                    ->update(['existencia_arti_historial' => true]);
                            }


                            // Registrar en el log la actualización
                            Log::channel('solcompraalmacen')->info("Se actualizó DocumentStatus para ItemCode $itemCode y WareHouseCode $bodega. Nuevo valor: " . ($documentStatus ?? 'N/A'));
                            // Registrar en el log la actualización de existencia_arti_historial
                            Log::channel('solcompraalmacen')->info("Se actualizó existencia_arti_historial para ItemCode $itemCode.");
                        } else {
                            // Registrar en el log si no se encontró ningún registro en la base de datos
                            Log::channel('solcompraalmacen')->info("La respuesta no contiene la clave 'DocumentLines'");
                        }
                    }
                } else {
                    // Agregar un log si la respuesta no contiene 'DocumentLines'
                    Log::channel('solcompraalmacen')->info("La respuesta no contiene la clave 'DocumentLines'");
                }

                if ($latestDocEntry !== null) {
                    Log::channel('solcompraalmacen')->info('El último doc_entry para el ItemCode ' . $abastecimiento->ItemCode . ' es: ' . $latestDocEntry);
                }

                // Agregar esta línea para registrar el ItemCode
                Log::channel('solcompraalmacen')->info('ItemCode validado: ' . $abastecimiento->ItemCode);

                $sugeridoIndex = array_search($itemId, $selectedItems);
                $sugerido = isset($sugeridos[$sugeridoIndex]) ? $sugeridos[$sugeridoIndex] : $abastecimiento->Sugerido;

                // Verificar si el DocumentStatus es 'bost_Open' y mostrar un mensaje de error
                // if ($documentStatus === 'bost_Open') {
                //     $errors[] = "Ya hay una solicitud de compra abierta para el artículo $abastecimiento->ItemCode en la bodega $bodega.";
                //     $articulosConSolicitudesAbiertas[] =   "Ya hay una solicitud de compra abierta para el artículo $abastecimiento->ItemCode en la bodega $bodega.";
                // } else {
                //     $purchaseRequestData['DocumentLines'][] = [
                //         "ItemCode" => $abastecimiento->ItemCode,
                //         "Quantity" => $sugerido,
                //         "CostingCode4" => $departamento,
                //         "ProjectCode" => $sede,
                //         "CostingCode" => $sede,
                //         "CostingCode3" => "PDS",
                //         "TaxCode" => "IVAD01",
                //         "WarehouseCode" => $bodega,
                //     ];
                // }
                $documentStatus === 'bost_Open';



                $purchaseRequestData['DocumentLines'][] = [
                    "ItemCode" => $abastecimiento->ItemCode,
                    "Quantity" => $sugerido,
                    "CostingCode4" => $departamento,
                    "ProjectCode" => $sede,
                    "CostingCode" => $sede,
                    "CostingCode3" => "PDS",
                    "TaxCode" => "IVAD01",
                    "WarehouseCode" => $bodega,
                ];
            }

            // Después del bucle foreach
            if (!empty($articulosConSolicitudesAbiertas)) {
                return response()->json(['success' => false, 'error' => $errors, 'articulosConSolicitudesAbiertas' => $articulosConSolicitudesAbiertas], 400);
            }

            Log::channel('solcompraalmacen')->info('Datos enviados a SAP:', $purchaseRequestData);

            // Enviar la solicitud de compra a SAP
            $apiUrl = $sapBaseUrl . '/PurchaseRequests';
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
                'json' => $purchaseRequestData,
            ]);

            $responseBody = json_decode($response->getBody(), true);

            // Manejar la respuesta de SAP según tus necesidades
            if (isset($responseBody['DocumentLines'])) {
                $solicitudesCompraData = [];

                foreach ($responseBody['DocumentLines'] as $documentLine) {
                    $solicitudesCompraData[] = [
                        'doc_entry' => $responseBody['DocEntry'],
                        'doc_num' => $responseBody['DocNum'],
                        'item_id' => $documentLine['ItemCode'],
                        'data' => json_encode($documentLine),
                        'DocumentStatus' => $responseBody['DocumentStatus'],
                        'WarehouseCode' => $documentLine['WarehouseCode'],
                        'Fecha_contabilizacion' => $responseBody['DocDate'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Log::channel('solcompraalmacen')->info("Operación exitosa. DocNum: " . $responseBody['DocNum']);
                // Guardar en la tabla de historial
                SolicitudesCompraHistorialeAlmacene::insert($solicitudesCompraData);
                AbastecimientoAlmacene::truncate();
                return response()->json(['success' => true, 'DocNum' => $responseBody['DocNum']]);
            } else {
                // La operación no fue exitosa
                $errorDetails = $responseBody['error']['message']['value'] ?? null;

                return response()->json(['success' => false, 'error' => $errorDetails ?? 'Error en la respuesta de SAP', 'body' => $responseBody], $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Captura la respuesta completa del servidor en caso de error
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $reasonPhrase = $response->getReasonPhrase();
            $body = $response->getBody()->getContents();

            // Loguea la respuesta completa del servidor
            Log::channel('solcompraalmacen')->info("Error en la solicitud: Status Code: $statusCode, Reason: $reasonPhrase, Body: $body");

            // Decodifica el cuerpo de la respuesta si es JSON
            $errorBody = json_decode($body, true);

            // Manejar errores específicos de tu aplicación aquí
            if ($statusCode == 400) {
                // Código para manejar el error específico de SAP
                $sapErrorMessage = $errorBody['error']['message']['value'] ?? 'Error en la respuesta de SAP';
                return response()->json(['error' => $sapErrorMessage, 'body' => $errorBody], $statusCode);
            }

            // Devuelve una respuesta JSON con información sobre el error
            return response()->json(['error' => 'Error al realizar la solicitud a SAP', 'statusCode' => $statusCode, 'body' => $errorBody], $statusCode);
        }
    }







    public function verificarSolicitud($sapDocEntry)
    {
        try {
            // Configuración de conexión a SAP 
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

            $client = new Client();

            $loginUrl = $sapBaseUrl . '/Login';
            $loginBody = [
                'CompanyDB' => $sapCompanyDB,
                'Password' => $sapPassword,
                'UserName' => $sapUsername,
            ];

            $response = $client->post($loginUrl, [
                'json' => $loginBody,
            ]);

            $data = json_decode($response->getBody(), true);
            $sessionId = $data['SessionId'];

            $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

            // Realizar la verificación de SAP
            $ventasUrl = $sapBaseUrl . "/PurchaseRequests($sapDocEntry)?\$select=DocEntry,DocumentStatus,DocNum,DocumentLines";

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);

            $body = $response->getBody();
            $sapData = json_decode($body, true);

            // Procesar la respuesta de SAP
            $solicitudLineItems = [];

            if (isset($sapData['DocumentLines']) && is_array($sapData['DocumentLines'])) {
                foreach ($sapData['DocumentLines'] as $line) {
                    $itemCode = $line['ItemCode'];

                    $solicitudLineItems[] = [
                        'LineNum' => $line['LineNum'],
                        'ItemCode' => $itemCode,
                        'ItemDescription' => $line['ItemDescription'],
                        'DocEntry' => $line['DocEntry'],
                        'DocumentStatus' => $line['LineStatus']
                    ];
                }
            }

            return ['solicitudLineItems' => $solicitudLineItems, 'response' => $response];
        } catch (\Exception $e) {
            // Manejo de excepciones
            Log::channel('solcompraalmacen')->info('Error en verificarSolicitud: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, ocurrió un error: ' . $e->getMessage()], 500);
        }
    }


    public function consultarstockarticulosSAPAlmacen(Request $request)
    {
        $client = new Client();
        $sapBaseUrl = env('URI');
        $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
        $sapUsername = env('USER');
        $sapPassword = env('PASSWORD');

        // Autenticación y obtención de SessionId
        $response = $client->post($sapBaseUrl . '/Login', [
            'json' => [
                'CompanyDB' => $sapCompanyDB,
                'Password' => $sapPassword,
                'UserName' => $sapUsername,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $sessionId = $data['SessionId'];
        $cookie = "B1SESSION=" . $sessionId . "; ROUTEID=.node4";

        // Obtener el ItemCode del cuerpo de la solicitud
        $codigoArticulo = $request->input('codigoArticuloSAP');

        // Consulta de Items
        $response = $client->get($sapBaseUrl . '/Items', [
            'query' => [
                '$filter' => "ItemCode eq '$codigoArticulo'",
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Cookie' => $cookie,
            ],
        ]);

        $json = json_decode($response->getBody(), true);
        $items = $json['value'];

        // Procesar la respuesta
        $result = [];

        foreach ($items as $item) {
            $itemCode = $item['ItemCode'];

            $itemStock = [];

            foreach ($items as $item) {
                $itemCode = $item['ItemCode'];

                $itemStock = [];

                foreach ($item['ItemWarehouseInfoCollection'] as $warehouseInfo) {
                    $warehouseCode = $warehouseInfo['WarehouseCode'];
                    $inStock = $warehouseInfo['InStock'];
                    $Ordered = $warehouseInfo['Ordered'];
                    $Committed = $warehouseInfo['Committed'];

                    // Solo agregar al resultado para almacenes '08', '12', '15'
                    if (in_array($warehouseCode, ['08', '01', '15','04'])) {
                        // Calcular el disponible
                        $disponible = $inStock + $Ordered - $Committed;

                        $itemStock[] = [
                            'WarehouseCode' => $warehouseCode,
                            'InStock' => $inStock,
                            'Ordered' => $Ordered,
                            'Committed' => $Committed,
                            'Disponible' => $disponible,
                        ];
                    }
                }

                $result[] = [
                    'ItemCode' => $itemCode,
                    'ItemStock' => $itemStock,
                    'WarehouseCode' => $warehouseCode,
                    'InStock' => $inStock,
                    'Disponible' => $disponible,
                ];
            }
        }

        return response()->json($result);
    }
}