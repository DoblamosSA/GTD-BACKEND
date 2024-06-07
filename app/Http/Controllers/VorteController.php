<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Vorte;
use App\Http\Controllers\ClientesSAPController;
use Illuminate\View\ViewServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeguimientosVortexExport;
use App\Models\Asesores;
use App\Models\ClientesSAP;
use App\Models\HistorialCotizacionesVortex\HistorialCotizaciones;
use App\Models\Pais\PaisCordenadas;
use Exception;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Models\Vortex\SeguimientosCRM;

class VorteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vorte = DB::table('vortes')
            ->join('clientes_s_a_p_s', 'vortes.clientes_id', '=', 'clientes_s_a_p_s.id')
            ->join('asesores', 'vortes.Asesor_id', '=', 'asesores.id')
            ->join('pais_cordenadas', 'vortes.Pais', '=', 'pais_cordenadas.id')
            ->select(
                'vortes.Total_Asesor',
                'clientes_s_a_p_s.CardCode',
                'clientes_s_a_p_s.CardName',
                'clientes_s_a_p_s.Phone1',
                'vortes.Nombre_Obra',
                'vortes.Lugar_Obra',
                'vortes.Fecha_Recibido',
                'vortes.Fecha_Cotizada',
                'vortes.Fecha_Venta',
                'vortes.Valor_Antes_Iva',
                'vortes.Valor_Adjudicado',
                'vortes.Tipologia',
                'vortes.Estado',
                'vortes.m2',
                'vortes.Incluye_Montaje',
                'vortes.Origen',
                'asesores.Nombre_Asesor',
                'pais_cordenadas.countryName',
                'vortes.Metros_Cuadrados',
                'vortes.Fecha_Venta',
                'vortes.id' // Agrega la columna id para poder acceder a ella en la vista
            )
            ->get();
    
        return view('vortexDoblamos.index', compact('vorte'));
    }
    
