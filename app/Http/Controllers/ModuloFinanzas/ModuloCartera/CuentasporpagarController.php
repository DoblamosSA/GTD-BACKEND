<?php

namespace App\Http\Controllers\ModuloFinanzas\ModuloCartera;

use App\Http\Controllers\Controller;
use App\Models\CarteraDoblamos\GestionCartera\Cuentasporpagar;
use App\Models\CarteraDoblamos\GestionCartera\Seguimientocuentasporpagar;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviosaldospendientesClientesMail;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;

class CuentasporpagarController extends Controller
{


    public function obtenerCuentaPorPagar($id)
    {
        $cuenta = Cuentasporpagar::find($id);
        return response()->json(['cuenta' => $cuenta], 200);
    }


    public function InformesDoblamos()
    {
        return view('ModuloFinanzas.ModuloCartera.InformesCarteraDoblamos.Recaudos');
    }

    public function Cuentasporpagar()
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

            // Consultar Cuentas por Pagar
            $ventasUrl = $sapBaseUrl . '/sml.svc/CXC?$select=DocNum,DocDate,DocDueDate,CardCode,CardName,SlpName,DocTotal,PaidToDate,Saldo_Pendiente,U_DOB_CorreoCartera';

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            foreach ($data['value'] as $cuenta) {
                $fechaDocumento = Carbon::parse($cuenta['DocDate']);
                $fechaVencimiento = Carbon::parse($cuenta['DocDueDate']);
                $fechaActual = Carbon::now();

                // Calcular días vencidos respecto a la fecha actual del servidor
                $diasVencidos = $fechaActual->diffInDays($fechaVencimiento);



                Cuentasporpagar::updateOrCreate(
                    ['documento' => $cuenta['DocNum']],
                    [
                        'Fecha_Documento' => $cuenta['DocDate'],
                        'Fecha_Vencimiento' => $cuenta['DocDueDate'],
                        'Codigo_cliente' => $cuenta['CardCode'],
                        'Nombre_Cliente' => $cuenta['CardName'],
                        'Vendedor' => $cuenta['SlpName'],
                        'Total_Documento' => $cuenta['DocTotal'],
                        'pagado_hasta_la_fecha' => $cuenta['PaidToDate'],
                        'Saldo_Pendiente' => $cuenta['Saldo_Pendiente'],
                        'E_Mail' => $cuenta['U_DOB_CorreoCartera'],
                        'Dias_Vencidos' => $diasVencidos,
                    ]
                );
            }



