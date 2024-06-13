<?php

namespace App\Http\Controllers\Cotizaciones_Formaletas;

use App\Http\Controllers\Controller;
use App\Models\Asesores;
use App\Models\ClientesSAP;
use App\Models\Cotizaciones_Formaletas\Cotizaciones_Formaleta;
use App\Models\Pais\PaisCordenadas;
use App\Models\Cotizaciones_Formaletas\Hitorico_formaleta;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;

class CotizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $cotiform = DB::table('cotizaciones__formaletas')
        ->join('clientes_s_a_p_s', 'cotizaciones__formaletas.clientes_id', '=', 'clientes_s_a_p_s.id')
        ->select(
            'cotizaciones__formaletas.id',
            'clientes_s_a_p_s.CardCode',
            'clientes_s_a_p_s.CardName',
            'clientes_s_a_p_s.Phone1',
            'cotizaciones__formaletas.Lugar_Obra',
            'cotizaciones__formaletas.Fecha_Recibido',
            'cotizaciones__formaletas.Fecha_Cotizada',
            'cotizaciones__formaletas.Nombre_Obra',
            'cotizaciones__formaletas.Valor_Adjudicado',
            'cotizaciones__formaletas.Tipologia',
            'cotizaciones__formaletas.Estado',
            'cotizaciones__formaletas.Kilogramos',
            'cotizaciones__formaletas.Incluye_Montaje'
        )
        ->get();
    
        return view('CotizacionesFormaletas.index',compact('cotiform'));
    }

//PRUEBA PARA BUSCAR EN SAP EL CLIENTE
public function prueba(Request $request)
{
    return view('CotizacionesFormaletas.prueba');
}



public function ConsultarClienteSAPPrueba(Request $request)
{
    $query = $request->input('cliente');

    // Validar el formato del cliente
    if (!preg_match('/^[CL]\d+$/', $query)) {
        return response()->json(['error' => 'El valor del cliente no es válido'], 400);
    }

    $client = new Client();

    // Realizar la solicitud de inicio de sesión
    $loginUrl = env('URI') . '/Login';
    $loginBody = [
        'CompanyDB' => env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV'),
        'Password' => env('PASSWORD'),
        'UserName' => env('USER'),
    ];

    $response = $client->post($loginUrl, [
        'json' => $loginBody,
    ]);

    $data = json_decode($response->getBody(), true);
    $sessionId = $data['SessionId'];

    // Construir el encabezado de la cookie
    $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';

    // Realizar la consulta de BusinessPartners
    $businessPartnersUrl = env('URI') . '/BusinessPartners(\'' . $query . '\')';
    $queryParameters = [
        '$select' => 'CardCode,CardName,Cellular,Phone1,CardType,Currency',
    ];

    $response = $client->get($businessPartnersUrl, [
        'query' => $queryParameters,
        'headers' => [
            'Cookie' => $cookie,
            'Content-Type' => 'application/json',
            'Expect' => '',
        ],
    ]);
    $body = $response->getBody();
    $data = json_decode($body, true);

    if (empty($body)) {
        // No se encontró ningún cliente en SAP
        return response()->json(['error' => 'No se encontró ningún cliente en SAP'], 404);
    }

    // Verificar si el cliente ya existe en la base de datos
    $clienteSAP = ClientesSAP::where('CardCode', $data['CardCode'])->first();

    if ($clienteSAP) {
        // El cliente ya existe, actualizar los datos
        $clienteSAP->CardName = $data['CardName'];
        $clienteSAP->Cellular = $data['Cellular'];
        $clienteSAP->Phone1 = $data['Phone1'];
        $clienteSAP->CardType = $data['CardType'];
        $clienteSAP->Currency = $data['Currency'];
        $clienteSAP->save();
    } else {
        // El cliente no existe, crear uno nuevo
        $clienteSAP = new ClientesSAP();
        $clienteSAP->CardCode = $data['CardCode'];
        $clienteSAP->CardName = $data['CardName'];
        $clienteSAP->Cellular = $data['Cellular'];
        $clienteSAP->Phone1 = $data['Phone1'];
        $clienteSAP->CardType = $data['CardType'];
        $clienteSAP->Currency = $data['Currency'];
        $clienteSAP->save();
        $clienteId = $clienteSAP->id; // Obtener el ID del cliente guardado
    }
    return response()->json(['cliente' => $data, 'clienteId' => $clienteSAP->id]);

}