public function seguimiento(){
    $vorte = DB::table('vortes')
    ->join('clientes_s_a_p_s', 'vortes.clientes_id', '=', 'clientes_s_a_p_s.id')
    ->join('asesores', 'vortes.Asesor_id', '=', 'asesores.id')
    ->join('pais_cordenadas', 'vortes.Pais', '=', 'pais_cordenadas.id')
    ->select(
        'vortes.Total_Asesor',
        'clientes_s_a_p_s.CardCode',
        'clientes_s_a_p_s.CardName',
        'clientes_s_a_p_s.Phone1',
        'vortes.Nombre_Obra',
        'vortes.Lugar_Obra',
        'vortes.Fecha_Recibido',
        'vortes.Fecha_Cotizada',
        'vortes.Fecha_Venta',
        'vortes.Valor_Antes_Iva',
        'vortes.Valor_Adjudicado',
        'vortes.Tipologia',
        'vortes.Estado',
        'vortes.m2',
        'vortes.Incluye_Montaje',
        'vortes.Origen',
        'asesores.Nombre_Asesor',
        'pais_cordenadas.countryName',
        'vortes.Metros_Cuadrados',
        'vortes.Fecha_Venta',
        'vortes.id' // Agrega la columna id para poder acceder a ella en la vista
    )
    ->get();

return view('vortexDoblamos.SeguimientosCotizaciones', compact('vorte'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $query = $request->input('query');
    
        $clientesSAP = ClientesSAP::when($query, function($q) use ($query) {
            return $q->where('CardName', 'like', "%$query%")
                     ->orWhere('CardCode', 'like', "%$query%")
                     ->orWhere('Phone1', 'like', "%$query%");
        })->paginate(10);

        $vorte = new Vorte();
        $Asesor = Asesores::all();
        $pais =PaisCordenadas::all();
    
        return view('vortexDoblamos.create', compact('vorte', 'clientesSAP','Asesor','pais'));
    }
    

    public function BuscarCliente(Request $request){
        $query = $request->input('cliente');

        $clientesSAP = ClientesSAP::when($query, function($q) use ($query) {
            return $q->where('CardName', 'like', "%$query%")
                     ->orWhere('CardCode', 'like', "%$query%")
                     ->orWhere('Phone1', 'like', "%$query%");
        })->get();
    
        return response()->json($clientesSAP);
    }
    

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
                $request->validate([
            
                    'Nombre_Obra' => 'required',
                    'clientes_id' => 'required|numeric',
                    'Asesor_id'=> 'required|numeric'
                
                ],[
                    'Nombre_Obra.required' => 'El campo Nombre de La Obra es obligatorio.',
                    'clientes_id.required' => 'El cliente no se ha consultado en SAP',
                    'Asesor_id.required' => 'Por favor selecciona el asesor', 
                ]);

      
            $vorte = new Vorte();
            $vorte->Numero_Obra = $request->Numero_Obra;
            $vorte->Nombre_Obra = $request->Nombre_Obra;
            $vorte->Lugar_Obra = $request->Lugar_Obra;
            $vorte->Fecha_Recibido = $request->Fecha_Recibido;
            $vorte->Fecha_Cotizada = $request->Fecha_Cotizada;
            $vorte->Valor_Antes_Iva = $request->Valor_Antes_Iva;
            $vorte->Valor_Adjudicado = $request->Valor_Adjudicado;
            $vorte->Tipologia = $request->Tipologia;
            $vorte->Estado = $request->Estado;
            $vorte->m2= $request->m2;
            $vorte->Incluye_Montaje = $request->Incluye_Montaje;
            $vorte->Origen = $request->Origen;
            $vorte->clientes_id = $request->clientes_id;
            $vorte->Asesor_id = $request->Asesor_id;
            $vorte->Metros_Cuadrados= $request->Metros_Cuadrados;
            $vorte->Total_Asesor= $request->Total_Asesor;
            $vorte->Pais = $request->Pais;
            $vorte->Fecha_Venta = $request->Fecha_Venta;
            $vorte->save();
           
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

    public function edit($id)
    {
        //sirve para editar la tabla
        $pais = PaisCordenadas::all();
        $vorte = Vorte::findOrFail($id);
        $Asesor = Asesores::all();
        return view('vortexDoblamos.edit', compact('vorte','Asesor','pais'));
    }

  

    public function update(Request $request, $id)
    {
        $vorte = Vorte::findOrFail($id);
        $vorte->fill($request->all());
        $vorte->save();
    
        return redirect()->route('vortexDoblamos.index')->with('success','Registro actualizado exitosamente.');
    }

   
    public function destroy($id)
    {
        $vorte = Vorte::find($id)->delete();

        return redirect()->route('vortexDoblamos.index')
            ->with('eliminar', 'ok');
    }


    
    public function exportExcelvortex()
    {
        return Excel::download(new SeguimientosVortexExport, 'seguimientocotizacionesvortex.xlsx');
    }

   public function HistoricoCotizaciones(){
     
    $historialCotizaciones = HistorialCotizaciones::all();
   return view('vortexDoblamos.Historico',compact('historialCotizaciones'));
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
            // Crear una nueva instancia del modelo HistorialCotizaciones
            $historialCotizacion = new HistorialCotizaciones();

            // Asignar los valores de cada columna del archivo al modelo
            $historialCotizacion->Numero_Obra = $row[0];
            $historialCotizacion->Empresa_Cliente = $row[1];
            $historialCotizacion->Fecha_Recibido = $row[2];
            $historialCotizacion->Nombre_Obra = $row[3];
            $historialCotizacion->Descripcion = $row[4];
            $historialCotizacion->Estado = $row[5];
            $historialCotizacion->Fecha_Cotizada = $row[6];
            $historialCotizacion->Valor_Antes_Iva = $row[7];
            $historialCotizacion->Contacto = $row[8];
            $historialCotizacion->Area_M2 = $row[9];
            $historialCotizacion->M2 = $row[10];
            $historialCotizacion->Incluye_Montaje = $row[11];
            $historialCotizacion->Origen = $row[12];

            // Guardar el modelo en la base de datos
            $historialCotizacion->save();
        }

        // Redireccionar o retornar una respuesta de éxito
        return redirect()->back()->with('success', 'Los datos se han guardado correctamente.');
    }

    public function GenerarSeguimientoCotizacion(Request $request, $idseguimiento)
    {
        try {
            // Busca el seguimiento existente por su ID
            $seguimiento = new SeguimientosCRM();

            // Actualiza los campos del seguimiento con los datos del formulario
            $seguimiento->vorte_id = $idseguimiento;
            $seguimiento->Fecha_Seguimiento = $request->input('Fecha_Seguimiento');
            $seguimiento->Fecha_Nuevo_Seguimiento = $request->input('Fecha_Nuevo_Seguimiento');
            $seguimiento->Evento = $request->input('Evento');
            $seguimiento->Observaciones = $request->input('Observaciones');

            // Guarda los cambios
            $seguimiento->save();

            // Devuelve una respuesta exitosa
            return response()->json(['message' => 'Seguimiento actualizado correctamente']);
        } catch (\Exception $e) {
            // Maneja el caso en que ocurra un error
            return response()->json(['error' => 'Error al actualizar el seguimiento: ' . $e->getMessage()], 500);
        }
    }



    public function obtenerseguimientos($id)
    {

        // Obtener los seguimientos asociados a la solicitud de seguimiento
        $seguimientos = SeguimientosCRM::where('vorte_id', $id)->get();

        // Devolver los seguimientos en formato JSON
        return response()->json([
            'id_solicitud' => $id,
            'seguimientos' => $seguimientos,
        ], 200);
    }
}