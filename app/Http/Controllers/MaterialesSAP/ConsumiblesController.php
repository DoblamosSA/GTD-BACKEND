<?php

namespace App\Http\Controllers\MaterialesSAP;

use App\Http\Controllers\Controller;
use App\Models\MaterialesSAP\Consumibles_sap;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class ConsumiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = $request->input('query');

        $consumibles = Consumibles_sap::when($query, function ($q) use ($query) {
            return $q->where('ItemName', 'like', "%$query%")
                ->orWhere('ItemCode', 'like', "%$query%");
        })->paginate(10);

        return view('Materiales.Consumibles', compact('consumibles', 'query'));
    }

    public function MaterialesConsumibles()
    {
        // Crear una instancia del cliente Guzzle
        $client = new Client();

        // Realizar la solicitud de inicio de sesión
        $response = $client->post(env('URI') . "/Login", [
            'json' => [
                'CompanyDB' => env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV'),
                'Password' => env('PASSWORD'),
                'UserName' => env('USER'),
            ],
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        // Decodificar la respuesta JSON y obtener el SessionId
        $responseData = json_decode($response->getBody(), true);
        $sessionId = $responseData['SessionId'];

        // Construir la cookie para las siguientes solicitudes
        $cookie = "B1SESSION=" . $sessionId . "; ROUTEID=.node4";

        // Realizar la consulta de materiales
        $response = $client->get(env('URI') . "/Items", [
            'query' => [
                '$select' => 'ItemCode,ItemName',
                '$filter' => "(U_DOB_Grupo eq '02' or U_DOB_Grupo eq '03' or U_DOB_Grupo eq '01' or (U_DOB_Grupo eq '09' and ItemsGroupCode eq 218) or (U_DOB_Grupo eq '02' and ItemsGroupCode eq 242))",
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Cookie' => $cookie,
                'B1SESSION' => $sessionId,
                'ROUTEID' => '.node2',
            ],
        ]);

        // Decodificar la respuesta JSON y obtener los materiales
        $materiales = json_decode($response->getBody(), true)['value'];

        return $materiales;
    }

    public function GuardarConsumiblesSAPbd()
    {
        // Obtener los materiales de la función MaterialesConsumibles
        $materiales = $this->MaterialesConsumibles();

        // Iterar sobre los materiales y actualizar o crear en la base de datos
        foreach ($materiales as $material) {
            Consumibles_sap::updateOrCreate(
                ['ItemCode' => $material['ItemCode']],
                ['ItemName' => $material['ItemName']]
            );
        }

        // Redireccionar de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Importación ejecutada correctamente');
    }
}
