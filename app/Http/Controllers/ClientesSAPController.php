<?php

namespace App\Http\Controllers;



use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiClientesSAP;
use App\Models\ClientesFerias\ClientesFeria;
use App\Models\ClientesSAP;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ClientesSAPController extends Controller
{

    //la funcion Index lo que hace es consultar todos los clientes creados en la base de datos lo cual mediante la variable clientesSAP almacena esa respuesta y posteriormente con
    //un compact pasa la variable a la vista index.
    public function index(Request $request)
    {
        $clientes_ferias = ClientesFeria::all();
        $query = $request->input('query');

        $clientesSAP = ClientesSAP::when($query, function ($q) use ($query) {
            return $q->where('CardName', 'like', "%$query%")
                ->orWhere('CardCode', 'like', "%$query%")
                ->orWhere('Phone1', 'like', "%$query%");
        })->paginate(10);

        return view('ClientesSap.index', compact('clientesSAP', 'query', 'clientes_ferias'));
    }



    //la funcion create lo que hace es consultar todos los clientes creados en la base de datos lo cual mediante la variable clientesSAP almacena esa respuesta y posteriormente con
    //un compact pasa la variable a la vista create.
    public function create(Request $request)
    {


        $clientesSAP = ClientesSAP::all();
        return view('ClientesSap.create', compact('clientesSAP'));
    }


    // La funcion RegistroClienteSAP Esta función en PHP utiliza la biblioteca cURL para interactuar con una API de SAP. La función se llama "RegistroClienteSAP" y recibe un objeto "Request" como parámetro.
    //La primera parte de la función se conecta a la API de SAP para obtener un token de sesión (SessionId) utilizando una petición POST que incluye un JSON con los datos de inicio 
    //de sesión. Una vez obtenido el token, se utiliza para crear una nueva petición POST para crear un cliente en SAP, utilizando los datos recibidos en el objeto Request para completar la petición. 
    //La función devuelve el resultado de la petición al cliente.

    public function RegistroClienteSAP(Request $request)
    {
        try {
            // Configuración de SAP
            $sapBaseUrl = env('URI');
            $sapCompanyDB = env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV');
            $sapUsername = env('USER');
            $sapPassword = env('PASSWORD');

            // Cliente Guzzle para realizar solicitudes HTTP
            $client = new Client();

            // Autenticación en SAP
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

            // Datos proporcionados
            $CardCode = $request->input("CardCode");
            $CardName = $request->input("CardName");
            $FederalTaxID = $request->input("FederalTaxID");
            $Address = $request->input("Address");
            $Phone1 = $request->input("Phone1");
            $City = $request->input("City");
            $Country = $request->input("Country");
            $EmailAddress = $request->input("EmailAddress");

            // Construir el cuerpo de la solicitud
            $requestData = [
                "CardCode" => "L" . $CardCode,
                "CardName" => $CardName,
                "CardType" => "L",
                "FederalTaxID" => $FederalTaxID,
                "Address" => $Address,
                "Phone1" => $Phone1,
                "City" => $City,
                "Country" => $Country,
                "EmailAddress" => $EmailAddress,
                "GroupCode" => "108",
            ];
            

            // Enviar la solicitud de creación de cliente a SAP
            $clientesUrl = $sapBaseUrl . '/BusinessPartners';
            $response = $client->post($clientesUrl, [
                'headers' => [
                    'Cookie' => $cookie,
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData,
            ]);

            $responseBody = json_decode($response->getBody(), true);


            return response()->json(['success' => true]);

            // Operación fallida, proporciona detalles del error
            Log::error("Error al crear la solicitud de compra en SAP. Detalles: " . json_encode($responseBody));
            return response()->json(['success' => false, 'error' => 'Error al crear la solicitud de compra en SAP', 'details' => $responseBody]);
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


    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    // Esta función "ConsultarClientesSAP" también utiliza cURL para interactuar con la API de SAP. La función se conecta a la API utilizando una petición POST para obtener un token de 
    // sesión (SessionId) similar a la función anterior. Una vez obtenido el token, se utiliza para enviar una petición GET para obtener información de los clientes de SAP. 
    // La petición GET incluye dos parámetros de consulta en la URL: "$select" y "$filter". El parámetro $select especifica los campos que se desean seleccionar en la consulta,
    //  mientras que el parámetro $filter especifica una condición para filtrar los resultados de la consulta. En este caso se esta especificando que se desea seleccionar los campos CardCode, 
    // CardName, Cellular, Phone1, CardType, Currency y que se desea filtrar por GroupCode = 108. La función devuelve el resultado de la petición.

    public function consultarClientesSAP()
    {
        // Iniciar sesión y obtener SessionId
        $client = new Client();
        $loginUrl = env('URI') . "/Login";
        $loginResponse = $client->post($loginUrl, [
            'json' => [
                'CompanyDB' => env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV'),
                'Password' => env('PASSWORD'),
                'UserName' => env('USER'),
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    
        $loginData = json_decode($loginResponse->getBody(), true);
        $sessionId = $loginData['SessionId'];
    
        // Construir cookie
        $cookie = "B1SESSION=" . $sessionId . "; ROUTEID=.node4";
    
        // Consultar Business Partners
        $businessPartnersUrl = env('URI') . "/BusinessPartners";
        $response = $client->get($businessPartnersUrl, [
            'query' => [
                '$select' => 'CardCode,CardName,Cellular,Phone1,CardType,Currency',
            ],
            'headers' => [
                'Expect' => '',
                'Content-Type' => 'application/json',
                'Cookie' => $cookie,
            ],
        ]);
    
        return $response->getBody();
    }
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    // Esta función "RegistroClienteBD" se encarga de registrar los clientes obtenidos de la API de SAP en una base de datos local. La función crea una nueva instancia de la clase "ClientesSAPController" 
    // y llama al método "ConsultarClientesSAP" para obtener la información de los clientes de la API de SAP. Luego se decodifica el resultado de la petición en un arreglo y se recorre cada uno de los clientes 
    // obtenidos en la petición. Por cada cliente, se crea una nueva instancia de la clase "ClientesSAP" y se guarda los datos del cliente en la base de datos local. En caso de que ya exista un cliente con
    //  el mismo CardCode, se actualizan los datos. La función redirige al usuario a la página anterior con un mensaje de éxito.
    public function RegistroClienteBD(Request $request)
    {

        $response = new ClientesSAPController();
        $response = $response->ConsultarClientesSAP();
        $datos = array('response' => json_decode($response, true));
        $clientes = $datos['response']['value'];
        foreach ($clientes as $cliente) {

            $clientedb = new ClientesSAP();
            try {

                $clientedb->CardCode = $cliente['CardCode'];
                $clientedb->CardName = $cliente['CardName'];
                $clientedb->CardType = $cliente['CardType'];
                $clientedb->Phone1 = $cliente['Phone1'];
                $clientedb->Currency = $cliente['Currency'];
                $clientedb->Cellular = $cliente['Cellular'];
                $clientedb->save();
            } catch (Exception $e) {

                $post = ClientesSAP::firstOrNew(['CardCode' => $cliente['CardCode']]);
                // update record
                $post->CardCode =   $cliente['CardCode'];
                $post->CardName =   $cliente['CardName'];
                $post->CardType =   $cliente['CardType'];
                $post->Phone1 =     $cliente['Phone1'];
                $post->Currency =   $cliente['Currency'];
                $post->Cellular =   $cliente['Cellular'];
                $post->save();
            }
        }
        return redirect()->back()->with('success', 'Importacion masiva ejecutada correctamente!');
    }

    // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    // La función ConsultaClientesManualSAP realiza una consulta a una API de SAP mediante cURL para obtener información de un cliente específico, basado en el numero de cedula que se le pasa como parametro. 
    // Luego, toma los datos obtenidos y los guarda en un objeto de tipo "ClientesSAP" y
    // lo guarda en una base de datos. Si hay algún error en el proceso de guardado, devuelve un mensaje de error especificando el problema.
    public function ConsultaClientesManualSAP(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "50000",
            CURLOPT_URL => env('URI') . "/Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"HBT_DOBLAMOS\",\n    \"Password\": \"DOB890\",\n    \"UserName\": \"manager\"\n}",
            CURLOPT_HTTPHEADER => [
                "Content-Type: text/plain"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = (array)json_decode($response);
            $SessionId = $response['SessionId'];
        }

        $cookie = "B1SESSION=" . $SessionId . "; ROUTEID=.node4";

        //CONSULTA MANUAL SOCIOS DE NEGOCIO
        $CardCode = $request->input("Cedula");

        $curl = curl_init();

        $cadenados = '$select=CardCode,CardName,Cellular,Phone1,CardType,Currency';
        curl_setopt_array($curl, [
            CURLOPT_PORT => "50000",
            CURLOPT_URL => env('URI') . "/BusinessPartners('" . $CardCode . "')?" . $cadenados,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_COOKIE => $cookie,
            CURLOPT_HTTPHEADER => array(
                "Expect:",
                "Content-Type: application/json",
                "Cookie: B1SESSION=" . $SessionId . "; ROUTEID=.node2"
            )
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response, true);
        if ($response === null) {
            return 'Error al decodificar la respuesta del servidor: ' . json_last_error_msg();
        }
        if (is_array($response)) {
            $client = new ClientesSAP;
            try {
                $client->CardCode = $response['CardCode'];
                $client->CardName = $response['CardName'];
                $client->Cellular = $response['Cellular'];
                $client->Phone1 = $response['Phone1'];
                $client->CardType = $response['CardType'];
                $client->Currency = $response['Currency'];
                $client->save();
                return 'Cliente guardado exitosamente';
            } catch (\Exception $e) {
                return 'Error al guardar el cliente en la base de datos: ' . $e->getMessage();
            }
        } else {
            return 'Error al decodificar la respuesta del servidor';
        }
    }

    public function ConsultaClientesManualSAPGuardar(Request $request)
    {
        $result = $this->ConsultaClientesManualSAP($request);
        return $result;
    }




    public function upload(Request $request)
    {
        // Validar el archivo de Excel enviado
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        // Obtener el archivo de Excel y leer sus datos
        $file = $request->file('excel_file');
        $data = Excel::toArray([], $file)[0]; // Asumiendo que el archivo solo tiene una hoja de cálculo

        // Iterar sobre los datos y guardarlos en la base de datos
        foreach ($data as $row) {
            // Crear una nueva instancia del modelo ClientesFeria
            $clienteFeria = new ClientesFeria();

            // Asignar los valores de cada columna del archivo al modelo
            $clienteFeria->empresa = $row[0];
            $clienteFeria->contacto = $row[1];
            $clienteFeria->apellido = $row[2];
            $clienteFeria->pais = $row[3];
            $clienteFeria->region = $row[4];
            $clienteFeria->telefono = $row[5];
            $clienteFeria->correo = $row[6];
            $clienteFeria->vortex = $row[7];
            $clienteFeria->formaletas = $row[8];
            $clienteFeria->estructuras = $row[9];
            $clienteFeria->servicios = $row[10];
            $clienteFeria->venta_acero = $row[11];
            $clienteFeria->observaciones = $row[12];
            $clienteFeria->tipo_bd = $row[13];

            // Guardar el modelo en la base de datos
            $clienteFeria->save();
        }

        // Redireccionar o retornar una respuesta de éxito
        return redirect()->back()->with('success', 'Los datos se han guardado correctamente.');
    }
}
