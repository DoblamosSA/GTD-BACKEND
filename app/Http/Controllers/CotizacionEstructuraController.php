<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CotizacionImport;
use App\Exports\CotizacionSeguimientoExport;
use App\Models\Cliente;
use App\Models\CotizacionEstructuras;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;

class CotizacionEstructuraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cotizacionEstructuras = CotizacionEstructuras::all();
        $clientes = Cliente::all();
        return view('Ingenieria.CotizacionesEstructura.index', compact('cotizacionEstructuras','clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cotizacionEstructuras = new CotizacionEstructuras();
     $clientes = Cliente::all();
        return view('Ingenieria.CotizacionesEstructura.create', compact('cotizacionEstructuras','clientes'));
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
            'clientes_id'=>'required'
          
        ]);

        $cotizacionEstructuras = new CotizacionEstructuras();
        $cotizacionEstructuras->Numero_Obra = $request->Numero_Obra;
        $cotizacionEstructuras->Nombre_Obra = $request->Nombre_Obra;
        $cotizacionEstructuras->Lugar_Obra = $request->Lugar_Obra;
        $cotizacionEstructuras->Fecha_Recibido = $request->Fecha_Recibido;
        $cotizacionEstructuras->Fecha_Cotizada = $request->Fecha_Cotizada;
        $cotizacionEstructuras->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $cotizacionEstructuras->Valor_Adjudicado = $request->Valor_Adjudicado;
        $cotizacionEstructuras->Tipologia = $request->Tipologia;
        $cotizacionEstructuras->Estado = $request->Estado;
        $cotizacionEstructuras->clientes_id = $request->clientes_id;
        $cotizacionEstructuras->save();
        return redirect()->route('cotizacion.index')
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
        $cotizacionEstructuras = CotizacionEstructuras::findOrFail($id);
        $clientes = Cliente::all();
        return view('Ingenieria.CotizacionesEstructura.edit', compact('cotizacionEstructuras','clientes'));
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
        $cotizacionEstructuras = CotizacionEstructuras::findOrFail($id);
        $cotizacionEstructuras->Numero_Obra = $request->Numero_Obra;
        $cotizacionEstructuras->Nombre_Obra = $request->Nombre_Obra;
        $cotizacionEstructuras->Lugar_Obra = $request->Lugar_Obra;
        $cotizacionEstructuras->Fecha_Recibido = $request->Fecha_Recibido;
        $cotizacionEstructuras->Fecha_Cotizada = $request->Fecha_Cotizada;
        $cotizacionEstructuras->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $cotizacionEstructuras->Valor_Adjudicado = $request->Valor_Adjudicado;
        $cotizacionEstructuras->Tipologia = $request->Tipologia;
        $cotizacionEstructuras->Estado = $request->Estado;

        $cotizacionEstructuras->save();

        
        return redirect()->route('cotizacion.index')
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
        $cotizacionEstructuras = CotizacionEstructuras::find($id)->delete();

        return redirect()->route('cotizacion.index')
            ->with('eliminar', 'ok');
    }




    public function exportExcel()
    {
        return Excel::download(new CotizacionSeguimientoExport, 'seguimientocotizaciones.xlsx');
    }


    public function import()
    {
        return view('Ingenieria.CotizacionesEstructura.import');
    }



    public function importStore(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        
        $file = $request->file('file')->getRealPath();

        Excel::import(new CotizacionImport, $file);
        //    return  Excel::toCollection(new  CotizacionImport, $file );

        return 'exitoso';
    }


}