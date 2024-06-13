<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Mail\AprobacionesSolicitudesCompra\EnviarNotificacionSolicitudAprobadaMail;
use App\Mail\AprobacionesSolicitudesCompra\EnviarSolicitudAprobaciónCompraMail;
use App\Models\AnexosSolicitudesCompra\AnexosSoliCompra;
use App\Models\DetalleSolicitudesCreditoAprobaciones;
use App\Models\MaterialesSAP\Consumibles_sap;
use App\Models\SolicitudesCreditoAprobaciones;
use App\Models\proyectosSAP\proyecto;
use App\Models\User;
use App\Models\ClientesSAP;
use Carbon\Carbon;
use CreateDetalleSolicitudCompraTable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\Else_;
use Illuminate\Support\Facades\File;
use Dotenv\Exception\ValidationException;
use phpseclib3\Net\SSH2 as NetSSH2;
use phpseclib\Net\SSH2;
class ComprasController extends Controller
{

    public function VistaPrincipal()
    {
        $materialessap = Consumibles_sap::all();
        $materialesselect = Consumibles_sap::all();
        $anexos = AnexosSoliCompra::all();
        return view('Compras.Solicitudes-compra', compact('materialessap', 'materialesselect', 'anexos'));
    }



    public function SolicitudesCreditoaplicativo()
    {
        $materialessap = Consumibles_sap::all();
        $materialesselect = Consumibles_sap::all();
        $proveedoresSAP = ClientesSAP::where('CardType', '=', 'cSupplier')
            ->where('CardCode', 'LIKE', 'P%')
            ->get();

        $projectSAP = proyecto::all();
        return view('Compras.Solicitudes-compra-aplicativo', compact('materialessap', 'materialesselect', 'proveedoresSAP','projectSAP'));
    }

    public function SolicitudesAprobardesdeaplicacion()
    {

        $usuarioaprobadorId = Auth::user()->id;

        // Retrieve all pending requests assigned to the current approver.
        $solicitudescompras = SolicitudesCreditoAprobaciones::where('estado', 'Pendiente')
            ->where('usuarioaprobador', $usuarioaprobadorId)
            ->get();

        return view('Compras.SolicitudesAprobar', compact('solicitudescompras'));
    }

    public function obtenerDetallesSolicitud($id)
    {
        try {
            $detallesSolicitud = DetalleSolicitudesCreditoAprobaciones::with('material')->where('id_solicitud_compra', $id)->get();



            return response()->json(['sucess' => $detallesSolicitud]);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return response()->json(['success' => false, 'message' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }


    public function GenerarSolicitudCompraBorrador(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $requiredFields = [
                'RequriedDate' => 'Fecha requerida',
                'RequesterName' => 'Nombre del solicitante',
                'U_HBT_AproComp' => 'Aprobación requerida',
            ];
    
            foreach ($requiredFields as $fieldName => $fieldLabel) {
                if (empty($request->input($fieldName))) {
                    return response()->json(['success' => false, 'message' => 'El campo ' . $fieldLabel . ' es obligatorio'], 400);
                }
            }
    
            $ordenventarelacionada = $request->input('RefDocNumOrder');
            if (empty($ordenventarelacionada)) {
                $ordenventarelacionada = null;
            }
    
            if ($ordenventarelacionada !== null) {
                $resultadoConsulta = $this->consultarDocEntryordenesVSAP($ordenventarelacionada);
    
                $contenidoRespuesta = json_decode($resultadoConsulta->getContent(), true);
    
                if ($resultadoConsulta->getStatusCode() === 200 && !empty($contenidoRespuesta['ventas']['DocEntry'])) {
                    $primerDocEntry = $contenidoRespuesta['ventas']['DocEntry'];
                    Log::info('DocEntry obtenido: ' . $primerDocEntry);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'La orden de venta ingresada no existe en SAP. Por favor, inténtalo nuevamente con un número de orden válido.',
                    ], 404);
                }
            } else {
                $primerDocEntry = null;
            }
    
            $generarSolicitud = new SolicitudesCreditoAprobaciones();
            $generarSolicitud->RequriedDate = $request->input('RequriedDate');
            $generarSolicitud->RequesterName = $request->input('RequesterName');
            $generarSolicitud->U_HBT_AproComp = $request->input('U_HBT_AproComp');
            $generarSolicitud->UsuarioSolicitante_id = auth()->user()->id;
            $generarSolicitud->estado = 'Pendiente';
            $generarSolicitud->RefDocNumOrder = $ordenventarelacionada;
            $generarSolicitud->DocEntryOrdenVenta = $primerDocEntry;
            $generarSolicitud->usuarioaprobador = User::where('id', $generarSolicitud->UsuarioSolicitante_id)->value('usuarioaprobador');
            $generarSolicitud->save();
    
            foreach ($request->input('itemCodes') as $index => $itemCode) {
                $requiredFields = [
                    'itemDescription' => 'Descripción',
                    'FreeText' => 'Texto libre',
                    'UnitsOfMeasurment' => 'Cantidad',
                    'TaxCode' => 'Indicador de impuesto',
                    'ProjectCode' => 'Proyecto',
                    'WarehouseCode' => 'Almacén',
                    'CostingCode' => 'Centro de operaciones',
                    'CostingCode3' => 'Centro de costos',
                    'CostingCode4' => 'Departamento',
                ];
    
                foreach ($requiredFields as $field => $fieldName) {
                    if (empty($request->input($field)[$index])) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'El campo ' . $fieldName . ' es obligatorio'], 400);
                    }
                }
    
                $cantidad = $request->input('UnitsOfMeasurment')[$index];
                $precio = $request->input('Price')[$index];
    
