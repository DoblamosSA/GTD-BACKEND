<?php

namespace App\Http\Controllers;

use App\Models\EstructuraMelalica;
use Illuminate\Http\Request;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstructmetalicaExport;
use App\Imports\EstruMetalicasImport;

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
        return view('EstructrasMetalicas.index',compact('estructuraMelalica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estructuraMelalica = new EstructuraMelalica();
        return view('EstructrasMetalicas.create',compact('estructuraMelalica'));
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
            'Numero_Obra' => 'required | numeric',
            'Empresa_Cliente' => 'required',
            'Fecha_Recibido' => 'nullable|date',
            'Nombre_Obra' => 'required',
            'Descripcion' => 'required',
            'Estado' => 'required',
            'Fecha_Cotizada' => 'nullable|date',
            'Valor_Antes_Iva' => 'required | numeric',
            'Contacto'  => 'required',
            'AreaM2' => 'required | numeric',
            'm2' => 'required | numeric',
            'Incluye_Montaje'=> 'required',
           
        ]);
        $estructuraMelalica = new EstructuraMelalica();
        $estructuraMelalica->Numero_Obra = $request->Numero_Obra;
        $estructuraMelalica->Empresa_Cliente = $request->Empresa_Cliente;
        $estructuraMelalica->Fecha_Recibido = $request->Fecha_Recibido;
        $estructuraMelalica->Nombre_Obra = $request->Nombre_Obra;
        $estructuraMelalica->Descripcion = $request->Descripcion;
        $estructuraMelalica->Estado = $request->Estado;
        $estructuraMelalica->Fecha_Cotizada = $request->Fecha_Cotizada;
        $estructuraMelalica->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $estructuraMelalica->Contacto = $request->Contacto;
        $estructuraMelalica->AreaM2 = $request->AreaM2;
        $estructuraMelalica->m2 = $request->m2;
        $estructuraMelalica->Incluye_Montaje = $request->Incluye_Montaje;
        
        $estructuraMelalica->save();
        return redirect()->route('estructurasMetalicas.index');

        
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
        $estructuraMelalica->Empresa_Cliente = $request->Empresa_Cliente;
        $estructuraMelalica->Fecha_Recibido = $request->Fecha_Recibido;
        $estructuraMelalica->Nombre_Obra = $request->Nombre_Obra;
        $estructuraMelalica->Descripcion = $request->Descripcion;
        $estructuraMelalica->Estado = $request->Estado;
        $estructuraMelalica->Fecha_Cotizada = $request->Fecha_Cotizada;
        $estructuraMelalica->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $estructuraMelalica->Contacto = $request->Contacto;
        $estructuraMelalica->AreaM2 = $request->AreaM2;
        $estructuraMelalica->m2 = $request->m2;
        $estructuraMelalica->Incluye_Montaje = $request->Incluye_Montaje;
        
        
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
            'file' =>'required|mimes:xls,xlsx'
        ]);
        Excel::import(new EstruMetalicasImport, $request->file('file')->store('temp'));
        return back();
 
//         $file = $request->file('file');
//         //  Excel::import(new EstruMetalicasImport, $file );
//            return  Excel::toCollection(new  EstruMetalicasImport, $file );
            
// return view('EstructrasMetalicas.index');
    }
}
