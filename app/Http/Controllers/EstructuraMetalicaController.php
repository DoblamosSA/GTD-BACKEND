<?php

namespace App\Http\Controllers;

use App\Models\EstructuraMelalica;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstructmetalicaExport;
use App\Imports\EstruMetalicasImport;
use App\Http\Controllers\Clientescontroller;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
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
       $clientes = Cliente::all();
       
        return view('EstructrasMetalicas.index',compact('estructuraMelalica','clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estructuraMelalica = new EstructuraMelalica();
        $clientes = Cliente::all();
        return view('EstructrasMetalicas.create',compact('estructuraMelalica','clientes'));
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
            'Numero_Obra' => 'required',
            'Nombre_Obra' => 'required',
            'Lugar_Obra' =>'required',
            'Fecha_Recibido' => 'nullable|date',
            'Fecha_Cotizada' => 'nullable|date',
            'Valor_Antes_Iva' => 'required | numeric',
            'Valor_Adjudicado' => 'required',
            'Tipologia' => 'required',
            'Estado' => 'required',
            'Peso_Cotizado'  => 'required',
            'Area_Cotizada' => 'required ', 
            'clientes_id' =>'required'
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
}