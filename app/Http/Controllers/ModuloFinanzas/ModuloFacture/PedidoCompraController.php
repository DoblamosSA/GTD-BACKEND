<?php

namespace App\Http\Controllers\ModuloFinanzas\ModuloFacture;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PedidoCompraController extends Controller
{
    public function index(Request $request)
    {
        return view('ModuloFinanzas.ModuloFacture.OrdenesCompra');
    }

    public function pedidocompraSAP(Request $request)
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
        $docnum = $request->input('docnum'); // Changed the name to docnum

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
                    'CostingCode4' =>$line['CostingCode4']
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
               
                // ... Other extracted data ...
                'LineItems' => $ventasLineItems,
            ];
        });

        return response()->json($ventas);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Ups, an error occurred: ' . $e->getMessage()], 500);
    }
}

}
