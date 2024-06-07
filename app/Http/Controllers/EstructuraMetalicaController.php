<?php

namespace App\Http\Controllers;

use App\Models\EstructuraMelalica;
use Illuminate\Http\Request;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstructmetalicaExport;
use App\Imports\EstruMetalicasImport;
use App\Http\Controllers\ClientesSAPController;
use App\Models\ClientesSAP;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Estructuras\EstructurasSeguimientosCRM;
class EstructuraMetalicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $estructuraMelalica = EstructuraMelalica::all();
       $clientes = ClientesSAP::all();
       
        return view('EstructrasMetalicas.index',compact('estructuraMelalica','clientes'));
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

        $estructuraMelalica = new EstructuraMelalica();
       
        return view('EstructrasMetalicas.create',compact('estructuraMelalica','clientesSAP'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'Nombre_Obra' => 'required',
            'Lugar_Obra' =>'required',
            'Fecha_Recibido' => 'nullable|date',
            'Fecha_Cotizada' => 'nullable|date',
            
            'Tipologia' => 'required',
            'Estado' => 'required',
            
            
            'clientes_id' => 'required|numeric',
        ]);
        $estructuraMelalica = new EstructuraMelalica();
        $estructuraMelalica->Numero_Obra = $request->Numero_Obra;
        $estructuraMelalica->Nombre_Obra = $request->Nombre_Obra;
        $estructuraMelalica->Lugar_Obra = $request->Lugar_Obra;
        $estructuraMelalica->Fecha_Recibido = $request->Fecha_Recibido;
        $estructuraMelalica->Fecha_Cotizada = $request->Fecha_Cotizada;
        $estructuraMelalica->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $estructuraMelalica->Valor_Adjudicado = $request->Valor_Adjudicado;
        $estructuraMelalica->Tipologia = $request->Tipologia;
        $estructuraMelalica->Estado = $request->Estado;
        $estructuraMelalica->Peso_Cotizado = $request->Peso_Cotizado;
        $estructuraMelalica->Area_Cotizada = $request->Area_Cotizada;
        $estructuraMelalica->clientes_id =$request->clientes_id;
      
      
        $estructuraMelalica->save();
       
        return redirect()->route('estructurasMetalicas.index')
        ->with('eliminar', 'actual');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      //sirve para editar la tabla

      $estructuraMelalica = EstructuraMelalica::findOrFail($id);
    
      return view('EstructrasMetalicas.edit', compact('estructuraMelalica'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
     

        $estructuraMelalica=EstructuraMelalica::findOrFail($id);
        $estructuraMelalica->Numero_Obra = $request->Numero_Obra;
        $estructuraMelalica->Nombre_Obra = $request->Nombre_Obra;
        $estructuraMelalica->Lugar_Obra = $request->Lugar_Obra;
        $estructuraMelalica->Fecha_Recibido = $request->Fecha_Recibido;
        $estructuraMelalica->Fecha_Cotizada = $request->Fecha_Cotizada;
        $estructuraMelalica->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $estructuraMelalica->Valor_Adjudicado = $request->Valor_Adjudicado;
        $estructuraMelalica->Tipologia = $request->Tipologia;
        $estructuraMelalica->Estado = $request->Estado;
        $estructuraMelalica->Peso_Cotizado = $request->Peso_Cotizado;
        $estructuraMelalica->Area_Cotizada = $request->Area_Cotizada;
        
        
        $estructuraMelalica->save();
        return redirect()->route('estructurasMetalicas.index')
            ->with('eliminar', 'actual');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estructuraMelalica = EstructuraMelalica::find($id)->delete();

        return redirect()->route('estructurasMetalicas.index')
            ->with('eliminar', 'ok');
    }


    public function exportExcelEstr(){

        return Excel::download(new EstructmetalicaExport, 'seguimientoEstructurasMet.xlsx');
    }

    public function importExcel(){

        return view('EstructrasMetalicas.import');
    }


    function impStore( Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        
        $file = $request->file('file')->getRealPath();

        Excel::import(new EstruMetalicasImport, $file);
        //    return  Excel::toCollection(new  CotizacionImport, $file );

        return 'exitoso';
    }
	 public function GenerarSeguimientoCotizacion(Request $request, $idseguimiento)
    {
        try {
            // Busca el seguimiento existente por su ID
            $seguimiento = new EstructurasSeguimientosCRM();

            // Actualiza los campos del seguimiento con los datos del formulario
            $seguimiento->estructuras_id = $idseguimiento;
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
        $seguimientos = EstructurasSeguimientosCRM::where('estructuras_id', $id)->get();

        // Devolver los seguimientos en formato JSON
        return response()->json([
            'id_solicitud' => $id,
            'seguimientos' => $seguimientos,
        ], 200);
    }
}