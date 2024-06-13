<?php

namespace App\Http\Controllers\Logistica\AbastecimientoMRPSAP;

use App\Http\Controllers\Controller;
use App\Models\Logistica\Abastesimiento;
use App\Models\Logistica\SolicitudesComprahistoriale;
use App\Models\TrasferenciaStock\TransferenciaStock;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbastecimientoController extends Controller
{
    public function Abastecimiento_MRP_SAP()
    {
        $abastecimientos = Abastesimiento::all();
        $transferenciastock = TransferenciaStock::all();
        return view('Logistica.AbastecimientoMRP.index', compact('abastecimientos','transferenciastock'));
    }




    public function consumirpromedioventaSAP(Request $request,)
    {
        try {
            Log::info('se ejecuto funcion');
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

            // Llamada a la función para consultar la transferencia de stock
            $transferenciaStockResponse = $this->ConsultarTrasferenciaStockSAP();
            $transferenciaStock = json_decode($transferenciaStockResponse->getContent(), true);


            $calcularSugerido = $request->input('calcularSugerido');
            // Convertir el valor a booleano
            $calcularSugerido = ($calcularSugerido === "Si") ? true : false;


            $fechaInicio = $request->input('FechaInicio');
            $fechaFin = $request->input('FechaFin');
            $bodegaCompleta = $request->input('bodega');

            // Separar los valores usando el delimitador (|) para obtener la bodega principal y la otra bodega
            list($almacen, $otraBodega) = explode('|', $bodegaCompleta);

            // Eliminar registros existentes 
            TransferenciaStock::truncate();
            Abastesimiento::truncate();

            // Lógica de filtrado basada en la bodega principal seleccionada
            $campoControlEx = '';
            if ($almacen === 'RIONEGRO') {
                $campoControlEx = 'U_DOB_ControlEx';
            } elseif ($almacen === 'LA 33') {
                $campoControlEx = 'U_DOB_ControlEx33';
            } elseif ($almacen === 'COPACABANA') {
                $campoControlEx = 'U_DOB_ControlExCop';
            }

            // Verificar que se haya asignado un valor válido para el campo U_DOB_ControlEx
            if (empty($campoControlEx)) {
                // Manejar el caso en que no se haya asignado un valor válido
                return response()->json(['error' => 'Bodega no válida'], 400);
            }

            // Construir la URL de la consulta con ambos valores de bodegas
            $ventasUrl = $sapBaseUrl . "/sml.svc/PRM_VENTAS?\$filter={$campoControlEx} eq 'Si' and (Almacen eq '{$almacen}' or Almacen eq '{$otraBodega}')&\$select=ItemCode,Dscription,SWeight1,SubGrupo,Almacen,Stock,Comprometido,Pedido,Pventa,id__";
            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            $filteredItems = [];

            // Iterar sobre los datos de los artículos obtenidos
            foreach ($data['value'] as &$item) {
                // Iterar sobre los datos de transferencia de stock para encontrar información correspondiente al ItemCode actual
                foreach ($transferenciaStock['value'] as $transferItem) {
                    if ($transferItem['COD_ARTI'] === $item['ItemCode']) {
                        // Agregar la cantidad de transferencia al artículo actual
                        $item['CANTIDAD_TRASLADO'] = $transferItem['CANTIDAD_TRASLADO'];
                        // Agregar el artículo al array de artículos filtrados
                        $filteredItems[] = $item;

                        // Definir un array de mapeo para traducir los valores de $almacen
                        $mapeoAlmacenes = [
                            'LA 33' => '12',
                            'COPACABANA' => '15',
                            'RIONEGRO' => '08'
                        ];

                        // Obtener el valor correspondiente a $almacen del array de mapeo
                        $valorAlmacenFinal = $mapeoAlmacenes[$almacen] ?? null;

                        // Verificar si el almacén final coincide con la bodega principal
                        if ($transferItem['ALMACEN_FINAL'] == $valorAlmacenFinal) {
                            // Guardar en la tabla transferencia_stocks
                            \App\Models\TrasferenciaStock\TransferenciaStock::create([
                                'SOLICITUD_TRASLADO' => $transferItem['SOLICITUD_TRASLADO'],
                                'COD_ARTI' => $transferItem['COD_ARTI'],
                                'BODEGA_ORIGEN' => $transferItem['BODEGA_ORIGEN'],
                                'BODEGA_TRANSITO' => $transferItem['BODEGA_TRANSITO'],
                                'ALMACEN_FINAL' => $transferItem['ALMACEN_FINAL'],
                                'CANTIDAD_TRASLADO' => $transferItem['CANTIDAD_TRASLADO'],
                            ]);

                            // Loggear el artículo encontrado, la cantidad de transferencia y el almacén final
                            // Log::info('Artículo encontrado: ' . json_encode($item) . ', SOLICITUD_TRASLADO' . $transferItem['SOLICITUD_TRASLADO'] . ', COD_ARTI' . $transferItem['COD_ARTI'] . ', BODEGA_ORIGEN' . $transferItem['BODEGA_ORIGEN'] . ', BODEGA_TRANSITO' . $transferItem['BODEGA_TRANSITO'] . ', ALMACEN_FINAL ' . $transferItem['ALMACEN_FINAL'] . ', CANTIDAD_TRASLADO ' . $transferItem['CANTIDAD_TRASLADO']);
                        }

                        break; // Salir del bucle interno una vez encontrado el artículo correspondiente
                    }
                }
            }


            // Nuevo array para almacenar los artículos filtrados
            $filteredItems = [];

            // Log para los artículos excluidos y los ItemCode de los artículos que pasan a la vista
            $excludedItemsLog = [];

            // Nuevo array para almacenar los Pventa excluidos
            $excludedItemsPventa = [];

            // Calcular el campo "Disponible" y "Sugerido" para cada artículo
            foreach ($data['value'] as &$item) {
                // Filtrar artículos con "PROMO" o "REMASQUE" solo si se debe calcular el Sugerido
                if ($calcularSugerido && (strpos($item['Almacen'], 'PROMO') !== false || strpos($item['Almacen'], 'REMASQUE') !== false)) {
                    // Loggear los artículos excluidos
                    // Log::info('Artículo excluido: ' . json_encode($item));

                    // Almacenar el Pventa del artículo excluido para sumarlo después
                    $excludedItemsPventa[$item['ItemCode']] = $item['Pventa'];

                    // Loggear información adicional sobre el Pventa excluido
                    // Log::info('Pventa excluido para ItemCode ' . $item['ItemCode'] . ': ' . $excludedItemsPventa[$item['ItemCode']]);
                } else {
                    // Loggear información adicional sobre el artículo que pasa a la vista
                    // Log::info('ItemCode del artículo que pasa a la vista: ' . json_encode($item));

                    // Verificar si hay Pventa excluido para este ItemCode y sumarlo al Pventa del artículo que pasa a la vista
                    if (isset($excludedItemsPventa[$item['ItemCode']])) {
                        // Loggear información antes de la actualización
                        // Log::info('ItemCode ' . $item['ItemCode'] . ': Pventa antes de la actualización: ' . $item['Pventa']);

                        // Sumar el Pventa del artículo excluido al Pventa del artículo que pasa a la vista
                        $item['Pventa'] = $item['Pventa'] + $excludedItemsPventa[$item['ItemCode']];

                        // Loggear información después de la actualización
                        // Log::info('ItemCode ' . $item['ItemCode'] . ': Pventa después de la actualización: ' . $item['Pventa']);

                        // Dividir el Pventa resultante por 6
                        $item['Pventa'] = intval($item['Pventa'] / 6);

                        // Verificar si el resultado no es un número entero y redondear hacia arriba o hacia abajo según tus necesidades
                        if (!is_int($item['Pventa'])) {
                            $item['Pventa'] = round($item['Pventa']); // Puedes ajustar esto según tus necesidades
                        }

                        // Loggear información adicional sobre el artículo que pasa a la vista con Pventa actualizado
                        // Log::info('ItemCode ' . $item['ItemCode'] . ': Pventa después de la división por 6: ' . $item['Pventa']);
                    } else {
                        // Si no hay Pventa excluido, simplemente dividir el Pventa por 6
                        $item['Pventa'] = intval($item['Pventa'] / 6);

                        // Verificar si el resultado no es un número entero y redondear hacia arriba o hacia abajo según tus necesidades
                        if (!is_int($item['Pventa'])) {
                            $item['Pventa'] = round($item['Pventa']); // Puedes ajustar esto según tus necesidades
                        }

                        // Loggear información después de la actualización
                        // Log::info('ItemCode ' . $item['ItemCode'] . ': Pventa después de la actualización: ' . $item['Pventa']);

                        // Establecer la clave "Disponible" en el array
                        $item['Disponible'] = $item['Stock'] + $item['Pedido'] - $item['Comprometido'];

                        // Calcular el "Sugerido" solo si se debe calcular
                        if ($calcularSugerido) {
                            $porcentajeLimite = 0.5; // 50%
                            $limiteSugerido = $porcentajeLimite * $item['Pventa'];
                            $item['Sugerido'] = ($item['Disponible'] <= $limiteSugerido) ? $item['Pventa'] : 0;

                            // Loggear información adicional sobre el Sugerido
                            // Log::info('ItemCode ' . $item['ItemCode'] . ': Sugerido: ' . $item['Sugerido']);

                            // Agregar el artículo al array de artículos filtrados solo si cumple con la condición
                            if (isset($item['Sugerido']) && $item['Sugerido'] !== 0) {
                                $filteredItems[] = $item;
                            }
                        } else {
                            // Si no se calcula el Sugerido, simplemente asignamos el Pventa como Sugerido
                            $item['Sugerido'] = $item['Pventa'];

                            // Agregar el artículo al array de artículos filtrados
                            $filteredItems[] = $item;
                        }
                    }
                }
            }

            // Eliminar elementos con Sugerido igual a 0 o no definido
            foreach ($filteredItems as $key => $item) {
                if ($item['Sugerido'] === 0 || !isset($item['Sugerido'])) {
                    unset($filteredItems[$key]);
                }
            }

            $this->almacenarEnBD($filteredItems);
            return response()->json(['value' => array_values($filteredItems)]);
        } catch (\Exception $e) {
            Log::error('Error en consumirpromedioventaSAP: ' . $e->getMessage());
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
            $almacen = ($item['Almacen'] == 'LA 33') ? '12' : (($item['Almacen'] == 'RIONEGRO') ? '08' : (($item['Almacen'] == 'COPACABANA') ? '15' : $item['Almacen']));

            // Verificar si el artículo ya existe en la tabla historial y el almacén es igual
            $existingItem = SolicitudesCompraHistoriale::where('item_id', $item['ItemCode'])
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
                // Log::info("Artículo ya existe en el historial con el mismo almacén. Detalles: " . json_encode($logDetails));

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
                'Pventa' => $item['Pventa'],
                'id__' => $item['id__'],
            ];

            Abastesimiento::create($abastecimientoData);
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
                    $existingRecord = SolicitudesComprahistoriale::where('item_id', $itemCode)
                        ->where('WareHouseCode', $bodega)
                        ->first();

                    if ($existingRecord) {
                        // Actualizar DocumentStatus si el registro existe
                        $existingRecord->update(['DocumentStatus' => $documentStatus]);

                        // Verificar si DocumentStatus es 'bost_Open' y actualizar existencia_arti_historial en Abastesimiento
                        if ($documentStatus === 'bost_Open') {
                            $abastecimientoRecord = Abastesimiento::where('ItemCode', $existingRecord->item_id)->first();

                            if ($abastecimientoRecord) {
                                $abastecimientoRecord->update(['existencia_arti_historial' => true]);
                                // Registrar en el log la actualización de existencia_arti_historial en Abastesimiento
                                // Log::info("Se actualizó existencia_arti_historial para ItemCode $itemCode en la tabla Abastesimiento.");
                            } else {
                                // Agregar un log si no se encontró el registro en la tabla Abastesimiento
                                // Log::warning("No se encontró registro en la tabla Abastesimiento para ItemCode $itemCode.");
                            }
                        }

                        // Registrar en el log la actualización
                        // Log::info("Se actualizó DocumentStatus para ItemCode $itemCode y WareHouseCode $bodega. Nuevo valor: " . ($documentStatus ?? 'N/A'));
                    } else {
                        // Registrar en el log si no se encontró ningún registro en la base de datos
                        // Log::warning("No se encontró registro en la base de datos para ItemCode $itemCode y WareHouseCode $bodega");
                    }
                }
            } else {
                // Agregar un log si la respuesta no contiene 'DocumentLines'
                // Log::warning("La respuesta no contiene la clave 'DocumentLines'");
            }
        }
    }




    public function ConsultarTrasferenciaStockSAP()
    {

        try {
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

            $client = new Client();

            // Login
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

            // Consulta con filtro por DocEntry específico
            $ventasUrl = $sapBaseUrl . "/sml.svc/SOLICITUDES_TRASLADO";

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => 'Se produjo un error al hacer la petición SAP: ' . $e->getMessage()]);
        }
    }






    public function generarSolicitudCompraAPI(Request $request)
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
                "Comments" => "MRP ejecutado por sistema GTD",
                "Document_ApprovalRequests" => [],
                "DocumentLines" => [],
            ];

            // Mapeo de valores para la bodega, sede y departamento
            $bodegaValues = [
                'RIONEGRO|PROMO Y REMASQUE RIONEGRO' => '08',
                'LA 33|PROMO Y REMASQUE LA 33' => '12',
                'COPACABANA|PROMO Y REMASQUE COPACABANA' => '15',
            ];
            $sedeValues = ['08' => 'RIO', '12' => 'LA33', '15' => 'COP'];
            $departamentoValues = ['RIO' => 'RION', 'LA33' => 'SD33', 'COP' => 'COPA'];

            // Mapear valores de bodega, sede y departamento
            $bodega = is_numeric($bodega) ? $bodega : ($bodegaValues[$bodega] ?? $bodega);
            $sede = $sedeValues[$bodega] ?? $bodega;
            $departamento = $departamentoValues[$sede] ?? $sede;

            $errors = [];
            $articulosConSolicitudesAbiertas = [];
            Log::info('Inicio de la función generarSolicitudCompraAPI');

            // Procesar cada elemento seleccionado
            foreach ($selectedItems as $itemId) {
                Log::info('Procesando elemento con ID: ' . $itemId);
                $abastecimiento = Abastesimiento::find($itemId);

                // Validar si se encontró información para el elemento seleccionado
                if (!$abastecimiento) {
                    $errors[] = 'No se pudo encontrar información para el elemento seleccionado.';
                }

                // Verificar si el ItemCode validado está presente en solicitudes_comprahistoriales
                $existingHistoriales = SolicitudesCompraHistoriale::where('item_id', $abastecimiento->ItemCode)
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
                        "CostingCode3" => "PDS",
                        "TaxCode" => "IVAD01",
                        "WarehouseCode" => $bodega,
                        "TaxLiable" => "Y",
                    ];

            
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
                Log::info('Ejecución de la segunda consulta para DocEntry ' . $latestDocEntry);

                // Verificar si la respuesta contiene la clave 'DocumentLines'
                if (isset($responseContent['DocumentLines'])) {
                    // Iterar sobre los elementos de DocumentLines y actualizar la base de datos si es necesario
                    foreach ($responseContent['DocumentLines'] as $lineItem) {
                        // Obtener el ItemCode y el DocumentStatus de la respuesta
                        $itemCode = $lineItem['ItemCode'];
                        $documentStatus = $lineItem['LineStatus'] ?? null;

                        // Buscar el registro en la base de datos por ItemCode
                        $existingRecord = SolicitudesComprahistoriale::where('item_id', $itemCode)
                            ->where('WareHouseCode', $bodega)
                            ->first();

                        if ($existingRecord) {
                            // Actualizar DocumentStatus si el registro existe
                            $existingRecord->update(['DocumentStatus' => $documentStatus]);
                            if ($documentStatus === 'bost_Open') {
                                Abastesimiento::where('ItemCode', $existingRecord->item_id)
                                    ->update(['existencia_arti_historial' => true]);
                            }


                            // Registrar en el log la actualización
                            Log::info("Se actualizó DocumentStatus para ItemCode $itemCode y WareHouseCode $bodega. Nuevo valor: " . ($documentStatus ?? 'N/A'));
                            // Registrar en el log la actualización de existencia_arti_historial
                            Log::info("Se actualizó existencia_arti_historial para ItemCode $itemCode.");
                        } else {
                            // Registrar en el log si no se encontró ningún registro en la base de datos
                            Log::warning("La respuesta no contiene la clave 'DocumentLines'");
                        }
                    }
                } else {
                    // Agregar un log si la respuesta no contiene 'DocumentLines'
                    Log::warning("La respuesta no contiene la clave 'DocumentLines'");
                }

                if ($latestDocEntry !== null) {
                    Log::info('El último doc_entry para el ItemCode ' . $abastecimiento->ItemCode . ' es: ' . $latestDocEntry);
                }

                // Agregar esta línea para registrar el ItemCode
                Log::info('ItemCode validado: ' . $abastecimiento->ItemCode);

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
                    "TaxRelev" => 'Y'
                ];
            }

            // Después del bucle foreach
            if (!empty($articulosConSolicitudesAbiertas)) {
                return response()->json(['success' => false, 'error' => $errors, 'articulosConSolicitudesAbiertas' => $articulosConSolicitudesAbiertas], 400);
            }

            Log::info('Datos enviados a SAP:', $purchaseRequestData);

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

                Log::info("Operación exitosa. DocNum: " . $responseBody['DocNum']);
                // Guardar en la tabla de historial
                SolicitudesCompraHistoriale::insert($solicitudesCompraData);
                Abastesimiento::truncate();
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
            Log::error("Error en la solicitud: Status Code: $statusCode, Reason: $reasonPhrase, Body: $body");

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
            Log::error('Error en verificarSolicitud: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, ocurrió un error: ' . $e->getMessage()], 500);
        }
    }
























    public function consultarStockArticulosSAP(Request $request)
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
                'Password' => $sapUsername,
                'UserName' => $sapPassword,
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
                '$filter' => "ItemCode eq '$codigoArticulo' and U_DOB_Grupo eq '04'",
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
                    if (in_array($warehouseCode, ['08', '12', '15'])) {
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
