<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Vorte;
use Illuminate\View\ViewServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeguimientosVortexExport;

class VorteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        $vorte = Vorte::all();
        return view('vortexDoblamos.index',compact('vorte'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('vortexDoblamos.create');
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

        $vorte = new Vorte();
        $vorte->Numero_Obra = $request->Numero_Obra;
        $vorte->Empresa_Cliente = $request->Empresa_Cliente;
        $vorte->Fecha_Recibido = $request->Fecha_Recibido;
        $vorte->Nombre_Obra = $request->Nombre_Obra;
        $vorte->Descripcion = $request->Descripcion;
        $vorte->Estado = $request->Estado;
        $vorte->Fecha_Cotizada = $request->Fecha_Cotizada;
        $vorte->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $vorte->Contacto = $request->Contacto;
        $vorte->AreaM2 = $request->AreaM2;
        $vorte->m2 = $request->m2;
        $vorte->Incluye_Montaje = $request->Incluye_Montaje;
        
        $vorte->save();
        return redirect()->route('vortexDoblamos.index');
    
       
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
        $vorte = Vorte::findOrFail($id);
        
        return view('vortexDoblamos.edit', compact('vorte'));
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
        $vorte=Vorte::findOrFail($id);
        $vorte->Numero_Obra = $request->Numero_Obra;
        $vorte->Empresa_Cliente = $request->Empresa_Cliente;
        $vorte->Fecha_Recibido = $request->Fecha_Recibido;
        $vorte->Nombre_Obra = $request->Nombre_Obra;
        $vorte->Descripcion = $request->Descripcion;
        $vorte->Estado = $request->Estado;
        $vorte->Fecha_Cotizada = $request->Fecha_Cotizada;
        $vorte->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $vorte->Contacto = $request->Contacto;
        $vorte->AreaM2 = $request->AreaM2;
        $vorte->m2 = $request->m2;
        $vorte->Incluye_Montaje = $request->Incluye_Montaje;
        
        
        $vorte->save();
        return redirect()->route('vortexDoblamos.index')
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
        $vorte = Vorte::find($id)->delete();

        return redirect()->route('vortexDoblamos.index')
            ->with('eliminar', 'ok');
    }


    
    public function exportExcelvortex()
    {
        return Excel::download(new SeguimientosVortexExport, 'seguimientocotizacionesvortex.xlsx');
    }
}
