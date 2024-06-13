<?php

namespace App\Http\Controllers\IntegracionSAP;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AnalisisVentaVorteController extends Controller
{
    public function index(Request $request)
    {
        // Llamamos a la función consultarVentasSAP() para obtener los datos de ventas
        $ventas = $this->consultarVentasvorteSAP($request);
    
        // Pasamos los datos de ventas a la vista 'index' en forma de variable
        return view('AnalisisVentas.Vorte', compact('ventas'));
    }
    

    public function consultarVentasvorteSAP(Request $request)
    {
        // Configuración de la API SAP Business One
        $sapBaseUrl = env('URI');
        $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
        $sapUsername = env('USER');
        $sapPassword = env('PASSWORD');

        $client = new Client();

        // Realizar la solicitud de inicio de sesión
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

        // Construir el encabezado de la cookie
        $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Validar que las fechas no estén vacías y estén en el formato adecuado
        if (!$start_date || !$end_date || !strtotime($start_date) || !strtotime($end_date)) {
            return response()->json(['error' => 'Fechas inválidas'], 400);
        }

        // Escapar las fechas correctamente en la URL para la consulta
        $start_date = urlencode(date('Y-m-d', strtotime($start_date)));
        $end_date = urlencode(date('Y-m-d', strtotime($end_date)));
        $cardCode = $request->input('CardCode');

        // Realizar la consulta de ventas (ANALISIS_VENTA) con el filtro por fecha
        $ventasUrl = $sapBaseUrl . "/sml.svc/ANALISIS_VENTA?\$select=CardCode,CardName,ValorIva,ValorTotal,DocNum,Kg_Vendidos,TipoDoc,DocDate,DocDueDate,Centro_Operaciones,Centro_Costo&\$filter=DocDate ge '$start_date' and DocDate le '$end_date' and Centro_Costo eq 'LFA'";
        // Si el CardCode está presente, agregarlo al filtro de la consulta
        if ($cardCode) {
            $ventasUrl .= " and CardCode eq '$cardCode'";
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
            // No se encontraron ventas en SAP para el rango de fechas especificado
            return collect(); // Devolvemos una colección vacía
        }

        // Procesar los datos de ventas obtenidos
        $ventas = collect($data['value'])->map(function ($venta) {
            return [
                'CardCode' => $venta['CardCode'],
                'CardName' => $venta['CardName'],
                'ValorIva' => $venta['ValorIva'],
                'ValorTotal' => $venta['ValorTotal'],
                'DocNum' => $venta['DocNum'],
                'Kg_Vendidos'=> $venta['Kg_Vendidos'],
                'TipoDoc' => $venta['TipoDoc'],
                'DocDate' =>$venta['DocDate'],
                'DocDueDate' =>$venta['DocDueDate'],
                'Centro_Operaciones' =>$venta['Centro_Operaciones'],
                'Centro_Costo' =>$venta['Centro_Costo']
            ];
        });
        return $ventas;
    }
}