            return $data;
        } catch (\Exception $e) {
            Log::error('Error en Cuentasporpagar: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, an error occurred: ' . $e->getMessage()], 500);
        }
    }





    public function guardarSeguimientocuentasporpagar(Request $request, $id_cuenta)
    {
        try {
            $cuentaPorPagar = Cuentasporpagar::find($id_cuenta);

            if (!$cuentaPorPagar) {
                throw new \Exception('Cuenta por pagar no encontrada.');
            }

            // Validar que las fechas no sean nulas
            if (!$request->input('Fecha_Seguimiento') || !$request->input('Fecha_compromiso_pago')) {
                throw new \Exception('Las fechas no pueden ser valores nulas.');
            }

            // Validar que el comentario no sea nulo
            if (!$request->input('comentario')) {
                throw new \Exception('El comentario no puede ser un valor nulo.');
            }

            if (!$request->input('Estado_Documento')) {
                throw new \Exception('Selecciona el estado del seguimiento.');
            }

            // Verificar si ya existe un seguimiento idéntico
            $existingSeguimiento = Seguimientocuentasporpagar::where([
                'cuentasporpagar_id' => $id_cuenta,
                'Fecha_Seguimiento' => $request->input('Fecha_Seguimiento'),
                'Fecha_compromiso_pago' => $request->input('Fecha_compromiso_pago'),
                'comentario' => $request->input('comentario'),
            ])->first();

            if (!$existingSeguimiento) {
                // Solo guarda si no existe
                $seguimiento = new Seguimientocuentasporpagar([
                    'comentario' => $request->input('comentario'),
                    'Fecha_Seguimiento' => $request->input('Fecha_Seguimiento'),
                    'Fecha_compromiso_pago' => $request->input('Fecha_compromiso_pago'),
                ]);

                $cuentaPorPagar->seguimientos()->save($seguimiento);

                // Actualizar Estado_Documento en Cuentasporpagar
                $cuentaPorPagar->update(['Estado_Documento' => $request->input('Estado_Documento')]);

                return response()->json(['message' => 'Seguimiento guardado exitosamente.'], 200);
            } else {
                return response()->json(['message' => 'Seguimiento guardado exitosamente.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el seguimiento: ' . $e->getMessage()], 500);
        }
    }




    public function obtenerSeguimientosCuentasporpagar($id_cuenta)
    {
        // Obtener la solicitud de crédito por su ID
        $solicitud = Cuentasporpagar::find($id_cuenta);

        // Verificar si la solicitud de crédito existe
        if (!$solicitud) {
            return response()->json(['error' => 'La solicitud de crédito no existe.'], 404);
        }

        // Obtener los comentarios asociados a la solicitud de crédito con información del usuario
        $comentarios = Seguimientocuentasporpagar::where('cuentasporpagar_id', $id_cuenta)->get();

        // Devolver los comentarios y el ID de la cuenta en formato JSON
        return response()->json([
            'id_cuenta' => $id_cuenta,
            'comentarios' => $comentarios,
        ], 200);
    }



public function enviarCorreoSaldoclientesporpagar(Request $request)
{
    // Obtén los IDs de las filas seleccionadas
    $selectedItems = $request->input('selectedItems');

    // Variable para almacenar los correos electrónicos enviados con éxito
    $successEmails = [];

    // Array para almacenar las facturas agrupadas por cliente con la suma del Saldo_Pendiente
    $facturasPorClienteConSuma = [];

    // Recorre las facturas seleccionadas y agrúpalas por cliente
    foreach ($selectedItems as $itemId) {
        $cuenta = Cuentasporpagar::where('id', $itemId)->first();

        // Verifica si la cuenta existe y tiene un correo electrónico
        if ($cuenta && $cuenta->E_Mail) {
            $clienteKey = $cuenta->Codigo_cliente;

            // Agrupa las facturas por cliente
            $facturasPorClienteConSuma[$clienteKey]['facturas'][] = $cuenta;
            $facturasPorClienteConSuma[$clienteKey]['sumaSaldoPendiente'] = ($facturasPorClienteConSuma[$clienteKey]['sumaSaldoPendiente'] ?? 0) + $cuenta->Saldo_Pendiente;
        }
    }

    // Envía un correo por cada cliente con sus facturas agrupadas y la suma del Saldo_Pendiente
    foreach ($facturasPorClienteConSuma as $clienteKey => $data) {
        $facturas = $data['facturas'];
        $sumaSaldoPendiente = $data['sumaSaldoPendiente'];

        try {
            // Envía el correo utilizando la clase de Mailable (EnviosaldospendientesClientesMail)
            // y pasa los datos necesarios al constructor, incluyendo la suma del Saldo_Pendiente
            Mail::to($facturas[0]->E_Mail)->send(new EnviosaldospendientesClientesMail($facturas, $sumaSaldoPendiente));

            // Almacena el correo electrónico en el array de éxito
            $successEmails[] = $facturas[0]->E_Mail;

            // Actualiza el campo EnvioCorreo en todas las facturas enviadas
            Cuentasporpagar::whereIn('id', collect($facturas)->pluck('id'))->update(['EnvioCorreo' => true]);
        } catch (\Exception $e) {
            // Registro: Agrega una línea al registro indicando un error en el envío del correo
            Log::error("Error al enviar correo a {$facturas[0]->E_Mail}: " . $e->getMessage());
        }
    }

    // Verifica si se enviaron correos electrónicos con éxito
    if (!empty($successEmails)) {
        $successMessage = 'Correos electrónicos enviados exitosamente a: ' . implode(', ', $successEmails);
        Log::info($successMessage);
        return response()->json(['message' => $successMessage]);
    } else {
        return response()->json(['message' => 'No se enviaron correos electrónicos.']);
    }
}



    public function buscarPorFechas(Request $request)
    {
        $fechaInicio = $request->input('Fecha_Documento');
        $fechaFin = $request->input('Fecha_Vencimiento');

        // Realiza la lógica de búsqueda en tu modelo y obtén los datos
        $resultados =   Cuentasporpagar::whereBetween('Fecha_Documento', [$fechaInicio, $fechaFin])->get();

        return response()->json($resultados);
    }




    public function ModificarCorreoSAPGesCartera(Request $request)
    {
        try {
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

            $cardCode = $request->input('CodigoCliente');
            $correo = $request->input('CorreoclientecarteraSAP');

            // Agregar registros de log
            Log::info("Enviando a SAP - Código de Cliente: $cardCode, Correo: $correo");

            // Construir la URL del Business Partner en SAP
            $businessPartnerUrl = $sapBaseUrl . '/BusinessPartners(\'' . $cardCode . '\')';

            // Construir el cuerpo de la solicitud PATCH
            $patchBody = [
                'U_DOB_CorreoCartera' => $correo,
            ];

            // Configurar la solicitud PATCH en Guzzle
            $patchHeaders = [
                'Content-Type' => 'application/json',
                'Cookie' => $cookie,
            ];

            $patchResponse = $client->patch($businessPartnerUrl, ['headers' => $patchHeaders, 'json' => $patchBody]);

            // Verificar si el registro existe antes de intentar actualizarlo
            // Obtener todos los registros que coincidan con el Codigo_cliente
            $cuentasPorPagar = CuentasPorPagar::where('Codigo_cliente', $cardCode)->get();

            foreach ($cuentasPorPagar as $cuenta) {
                // Actualizar la columna E_Mail para cada registro
                $cuenta->E_Mail = $correo;
                $cuenta->save();
            }

            // Si no hay registros, puedes decidir crear uno nuevo o manejarlo de otra manera
            if ($cuentasPorPagar->isEmpty()) {
                Log::error("No se encontraron registros con Código de Cliente $cardCode en la base de datos.");
                // También puedes lanzar una excepción si lo prefieres
                // throw new \Exception("No se encontraron registros con Código de Cliente $cardCode en la base de datos.");
            }

            return response(['message' => 'Correo Actualizado con éxito en SAP']);
        } catch (RequestException $e) {

            Log::error("Error al hacer la solicitud HTTP: " . $e->getMessage());
            echo "Error al hacer la solicitud HTTP: " . $e->getMessage();
        }
    }



    public function recaudosSAPAPI(Request $request)
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



            // Consultar Cuentas por Pagar
            $fechaInicio = $request['fechaInicio'];
            $fechaFin = $request['fechaFin'];

            $ventasUrl = $sapBaseUrl . '/sml.svc/RECAUDOS?$select=DOCUMENTO,CODVEND,SlpName,FACT,REF,FECH_FACT,FECH_DOC,FECH_VEN,PAGO,RECIBO,FECH_PAGO,FECH_VENPAGO,CODSN,NOMSN,id__'
                . "&\$filter=FECH_PAGO ge '$fechaInicio' and FECH_PAGO le '$fechaFin'";

            $response = $client->get($ventasUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            // Sumar los pagos de todas las facturas
            $totalPagos = 0;
            foreach ($data['value'] as $row) {
                $totalPagos += floatval($row['PAGO']);
            }

            // Agregar el total de pagos al resultado
            $data['totalPagos'] = $totalPagos;

            return $data;
        } catch (\Exception $e) {
            Log::error('Error en Cuentasporpagar: ' . $e->getMessage());
            return response()->json(['error' => 'Ups, an error occurred: ' . $e->getMessage()], 500);
        }
    }



    
   public function informeedades(Request $request)
{
    try {
        $fechaInicio = $request['fechaInicio'];
        $fechaFin = $request['fechaFin'];

        $informe = DB::table('cuentasporpagars')
            ->select(
                'Estado_Documento',
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) >= 0 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 30 THEN Saldo_Pendiente ELSE 0 END) as suma_0_30'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 30 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 60 THEN Saldo_Pendiente ELSE 0 END) as suma_31_60'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 60 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 90 THEN Saldo_Pendiente ELSE 0 END) as suma_61_90'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 90 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 120 THEN Saldo_Pendiente ELSE 0 END) as suma_91_120'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 120 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 150 THEN Saldo_Pendiente ELSE 0 END) as suma_121_150'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 150 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 180 THEN Saldo_Pendiente ELSE 0 END) as suma_151_180'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 180 THEN Saldo_Pendiente ELSE 0 END) as suma_mas_180'),
                DB::raw('SUM(Saldo_Pendiente) as total_saldos'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) >= 0 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 30 THEN Saldo_Pendiente ELSE 0 END) as total_suma_0_30'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 30 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 60 THEN Saldo_Pendiente ELSE 0 END) as total_suma_31_60'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 60 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 90 THEN Saldo_Pendiente ELSE 0 END) as total_suma_61_90'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 90 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 120 THEN Saldo_Pendiente ELSE 0 END) as total_suma_91_120'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 120 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 150 THEN Saldo_Pendiente ELSE 0 END) as total_suma_121_150'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 150 AND DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) <= 180 THEN Saldo_Pendiente ELSE 0 END) as total_suma_151_180'),
                DB::raw('SUM(CASE WHEN DATEDIFF(DAY, Fecha_Vencimiento, GETDATE()) > 180 THEN Saldo_Pendiente ELSE 0 END) as total_suma_mas_180')
            )
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereIn('Estado_Documento', ['Proxima semana', 'Nota credito', 'Cancelado', 'Critico'])
                    ->whereBetween('Fecha_Vencimiento', [$fechaInicio, $fechaFin]);
            })
            ->groupBy('Estado_Documento')
            ->get();

        return response()->json(['informe' => $informe]);
    } catch (\Exception $e) {
        \Log::error('Error en el controlador de indicadores-edades: ' . $e->getMessage());
        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}




    
}