public function ConsultarProveedoresSAP(Request $request)
{
    try {
        $query = $request->input('cliente');
    
        $client = new Client();
    
        // Realizar la solicitud de inicio de sesión
        $loginUrl = env('URI') . '/Login';
        $loginBody = [
            'CompanyDB' => env('APP_ENV') === 'production' ? env('COMPANYDB_PROD') : env('COMPANYDB_DEV'),
            'Password' => env('PASSWORD'),
            'UserName' => env('USER'),
        ];
    
        $response = $client->post($loginUrl, [
            'json' => $loginBody,
        ]);
    
        $data = json_decode($response->getBody(), true);
        $sessionId = $data['SessionId'];
    
        // Construir el encabezado de la cookie
        $cookie = 'B1SESSION=' . $sessionId . '; ROUTEID=.node4';
    
        // Realizar la consulta de BusinessPartners
        $businessPartnersUrl = env('URI') . '/BusinessPartners';
        $queryParameters = [
            '$filter' => "CardType eq 'cSupplier' and (substringof('$query', CardName) or substringof('$query', CardCode))",
            '$select' => 'CardCode,CardName,Cellular,Phone1,CardType,Currency',
        ];
    
        $response = $client->get($businessPartnersUrl, [
            'query' => $queryParameters,
            'headers' => [
                'Cookie' => $cookie,
                'Content-Type' => 'application/json',
                'Expect' => '',
            ],
        ]);
        
        $body = $response->getBody();
        $data = json_decode($body, true);
    
        if (empty($data['value'])) {
            // No se encontró ningún cliente en SAP
            return response()->json(['error' => 'Verifica la informacion ingresada, No se encontro proveedor en SAP'], 404);
        }
    
        // Verificar si el cliente ya existe en la base de datos
        $clienteSAP = null;
    
        if (isset($data['value'][0]['CardCode'])) {
            $clienteSAP = ClientesSAP::where('CardCode', $data['value'][0]['CardCode'])->first();
        }
    
        if ($clienteSAP) {
            // El cliente ya existe, actualizar los datos
            $clienteSAP->CardName = $data['value'][0]['CardName'];
            $clienteSAP->Cellular = $data['value'][0]['Cellular'];
            $clienteSAP->Phone1 = $data['value'][0]['Phone1'];
            $clienteSAP->CardType = $data['value'][0]['CardType'];
            $clienteSAP->Currency = $data['value'][0]['Currency'];
            $clienteSAP->save();
            return response()->json(['message' => 'Proveedor consultado en SAP y actualizado exitosamente', 'cliente' => $data['value'][0], 'clienteId' => $clienteSAP->id]);
        } else {
            // El cliente no existe, crear uno nuevo
            $clienteSAP = new ClientesSAP();
            if (isset($data['value'][0]['CardCode'])) {
                $clienteSAP->CardCode = $data['value'][0]['CardCode'];
            }
            $clienteSAP->CardName = $data['value'][0]['CardName'];
            $clienteSAP->Cellular = $data['value'][0]['Cellular'];
            $clienteSAP->Phone1 = $data['value'][0]['Phone1'];
            $clienteSAP->CardType = $data['value'][0]['CardType'];
            $clienteSAP->Currency = $data['value'][0]['Currency'];
            $clienteSAP->save();
            return response()->json(['message' => 'Proveedor consultado en SAP y guardado exitosamente', 'cliente' => $data['value'][0], 'clienteId' => $clienteSAP->id]);
        }
    
        return response()->json(['cliente' => $data['value'][0], 'clienteId' => $clienteSAP->id]);
    } catch (\Exception $e) {
        // Handle exceptions here
        return response()->json(['error' => $e->getMessage()], 500);
    }
}





    public function create()
    {
        $asesores = Asesores::all();
        $pais = PaisCordenadas::all();
        return view('CotizacionesFormaletas.create',compact('asesores','pais'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'Nombre_Obra' => 'required',
                'Lugar_Obra' => 'required',
                'Fecha_Recibido' => 'required',
                'Fecha_Cotizada' => 'required',
                'Valor_Antes_Iva' => 'required',
                'Estado' => 'required',
                'Tipologia' => 'required',
                'Valor_Adjudicado' => 'required',
                'Valor_Kilogramo' => 'required',
                'Metros_Cuadrados' => 'required',
                'Kilogramos' => 'required',
                'Asesor_id' => 'required',
                'Origen' => 'required',
                'Incluye_Montaje' => 'required',
                'clientes_id' => 'required',
                'pais_id' => 'required',
                'Departamento' => 'required',
                
               
            ], [
                'Nombre_Obra.required' => 'El campo Nombre de La Obra es obligatorio.',
                'Lugar_Obra.required' => 'El campo Lugar de Obra es obligatorio.',
                'Fecha_Recibido.required' => 'Por favor Ingresa la fecha Recibido',
                'Fecha_Cotizada.required' => 'Fecha cotizada vacia',
                'Valor_Antes_Iva.required' => 'Por favor ingresar el valor antes de iva',
                'Estado.required' => 'El campo Estado es obligatorio',
                'Tipologia.required' => 'El campo tipologia esta vacio',
                'Valor_Adjudicado.required' => 'Ingrese un valor adjudicado',
                'Valor_Kilogramo.required' => 'Valor Kilogramo vacio',
                'Metros_Cuadrados.required' => 'El campo metros cuadrado es obligatorio',
                'Kilogramos.required' => 'El campo Kilogramos es obligatorio',
                'Asesor_id.required' => 'Por favor selecciona el asesor',
                'Origen.required' => 'Por favor selecciona almenos un origen',
                'Incluye_Montaje.required' => 'El campo incluye montaje es obligatorio',
                'clientes_id.required' => 'El cliente no se ha consultado en SAP',
                'pais_id.required' => 'El campo pais no se ha seleccionado',
                'Departamento.required' => 'Selecciona el departamento'

                // Agrega los mensajes personalizados para cada campo aquí
            ]);
    
            $cotiformaletas = new Cotizaciones_Formaleta();
            $cotiformaletas->Nombre_Obra = $request->input('Nombre_Obra');
            $cotiformaletas->Lugar_Obra = $request->input('Lugar_Obra');
            $cotiformaletas->Fecha_Recibido = $request->input('Fecha_Recibido');
            $cotiformaletas->Fecha_Cotizada = $request->input('Fecha_Cotizada');
            $cotiformaletas->Valor_Antes_Iva = $request->input('Valor_Antes_Iva');
            $cotiformaletas->Estado = $request->input('Estado');
            $cotiformaletas->Tipologia = $request->input('Tipologia');
            $cotiformaletas->Valor_Adjudicado = $request->input('Valor_Adjudicado');
            $cotiformaletas->Valor_Kilogramo = $request->input('Valor_Kilogramo');
            $cotiformaletas->Metros_Cuadrados = $request->input('Metros_Cuadrados');
            $cotiformaletas->Kilogramos = $request->input('Kilogramos');
            $cotiformaletas->Asesor_id = $request->input('Asesor_id');
            $cotiformaletas->Origen = $request->input('Origen');
            $cotiformaletas->Incluye_Montaje = $request->input('Incluye_Montaje');
            $cotiformaletas->clientes_id = $request->input('clientes_id');
            $cotiformaletas->pais_id = $request->input('pais_id');
            $cotiformaletas->Departamento = $request->input('Departamento');
            $cotiformaletas->Fecha_Venta = $request->input('Fecha_Venta');
            $cotiformaletas->save();
    
            return redirect()->back()->with('success', 'Cotizacion registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = [];
            foreach ($e->errors() as $field => $errors) {
                $errorMessage = implode(', ', $errors);
                $errorMessages[] = $field . ': ' . $errorMessage;
            }
            $errorMessage = 'Error en la validación de campos: ' . implode(' | ', $errorMessages);
            return redirect()->back()->withErrors($errorMessage)->withInput();
        } catch (\Exception $e) {
            $errorMessage = 'Error general: ' . $e->getMessage();
            return redirect()->back()->withErrors($errorMessage)->withInput();
        }
    }
    
    
    public function destroy($id)
    {
        try {
            $cotizacion = Cotizaciones_Formaleta::findOrFail($id);
            $cotizacion->delete();
            
            return redirect()->back()->with('success', 'Registro eliminado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    public function edit($id){

        $cotizacionesformaleta = Cotizaciones_Formaleta::findOrFail($id);
        $asesores = Asesores::all();
        $pais = PaisCordenadas::all();
        return view('CotizacionesFormaletas.edit',compact('cotizacionesformaleta','asesores','pais'));
    }
    
    public function update(Request $request, $id)
{
    try {
        $cotiformaletas = Cotizaciones_Formaleta::findOrFail($id);
        $cotiformaletas->Nombre_Obra = $request->input('Nombre_Obra');
        $cotiformaletas->Lugar_Obra = $request->input('Lugar_Obra');
        $cotiformaletas->Fecha_Recibido = $request->input('Fecha_Recibido');
        $cotiformaletas->Fecha_Cotizada = $request->input('Fecha_Cotizada');
        $cotiformaletas->Valor_Antes_Iva = $request->input('Valor_Antes_Iva');
        $cotiformaletas->Estado = $request->input('Estado');
        $cotiformaletas->Tipologia = $request->input('Tipologia');
        $cotiformaletas->Valor_Adjudicado = $request->input('Valor_Adjudicado');
        $cotiformaletas->Valor_Kilogramo = $request->input('Valor_Kilogramo');
        $cotiformaletas->Metros_Cuadrados = $request->input('Metros_Cuadrados');
        $cotiformaletas->Kilogramos = $request->input('Kilogramos');
        $cotiformaletas->Asesor_id = $request->input('Asesor_id');
        $cotiformaletas->Origen = $request->input('Origen');
        $cotiformaletas->Incluye_Montaje = $request->input('Incluye_Montaje');
        $cotiformaletas->clientes_id = $request->input('clientes_id');
        $cotiformaletas->pais_id = $request->input('pais_id');
        $cotiformaletas->Departamento = $request->input('Departamento');
        $cotiformaletas->Fecha_Venta = $request->input('Fecha_Venta');
        $cotiformaletas->save();

        return redirect()->back()->with('success', 'Cotización actualizada con éxito.');
    } catch (\Exception $e) {
        $errorMessage = 'Error general: ' . $e->getMessage();
        return redirect()->back()->withErrors($errorMessage)->withInput();
    }
}

public function historicoformaleta(){
    $hisformaleta = Hitorico_formaleta::all();
    return view('CotizacionesFormaletas.Historico',compact('hisformaleta'));
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
        // Crear una nueva instancia del modelo HistoricoFormaletas
        $historicoFormaletas = new Hitorico_formaleta();

        // Asignar los valores de cada columna del archivo al modelo
        $historicoFormaletas->area = $row[0];
        $historicoFormaletas->numero_obra = $row[1];
        $historicoFormaletas->empresa = $row[2];
        $historicoFormaletas->fecha_recibido = $row[3];
        $historicoFormaletas->estado = $row[4];
        $historicoFormaletas->asesor = $row[5];
        $historicoFormaletas->observaciones = $row[6];
        $historicoFormaletas->seguimiento = $row[7];
        $historicoFormaletas->requiereing = $row[8];
        $historicoFormaletas->valorcotizado = $row[9];
        $historicoFormaletas->valoradjudicado = $row[10];
        $historicoFormaletas->numeroorden = $row[11];
        $historicoFormaletas->numerofactura = $row[12];
        $historicoFormaletas->fechafactura = $row[13];
        $historicoFormaletas->pesokg = $row[14];
        $historicoFormaletas->aream2 = $row[15];
        $historicoFormaletas->{'/kg'} = $row[16];
        $historicoFormaletas->cantidadelementos = $row[17];

        // Guardar el modelo en la base de datos
        $historicoFormaletas->save();
    }

    // Redireccionar o retornar una respuesta de éxito
    return redirect()->back()->with('success', 'Los datos se han guardado correctamente.');
}

}