                if ($cantidad == -1 || $precio == -1) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'La cantidad y el precio no pueden ser -1'], 400);
                }
    
                $detalleSolicitud = new DetalleSolicitudesCreditoAprobaciones();
                $detalleSolicitud->id_solicitud_compra = $generarSolicitud->id;
                $detalleSolicitud->Materiales_id = $itemCode;
                $detalleSolicitud->Descripcion = $request->input('itemDescription')[$index];
                $detalleSolicitud->TextoLibre = $request->input('FreeText')[$index];
                $detalleSolicitud->Cantidad = $request->input('UnitsOfMeasurment')[$index];
                $detalleSolicitud->Proyecto = $request->input('ProjectCode')[$index];
                $detalleSolicitud->Almacen = $request->input('WarehouseCode')[$index];
                $detalleSolicitud->CentroOperaciones = $request->input('CostingCode')[$index];
                $detalleSolicitud->CentroCostos = $request->input('CostingCode3')[$index];
                $detalleSolicitud->Departamento = $request->input('CostingCode4')[$index];
                $detalleSolicitud->U_DOB_DescripcionAdicional = $request->input('U_DOB_DescripcionAdicional')[$index];
                $detalleSolicitud->Price = $request->input('Price')[$index];
                $detalleSolicitud->TaxCode = $request->input('TaxCode')[$index];
                $detalleSolicitud->LineVendor = $request->input('LineVendor')[$index];
                $detalleSolicitud->save();
            }
    
            $archivos = $request->file('archivos');
    
            if (!empty($archivos)) {
                $this->AlmacenarAnexosBD($archivos, $generarSolicitud);
            }
    
            DB::commit();
            $this->enviarCorreoSolicitudAprobacion($generarSolicitud, $request->input('U_HBT_AproComp'));
    
            return response()->json(['success' => true, 'message' => 'Solicitud de compra creada y guardada exitosamente']);
        } catch (ValidationException $e) {
            DB::rollBack();
    
            return response()->json(['success' => false, 'message' => 'Error de validación: ' . $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['success' => false, 'message' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }






    //Almacenar anexos solicitud de compra.
    private function AlmacenarAnexosBD($archivos, $generarSolicitud)
    {
        try {
            // Verificar si hay archivos adjuntos
            if (!empty($archivos)) {
                foreach ($archivos as $archivo) {
                    // Verificar si el archivo es válido
                    if ($archivo->isValid()) {
                        // Generar un nombre único basado en la marca de tiempo y cifrar el nombre original
                        $nombreArchivo = hash('sha256', time() . $archivo->getClientOriginalName()) . '.' . $archivo->getClientOriginalExtension();

                        // Guardar la ruta del archivo en la carpeta 'AdjuntosSolicitudCompra'
                        $rutaArchivo = 'public/AdjuntosSolicitudCompra/' . $nombreArchivo;

                        // Mover el archivo a la ubicación deseada
                        $archivo->storeAs('public/AdjuntosSolicitudCompra', $nombreArchivo);

                        // Guardar la ruta en la base de datos
                        AnexosSoliCompra::create([
                            'Ruta_documento_Adjunto' => $rutaArchivo,
                            'id_solicitud_compra' => $generarSolicitud->id,
                        ]);
                    } else {
                        // Puedes optar por no devolver un error aquí y simplemente continuar con el siguiente archivo
                        return response()->json(['success' => false, 'message' => 'Error al subir archivos'], 400);
                    }
                }
            }

            // Devolver éxito si no hay errores
            return response()->json(['success' => true, 'message' => 'Anexos almacenados exitosamente']);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return response()->json(['success' => false, 'message' => 'Error interno al almacenar anexos: ' . $e->getMessage()], 500);
        }
    }






    private function guardarAdjuntosSolicCompra($idSolicitudCompra, $archivos)
    {
        try {
            // Validar que se hayan enviado archivos
            if (empty($archivos)) {
                throw new \InvalidArgumentException('No se han proporcionado archivos adjuntos.');
            }

            // Log para verificar que se recibieron archivos
            Log::info('Archivos recibidos:', $archivos);

            // Obtener la solicitud de compra correspondiente
            $generarSolicitud = SolicitudesCreditoAprobaciones::find($idSolicitudCompra);

            // Validar que la solicitud de compra exista
            if (!$generarSolicitud) {
                throw new \RuntimeException('La solicitud de compra no existe.');
            }

            // Guardar archivos adjuntos
            foreach ($archivos as $archivo) {
                // Generar un nombre único para el archivo
                $nombreArchivo = uniqid() . '_' . $archivo->getClientOriginalName();

                // Almacenar el archivo en la carpeta public/storage/AdjuntosSolicitudCompra
                $rutaArchivo = $archivo->storeAs('public/AdjuntosSolicitudCompra', $nombreArchivo);

                // Log para verificar la ruta del archivo
                Log::info('Ruta del archivo almacenado:', $rutaArchivo);

                // Guardar la ruta relativa en la base de datos
                $anexo = new AnexosSoliCompra();
                $anexo->Ruta_documento_Adjunto = $rutaArchivo;
                $anexo->id_solicitud_compra = $idSolicitudCompra;
                $anexo->save();
            }

            return response()->json(['success' => true, 'message' => 'Archivos adjuntos guardados exitosamente.']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            // Loguear la excepción para rastreo interno
            Log::error('Error al guardar archivos adjuntos: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error interno al guardar archivos adjuntos.'], 500);
        }
    }






    //Consultar DocEntry de las ordenes de venta SAP

    public function consultarDocEntryordenesVSAP($ordenventarelacionada)
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
            $ventasUrl = $sapBaseUrl . "/Orders?\$select=DocEntry,CardCode,CardName,DocTotal,DocumentLines&\$filter=DocNum eq $ordenventarelacionada";

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            if (empty($data['value'])) {
                // La orden de venta ingresada no se encontró en SAP
                return response()->json(['error' => 'La orden de venta ingresada no se encontró en SAP'], 404);
            }

            $ventas = collect($data['value'])->flatMap(function ($venta) use ($client, $cookie, $sapBaseUrl) {
                // Agregar información de las líneas
                $ventasLineItems = [];
                foreach ($venta['DocumentLines'] as $line) {
                    $ventasLineItems[] = [
                        'LineNum' => $line['LineNum'],
                        'ItemCode' => $line['ItemCode'],
                        'ItemDescription' => $line['ItemDescription'],
                        'UnitPrice' => $line['UnitPrice'],
                    ];
                }

                return [
                    'DocEntry' => $venta['DocEntry'],
                    'CardCode' => $venta['CardCode'],
                    'CardName' => $venta['CardName'],
                    'DocTotal' => $venta['DocTotal'],
                    'LineItems' => $ventasLineItems,
                ];
            });

            return response()->json(['ventas' => $ventas]);
        } catch (\Exception $e) {
            Log::error('Error en Consultapedidosdeventa: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, se produjo un error: ' . $e->getMessage()], 500);
        }
    }



    private function enviarCorreoSolicitudAprobacion($solicitud, $requiereAprobacion)
    {
        try {
            // Cargar los detalles de la solicitud para incluir en el correo
            $solicitudConDetalles = SolicitudesCreditoAprobaciones::with('detalleSolicitudes')->find($solicitud->id);

            if (!$solicitudConDetalles) {
                Log::error('Solicitud no encontrada para ID: ' . $solicitud->id);
                return;
            }

            // Obtener el ID del usuario de la solicitud de compra
            $idUsuarioSolicitante = $solicitud->UsuarioSolicitante_id;

            // Buscar el usuario en la tabla de usuarios
            $usuarioSolicitante = User::find($idUsuarioSolicitante);

            if (!$usuarioSolicitante) {
                Log::error('Usuario no encontrado para ID: ' . $idUsuarioSolicitante);
                return;
            }

            // Obtener el ID del usuario aprobador desde el campo usuarioaprobador
            $idUsuarioAprobador = $usuarioSolicitante->usuarioaprobador;

            // Buscar el usuario aprobador en la tabla de usuarios
            $usuarioAprobador = User::find($idUsuarioAprobador);

            if (!$usuarioAprobador) {
                Log::error('Usuario aprobador no encontrado para ID: ' . $idUsuarioAprobador);
                return;
            }

            // Obtener el correo electrónico del usuario aprobador
            $correoUsuarioAprobador = $usuarioAprobador->email;

            // Envía un correo electrónico para solicitar aprobación
            if ($requiereAprobacion !== 'Si') {
                $this->generarsolicitudCompraSapnorquiereaprobacion($solicitudConDetalles->toArray());
            } else {
                // Envía un correo electrónico para solicitar aprobación
                $correo = new EnviarSolicitudAprobaciónCompraMail($solicitudConDetalles, $idUsuarioAprobador);

                // Adjunta los archivos a través del método attach de la clase Mailable
                foreach ($solicitudConDetalles->anexos as $anexo) {
                    $archivo = storage_path('app/' . $anexo->Ruta_documento_Adjunto);

                    // Agrega un log para verificar la ruta del archivo
                    Log::info('Intentando adjuntar archivo: ' . $archivo);

                    // Verifica si el archivo existe antes de intentar adjuntarlo
                    if (file_exists($archivo)) {
                        $correo->attach($archivo, ['as' => $anexo->nombre_personalizado]);
                    } else {
                        // Agrega un log si el archivo no se encuentra
                        Log::error('El archivo no se encontró: ' . $archivo);
                    }
                }

                // Utiliza el método send para enviar el correo electrónico
                Mail::to($correoUsuarioAprobador)->send($correo);

                // Actualizar el campo usuarioaprobador en la tabla solicitudes_credito_aprobaciones
                $solicitud->update(['usuarioaprobador' => $idUsuarioAprobador]);
            }

            // Puedes agregar lógica adicional aquí, como manejar el éxito del envío
        } catch (\Exception $e) {
            // Manejar errores al enviar el correo electrónico
            Log::error('Error al enviar correo electrónico de solicitud de aprobación: ' . $e->getMessage());
        }
    }



    public function Aprbacionessolicitudescompra($id, $usergerencia)
    {
        try {
            // Obtener la solicitud de compra directamente desde la URL
            $solicitud = SolicitudesCreditoAprobaciones::find($id);

            if (!$solicitud) {
                Log::error("Solicitud no encontrada para ID: $id");
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }

            // Verificar si la solicitud ya ha sido aprobada o rechazada
            if ($solicitud->estado === 'Aprobada' || $solicitud->estado === 'Rechazada') {
                Log::error("La solicitud ya ha sido procesada previamente para ID: $id");
                // Si ya está aprobada o rechazada, puedes redirigir al usuario a la misma vista con un mensaje de error
                return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('error_message', 'La solicitud ya ha sido procesada previamente');
            }

            // Aprobar la solicitud
            $solicitud->estado = 'Aprobada';
            $solicitud->UsuarioModifico_id = $usergerencia;
            $solicitud->save();

            // Enviar notificación por correo electrónico al solicitante
            Mail::to($solicitud->solicitante->email)->send(new EnviarNotificacionSolicitudAprobadaMail($solicitud, 'Aprobada'));

            // Agregar información de detalleSolicitudes al array $solicitudData
            $solicitudData = $solicitud->toArray();
            $solicitudData['detalleSolicitudes'] = $solicitud->detalleSolicitudes->toArray();
            $docEntryOrdenVenta = $solicitud->DocEntryOrdenVenta;

            // Agregar log para verificar si se llama a generarSolicitudCompraAPIalmacen
            Log::info("Llamando a generarSolicitudCompraAPIalmacen para la solicitud con ID: $id");

            // Llamar al método generarSolicitudCompraAPIalmacen
            $response = $this->generarSolicitudCompraAPIalmacen($solicitudData, $docEntryOrdenVenta);

            // Indicar al frontend que la aprobación fue exitosa
            return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('success_message', 'Solicitud de compra aprobada con éxito');
        } catch (\Exception $e) {
            // Si hay un error, redirigir al usuario a la misma vista con un mensaje de error
            Log::error("Error interno en Aprbacionessolicitudescompra: " . $e->getMessage());
            return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('error_message', 'Error interno: ' . $e->getMessage());
        }
    }





    public function Aprbacionessolicitudescompraaplicacion($id, $usergerencia)
    {
        try {
            // Obtener la solicitud de compra directamente desde la URL
            $solicitud = SolicitudesCreditoAprobaciones::find($id);

            if (!$solicitud) {
                Log::error("Solicitud no encontrada para ID: $id");
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }

            // Verificar si la solicitud ya ha sido aprobada o rechazada
            if ($solicitud->estado === 'Aprobada' || $solicitud->estado === 'Rechazada') {
                Log::error("La solicitud ya ha sido procesada previamente para ID: $id");
                // Si ya está aprobada o rechazada, puedes redirigir al usuario a la misma vista con un mensaje de error
                return response()->json(['error' => 'La solicitud ya ha sido procesada previamente'], 400);
            }

            // Determinar la acción a realizar (aprobar o rechazar)
            $accion = request('accion');
            if ($accion === 'aprobar') {
                // Aprobar la solicitud
                $solicitud->estado = 'Aprobada';
            } elseif ($accion === 'rechazar') {
                // Rechazar la solicitud
                $solicitud->estado = 'Rechazada';
            } else {
                // Si la acción no es válida, retornar un error
                return response()->json(['error' => 'Acción no válida'], 400);
            }

            $solicitud->UsuarioModifico_id = $usergerencia;

            $solicitud->save();

            // Enviar notificación por correo electrónico al solicitante
            Mail::to($solicitud->solicitante->email)->send(new EnviarNotificacionSolicitudAprobadaMail($solicitud, $solicitud->estado));

            // Agregar información de detalleSolicitudes al array $solicitudData
            $solicitudData = $solicitud->toArray();
            $solicitudData['detalleSolicitudes'] = $solicitud->detalleSolicitudes->toArray();
            $docEntryOrdenVenta = $solicitud->DocEntryOrdenVenta;

            // Llamar al método generarSolicitudCompraAPIalmacen solo si la solicitud es aprobada
            if ($solicitud->estado === 'Aprobada') {
                $response = $this->generarSolicitudCompraAPIalmacen($solicitudData, $docEntryOrdenVenta);
            }

            // Indicar al frontend que la aprobación/rechazo fue exitoso
            return response()->json(['success' => true, 'message' => 'Operación exitosa']);
        } catch (\Exception $e) {
            // Si hay un error, redirigir al usuario a la misma vista con un mensaje de error
            Log::error("Error interno en Aprbacionessolicitudescompra: " . $e->getMessage());
            return response()->json(['error' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }








    private function generarsolicitudCompraSapnorquiereaprobacion($solicitudData)
    {
        try {
            // Configuración de SAP
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');


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

            // Agregar logs para verificar los datos de la solicitud
            Log::info("Datos de la solicitud: " . json_encode($solicitudData));

            // Capturar información de la solicitud
            $fechaRequerida = date('Ymd', strtotime($solicitudData['RequriedDate']));

            Log::info("Fecha Requerida formateada antes de enviar a SAP: $fechaRequerida");

            $nombreSolicitante = $solicitudData['RequesterName'];

            $purchaseRequestData = [
                "RequriedDate" => $fechaRequerida,
                'RequesterName' => $nombreSolicitante,
                'U_HBT_AproComp' => 'No',
                "Comments" => "Solicitud de compra ejecutada por GTD- solicitud, no requiere aprobación. ID de la Solicitud: {$solicitudData['id']}.",
            ];

            log::info('informacion enviada a nivel de encabezado', $purchaseRequestData);

            // Procesar cada detalle de la solicitud
            if (isset($solicitudData['detalle_solicitudes']) && is_array($solicitudData['detalle_solicitudes'])) {
                foreach ($solicitudData['detalle_solicitudes'] as $detalle) {
                    // Obtener información del material desde la base de datos
                    $material = Consumibles_sap::find($detalle['Materiales_id']);

                    // Validar si se encontró información para el material
                    if (!$material) {
                        // Manejar la situación donde el material no se encuentra
                        Log::error("Material no encontrado para Materiales_id: " . $detalle['Materiales_id']);
                        continue;
                    }

                    // Agregar cada detalle a DocumentLines
                    $purchaseRequestData['DocumentLines'][] = [
                        "ItemCode" => $material->ItemCode,
                        "Quantity" => $detalle['Cantidad'],
                        "CostingCode4" => $detalle['CentroCostos'],
                        "ProjectCode" => $detalle['Proyecto'],
                        "CostingCode" => $detalle['CentroOperaciones'],
                        "CostingCode3" => $detalle['CentroCostos'],
                        "CostingCode4" => $detalle['Departamento'],
                        "TaxCode" => "IVAD01",
                        "WarehouseCode" => $detalle['Almacen'],
                        "FreeText" => $detalle['TextoLibre'],
                    ];

                    // Agregar log para verificar cada detalle antes de enviar a SAP
                    Log::info("Detalle de Solicitud: " . json_encode(end($purchaseRequestData['DocumentLines'])));
                }
            } else {
                Log::error("Clave 'detalle_solicitudes' no encontrada o no es un arreglo en el arreglo de datos de la solicitud.");
                // Puedes manejar esta situación según tus necesidades
            }

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

            if (isset($responseBody['DocNum'])) {
                // Agregar log de éxito con el número de documento
                Log::info("Solicitud de compra creada en SAP. DocNum: " . $responseBody['DocNum']);
                Log::info("--------------------------------------------------------------------- ");

                // Almacenar la respuesta de SAP en la base de datos
                $idSolicitud = $solicitudData['id'];
                $this->AlmancenarRespuestaSAP($responseBody, $idSolicitud);

                $solicitudestado = SolicitudesCreditoAprobaciones::find($idSolicitud);

                if ($solicitudestado) {
                    // Actualiza el estado a 'No_requiere_apr'
                    $solicitudestado->estado = 'No_requiere_apr';
                    $solicitudestado->save();
                }
                return response()->json(['success' => true, 'DocNum' => $responseBody['DocNum'], 'DocEntry' => $responseBody['DocEntry']]);
            } else {
                // Operación fallida, proporciona detalles del error
                Log::error("Error al crear la solicitud de compra en SAP. Detalles: " . json_encode($responseBody));
                return response()->json(['success' => false, 'error' => 'Error al crear la solicitud de compra en SAP', 'details' => $responseBody]);
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
                Log::error("Error específico de SAP: " . $sapErrorMessage);
                return response()->json(['success' => false, 'error' => $sapErrorMessage, 'details' => $errorBody], $statusCode);
            }

            // Devuelve una respuesta JSON con información sobre el error
            Log::error("Error al realizar la solicitud a SAP. Detalles: " . json_encode($errorBody));
            return response()->json(['success' => false, 'error' => 'Error al realizar la solicitud a SAP', 'statusCode' => $statusCode, 'details' => $errorBody], $statusCode);
        }
    }




    public function generarSolicitudCompraAPIalmacen($solicitudData, $docEntryOrdenVenta)
    {
        try {
            // Configuración de SAP
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

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

            // Agregar logs para verificar los datos de la solicitud
            Log::info("Datos de la solicitud: " . json_encode($solicitudData));

            // Capturar información de la solicitud
            $fechaRequerida = date('Ymd', strtotime($solicitudData['RequriedDate']));


            Log::info("Fecha Requerida formateada antes de enviar a SAP: $fechaRequerida");



            $nombreSolicitante = $solicitudData['RequesterName'];
            $requiereAprobacion = $solicitudData['U_HBT_AproComp'];
            $estadoAprobacion = $solicitudData['estado'];
            $idSolicitud = $solicitudData['id'];
            // Obtener el ID del usuario que modificó la solicitud
            $idUsuarioModifico = $solicitudData['UsuarioModifico_id'];
            // Obtener el nombre del usuario que modificó la solicitud a través de la relación con la tabla 'users'
            $usuarioModifico = User::find($idUsuarioModifico);
            $nombreUsuarioModifico = $usuarioModifico ? $usuarioModifico->Nombre_Empleado : 'Desconocido';
            $documentoreferenciaorden = $solicitudData['RefDocNumOrder'];
            $precio = $solicitudData['Price'];


            $mapaEstados = [
                'Aprobada' => 1,
                'Rechazada' => 2,
                'Pendiente' => 3,
            ];

            // Verificar si el estado de aprobación existe en el mapa
            if (array_key_exists($estadoAprobacion, $mapaEstados)) {
                // Asignar el valor correspondiente a $valorU_U_DOB_EstadoAprobacion
                $valorU_U_DOB_EstadoAprobacion = $mapaEstados[$estadoAprobacion];
            } else {
                // En caso de un estado no reconocido, puedes asignar un valor predeterminado o manejarlo de otra manera
                $valorU_U_DOB_EstadoAprobacion = 3; // Pendiente por defecto
            }


            $DocumentReferences = [];
            // Verifica si $docEntryOrdenVenta tiene un valor antes de agregarlo
            if ($docEntryOrdenVenta) {
                $DocumentReferences[] = [
                    "LineNumber" => 1,
                    "RefDocEntr" => $docEntryOrdenVenta,
                    "RefObjType" => "rot_SalesOrder",
                ];
            }

            $purchaseRequestData = [
                "RequriedDate" => $fechaRequerida,
                'RequesterName' => $nombreSolicitante,
                'U_U_DOB_EstadoAprobacion' => $valorU_U_DOB_EstadoAprobacion,
                "Comments" => "Solicitud de compra ejecutada por GTD- solicitud Aprobada. ID de la Solicitud: $idSolicitud. Aprobada por: $nombreUsuarioModifico",
                "DocumentReferences" => $DocumentReferences,
            ];


            log::info('informacion enviada a nivel de encabezado', $purchaseRequestData);
            // Procesar cada detalle de la solicitud
            foreach ($solicitudData['detalleSolicitudes'] as $detalle) {
                // Obtener información del material desde la base de datos
                $material = Consumibles_sap::find($detalle['Materiales_id']);

                // Validar si se encontró información para el material
                if (!$material) {
                    // Manejar la situación donde el material no se encuentra
                    Log::error("Material no encontrado para Materiales_id: " . $detalle['Materiales_id']);
                    continue; // O manejar de otra manera según tus necesidades
                }

                // Agregar cada detalle a DocumentLines
                $purchaseRequestData['DocumentLines'][] = [
                    "ItemCode" => $material->ItemCode,
                    "Quantity" => $detalle['Cantidad'],
                    "CostingCode4" => $detalle['CentroCostos'],
                    "ProjectCode" => $detalle['Proyecto'],
                    "CostingCode" => $detalle['CentroOperaciones'],
                    "CostingCode3" => $detalle['CentroCostos'],
                    "CostingCode4" => $detalle['Departamento'],
                    "WarehouseCode" => $detalle['Almacen'],
                    "FreeText" => $detalle['TextoLibre'],
                    "U_DOB_DescripcionAdicional" => $detalle['U_DOB_DescripcionAdicional'],
                    'Price' =>  $detalle['Price'],
                    'TaxCode' => $detalle['TaxCode'],
                    'LineVendor' => $detalle['LineVendor']
                ];

                // Agregar log para verificar cada detalle antes de enviar a SAP
                Log::info("Detalle de Solicitud: " . json_encode(end($purchaseRequestData['DocumentLines'])));
            }

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

            if (isset($responseBody['DocNum'])) {
                // Agregar log de éxito con el número de documento
                Log::info("Solicitud de compra creada en SAP. DocNum: " . $responseBody['DocNum']);
                Log::info("--------------------------------------------------------------------- ");
                // Almacenar la respuesta de SAP en la base de datos
                $idSolicitud = $solicitudData['id']; // Asegúrate de tener el campo 'id' en tu arreglo $solicitudData
                $this->AlmancenarRespuestaSAP($responseBody, $idSolicitud);

                return response()->json(['success' => true, 'DocNum' => $responseBody['DocNum'], 'DocEntry' => $responseBody['DocEntry']]);
            } else {
                // Operación fallida, proporciona detalles del error
                Log::error("Error al crear la solicitud de compra en SAP. Detalles: " . json_encode($responseBody));
                return response()->json(['success' => false, 'error' => 'Error al crear la solicitud de compra en SAP', 'details' => $responseBody]);
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
                Log::error("Error específico de SAP: " . $sapErrorMessage);
                return response()->json(['success' => false, 'error' => $sapErrorMessage, 'details' => $errorBody], $statusCode);
            }

            // Devuelve una respuesta JSON con información sobre el error
            Log::error("Error al realizar la solicitud a SAP. Detalles: " . json_encode($errorBody));
            return response()->json(['success' => false, 'error' => 'Error al realizar la solicitud a SAP', 'statusCode' => $statusCode, 'details' => $errorBody], $statusCode);
        }
    }








    ///////////////////////
    //generar solicitud de compra desde la aplicacion 

    public function generarsolicitudsapdesdeaplicacion($id)
    {
        try {
            // Obtener la solicitud de compra con sus detalles y materiales
            $solicitudData = SolicitudesCreditoAprobaciones::with('detalleSolicitudes.material')
                ->findOrFail($id);

            // Verificar si el estado es Pendiente
            if ($solicitudData['estado'] === 'Pendiente') {
                // Puedes retornar una respuesta indicando que la solicitud no se puede generar
                return response()->json(['success' => false, 'error' => 'La solicitud no se puede generar en SAP porque está pendiente por aprobación'], 400);
            } elseif ($solicitudData['estado'] === 'Rechazada') {
                return response()->json(['success' => false, 'error' => 'La solicitud no se puede generar en SAP porque esta rechazada']);
            }
            // Configuración de SAP
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

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

            // Agregar logs para verificar los datos de la solicitud
            Log::info("Datos de la solicitud: " . json_encode($solicitudData));

            // Capturar información de la solicitud
            $fechaRequerida = date('Ymd', strtotime($solicitudData['RequriedDate']));

            Log::info("Fecha Requerida formateada antes de enviar a SAP: $fechaRequerida");

            $nombreSolicitante = $solicitudData['RequesterName'];
            $requiereAprobacion = $solicitudData['U_HBT_AproComp'];
            $estadoAprobacion = $solicitudData['estado'];
            $idSolicitud = $solicitudData['id'];
            $idUsuarioModifico = $solicitudData['UsuarioModifico_id'];
            $usuarioModifico = User::find($idUsuarioModifico);
            $nombreUsuarioModifico = $usuarioModifico ? $usuarioModifico->Nombre_Empleado : 'Desconocido';

            $mapaEstados = [
                'Aprobada' => 1,
                'Rechazada' => 2,
                'Pendiente' => 3,
            ];

            if (array_key_exists($estadoAprobacion, $mapaEstados)) {
                $valorU_U_DOB_EstadoAprobacion = $mapaEstados[$estadoAprobacion];
            } else {
                $valorU_U_DOB_EstadoAprobacion = 3;
            }

            $purchaseRequestData = [
                "RequriedDate" => $fechaRequerida,
                'RequesterName' => $nombreSolicitante,
                'U_U_DOB_EstadoAprobacion' => $valorU_U_DOB_EstadoAprobacion,
                "Comments" => "Solicitud de compra ejecutada por GTD- solicitud Aprobada. ID de la Solicitud: $idSolicitud. Aprobada por: $nombreUsuarioModifico",
            ];

            log::info('informacion enviada a nivel de encabezado', $purchaseRequestData);

            foreach ($solicitudData['detalleSolicitudes'] as $detalle) {
                $material = $detalle['material'];

                // Validar si se encontró información para el material
                if (!$material) {
                    Log::error("Material no encontrado para Materiales_id: " . $detalle['Materiales_id']);
                    continue;
                }

                // Agregar cada detalle a DocumentLines
                $purchaseRequestData['DocumentLines'][] = [
                    "ItemCode" => $material->ItemCode,
                    "Quantity" => $detalle['Cantidad'],
                    "CostingCode4" => $detalle['CentroCostos'],
                    "ProjectCode" => $detalle['Proyecto'],
                    "CostingCode" => $detalle['CentroOperaciones'],
                    "CostingCode3" => $detalle['CentroCostos'],
                    "CostingCode4" => $detalle['Departamento'],
                    'TaxCode' => $detalle['TaxCode'],
                    "WarehouseCode" => $detalle['Almacen'],
                    "FreeText" => $detalle['TextoLibre'],
                ];

                // Agregar log para verificar cada detalle antes de enviar a SAP
                Log::info("Detalle de Solicitud: " . json_encode(end($purchaseRequestData['DocumentLines'])));
            }

            $apiUrl = $sapBaseUrl . '/PurchaseRequests';
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
                'json' => $purchaseRequestData,
            ]);

            $responseBody = json_decode($response->getBody(), true);

            if (isset($responseBody['DocNum'])) {
                Log::info("Solicitud de compra creada en SAP. DocNum: " . $responseBody['DocNum']);

                $idSolicitud = $solicitudData['id'];
                $this->AlmancenarRespuestaSAP($responseBody, $idSolicitud);

                return response()->json(['success' => true, 'DocNum' => $responseBody['DocNum'], 'DocEntry' => $responseBody['DocEntry']]);
            } else {
                Log::error("Error al crear la solicitud de compra en SAP. Detalles: " . json_encode($responseBody));
                return response()->json(['success' => false, 'error' => 'Error al crear la solicitud de compra en SAP', 'details' => $responseBody]);
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $reasonPhrase = $response->getReasonPhrase();
            $body = $response->getBody()->getContents();

            Log::channel('solcompraalmacen')->info("Error en la solicitud: Status Code: $statusCode, Reason: $reasonPhrase, Body: $body");

            $errorBody = json_decode($body, true);

            if ($statusCode == 400) {
                $sapErrorMessage = $errorBody['error']['message']['value'] ?? 'Error en la respuesta de SAP';
                Log::error("Error específico de SAP: " . $sapErrorMessage);
                return response()->json(['success' => false, 'error' => $sapErrorMessage, 'details' => $errorBody], $statusCode);
            }

            Log::error("Error al realizar la solicitud a SAP. Detalles: " . json_encode($errorBody));
            return response()->json(['success' => false, 'error' => 'Error al realizar la solicitud a SAP', 'statusCode' => $statusCode, 'details' => $errorBody], $statusCode);
        }
    }






    //metodo para capturar la respuesta despues de estar creada la solicitud de compra en SAP y almacenar el DocNum y DocEntry

    private function AlmancenarRespuestaSAP($responseBody, $idSolicitud)
    {
        try {
            // Busca la solicitud correspondiente
            $solicitud = SolicitudesCreditoAprobaciones::find($idSolicitud);

            // Verifica si la solicitud existe
            if (!$solicitud) {
                // Maneja el caso donde la solicitud no se encuentra
                Log::error("Solicitud no encontrada para ID: $idSolicitud");
                return false;
            }

            // Actualiza los campos DocNum y DocEntry
            $solicitud->DocNum = $responseBody['DocNum'];
            $solicitud->DocEntry = $responseBody['DocEntry'];

            // Guarda los cambios en la base de datos
            $solicitud->save();

            return true;
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir durante la actualización
            Log::error("Error al almacenar la respuesta de SAP: " . $e->getMessage());
            return false;
        }
    }








    public function rechazarsolicitudescompra($id, $usergerencia)
    {
        try {
            // Obtener la solicitud de compra directamente desde la URL
            $solicitud = SolicitudesCreditoAprobaciones::find($id);

            if (!$solicitud) {
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }

            // Verificar si la solicitud ya ha sido aprobada o rechazada
            if ($solicitud->estado === 'Aprobada' || $solicitud->estado === 'Rechazada') {
                // Si ya está aprobada o rechazada, puedes redirigir al usuario a la misma vista con un mensaje de error
                return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('error_message', 'La solicitud ya ha sido procesada previamente');
            }

            // Rechazar la solicitud
            $solicitud->estado = 'Rechazada';
            $solicitud->UsuarioModifico_id = $usergerencia;
            $solicitud->save();

            // Enviar notificación por correo electrónico al solicitante
            Mail::to($solicitud->solicitante->email)->send(new EnviarNotificacionSolicitudAprobadaMail($solicitud, 'Rechazada'));

            // Indicar al frontend que el rechazo fue exitoso
            return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('success_message', 'Solicitud de compra rechazada con éxito');
        } catch (\Exception $e) {
            // Si hay un error, redirigir al usuario a la misma vista con un mensaje de error
            return View::make('emails.NotificacionSolicitudesCompra.notificacion_aprobacion')->with('error_message', 'Error interno: ' . $e->getMessage());
        }
    }






    public function obtenerDescripcionArticulo($itemCode)
    {
        $articulo = Consumibles_sap::where('ItemCode', $itemCode)->first();

        if ($articulo) {
            return response()->json(['descripcion' => $articulo->ItemName]);
        } else {
            return response()->json(['descripcion' => 'No se encontró la descripción.']);
        }
    }



    public function Enviarprocesoaprovacion(Request $request)
    {
        try {
            // Configuración de SAP
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

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

            // Capturar la información del formulario
            $docEntry = '41322';


            $purchaseRequestData = [
                "ObjectEntry" => $docEntry,
                "Remarks" => "Esta prueba la desarrollo stiven con el otro metodo",
            ];


            // Enviar la solicitud de compra a SAP
            $apiUrl = $sapBaseUrl . '/ApprovalRequests';
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
                'json' => $purchaseRequestData,
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return $responseBody;
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
                return response()->json(['success' => false, 'error' => $sapErrorMessage, 'details' => $errorBody], $statusCode);
            }

            // Devuelve una respuesta JSON con información sobre el error
            return response()->json(['success' => false, 'error' => 'Error al realizar la solicitud a SAP', 'statusCode' => $statusCode, 'details' => $errorBody], $statusCode);
        }
    }




    public function consultarSolicitudesCompra(Request $request)
    {
        $idUsuario = auth()->user()->id;

        // Obten el valor del estado desde la solicitud
        $estado = $request->input('estado');

        // Consulta las solicitudes de compra con la relación usuarioSolicitante
        $query = SolicitudesCreditoAprobaciones::with('usuarioSolicitante')
            ->where('UsuarioSolicitante_id', $idUsuario);

        // Aplica el filtro por estado si se proporciona
        if ($estado) {
            $query->where('estado', $estado);
        }

        // Ordena por fecha de creación de forma descendente
        $solicitudesCompra = $query->orderBy('created_at', 'desc')->get();

        // Retorna la vista con las solicitudes de compra
        return response()->json(['solicitudesCompra' => $solicitudesCompra]);
    }




    public function detalleSolicitudCompra($id)
    {
        try {
            // Obtener los detalles de la solicitud de compra por ID
            $detalleSolicitud = DetalleSolicitudesCreditoAprobaciones::with('material')->where('id_solicitud_compra', $id)->get();

            if ($detalleSolicitud->isEmpty()) {
                return response()->json(['success' => []]); // Retorna un array vacío si no hay detalles encontrados.
            }

            return response()->json(['success' => $detalleSolicitud]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener detalles de la solicitud.']);
        }
    }

    public function ConsultarSolicitudCompra(Request $request)
    {
        try {
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

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $docnum = $request->input('docnum');

            $ventasUrl = $sapBaseUrl . "/PurchaseOrders?\$select=DocNum,DocDate,CardCode,CardName,DocTotal,UserSign,Address2,DocumentLines";

            $filter = [];

            if ($start_date && strtotime($start_date)) {
                $filter[] = "DocDate ge '$start_date'";
            }

            if ($end_date && strtotime($end_date)) {
                $filter[] = "DocDate le '$end_date'";
            }

            if ($docnum && is_numeric($docnum)) {
                $filter[] = "DocNum eq $docnum";
            }

            if (!empty($filter)) {
                $filterStr = implode(' and ', $filter);
                $ventasUrl .= "&\$filter=$filterStr";
            }

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                    'Expect' => '',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            if (empty($data['value'])) {
                return collect(); // Return an empty collection
            }

            $ventas = collect($data['value'])->flatMap(function ($venta) use ($client, $cookie, $sapBaseUrl) {
                $ventasLineItems = [];

                foreach ($venta['DocumentLines'] as $line) {
                    $ventasLineItems[] = [
                        'LineNum' => $line['LineNum'],
                        'ItemCode' => $line['ItemCode'],
                        'ItemDescription' => $line['ItemDescription'],
                        'CostingCode' => $line['CostingCode'],
                        'CostingCode4' => $line['CostingCode4'],
                        'BaseEntry' => $line['BaseEntry']
                    ];
                }

                // Fetch purchase request and department data here...

                return [
                    'DocNum' => $venta['DocNum'],
                    'DocDate' => $venta['DocDate'],
                    'CardCode' => $venta['CardCode'],
                    'CardName' => $venta['CardName'],
                    'DocTotal' => $venta['DocTotal'],
                    'Address2'  => $venta['Address2'],
             
                    'LineItems' => $ventasLineItems,
                ];
            });

            return response()->json($ventas);
        } catch (\Exception $e) {
            Log::error('Error en ConsultapedidosCompraSAP: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, an error occurred: ' . $e->getMessage()], 500);
        }
    }


    public function actualizarComentario(Request $request, $id)
    {
        try {
            $solicitud = SolicitudesCreditoAprobaciones::findOrFail($id);
            $solicitud->Comments = $request->input('comentario');
            $solicitud->save();

            return response()->json(['success' => true, 'message' => 'Comentario guardado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el comentario']);
        }
    }


    public function veranexossolicitudescompra($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/AdjuntosSolicitudCompra/' . $nombreArchivo);

        if (!File::exists($rutaArchivo)) {
            abort(404); // Archivo no encontrado
        }

        return response()->file($rutaArchivo, [
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
        ]);
    }









    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function pruebaconsumoodbc()
    {
       // Configuración de las variables de entorno para ODBC
    putenv("DYLD_LIBRARY_PATH=/usr/sap/hdbclient/libodbcHDB.so");
    putenv("ODBCINI=/etc/odbc.ini"); // o la ruta correcta de tu archivo odbc.ini

    // Definición de constantes
    define("DSN", "HANA");
    define("USER", "UDOBLAMOS");
    define("PASSWORD", "D06l43D9A57$");

    // Datos específicos para la actualización
    $nuevoNombre = "PRUEBA POR ODBC";

    // Intentar la conexión ODBC
    $conector = odbc_connect("DRIVER={HDBODBC};ServerNode=52.252.0.194:30015;DATABASE=PRUEBAS_DOBLAMOS_24ENE;", USER, PASSWORD);
    if ($conector) {
        echo "Conexión exitosa";

        // Actualizar el valor en la tabla ATC1
        $actualizacion = 'UPDATE "PRUEBAS_DOBLAMOS_24ENE"."OPRQ"
                          SET "ReqName" = \'' . $nuevoNombre . '\'
                          WHERE "DocEntry" = (SELECT "DocEntry" FROM "PRUEBAS_DOBLAMOS_24ENE"."OPRQ" WHERE "DocEntry" = \'8842\')';

        $resultadoActualizacion = odbc_exec($conector, $actualizacion);

        // Verificar si la actualización fue exitosa
        if ($resultadoActualizacion) {
            echo "<br>Actualización exitosa<br>";

            // Cerrar la conexión
            odbc_close($conector);
        } else {
            echo "<br>Error en la actualización: " . odbc_errormsg();
        }
    } else {
        echo "Error en la conexión: " . odbc_errormsg();
    }




    }
    
}






