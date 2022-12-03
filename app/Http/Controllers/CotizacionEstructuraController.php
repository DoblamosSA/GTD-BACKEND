<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CotizacionImport;
use App\Exports\CotizacionSeguimientoExport;
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
        return view('Ingenieria.CotizacionesEstructura.index', compact('cotizacionEstructuras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cotizacionEstructuras = new CotizacionEstructuras();
        return view('Ingenieria.CotizacionesEstructura.create', compact('cotizacionEstructuras'));
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
            'Contacto' => 'required',
            'AreaM2' => 'required | numeric',
            'm2' => 'required | numeric',
            'Incluye_Montaje' => 'required',

        ]);

        $cotizacionEstructuras = new CotizacionEstructuras();
        $cotizacionEstructuras->Numero_Obra = $request->Numero_Obra;
        $cotizacionEstructuras->Empresa_Cliente = $request->Empresa_Cliente;
        $cotizacionEstructuras->Fecha_Recibido = $request->Fecha_Recibido;
        $cotizacionEstructuras->Nombre_Obra = $request->Nombre_Obra;
        $cotizacionEstructuras->Descripcion = $request->Descripcion;
        $cotizacionEstructuras->Estado = $request->Estado;
        $cotizacionEstructuras->Fecha_Cotizada = $request->Fecha_Cotizada;
        $cotizacionEstructuras->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $cotizacionEstructuras->Contacto = $request->Contacto;
        $cotizacionEstructuras->AreaM2 = $request->AreaM2;
        $cotizacionEstructuras->m2 = $request->m2;
        $cotizacionEstructuras->Incluye_Montaje = $request->Incluye_Montaje;

        $cotizacionEstructuras->save();
        return redirect()->route('cotizacion.index');


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

        return view('Ingenieria.CotizacionesEstructura.edit', compact('cotizacionEstructuras'));
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
        $cotizacionEstructuras->Empresa_Cliente = $request->Empresa_Cliente;
        $cotizacionEstructuras->Fecha_Recibido = $request->Fecha_Recibido;
        $cotizacionEstructuras->Nombre_Obra = $request->Nombre_Obra;
        $cotizacionEstructuras->Descripcion = $request->Descripcion;
        $cotizacionEstructuras->Estado = $request->Estado;
        $cotizacionEstructuras->Fecha_Cotizada = $request->Fecha_Cotizada;
        $cotizacionEstructuras->Valor_Antes_Iva = $request->Valor_Antes_Iva;
        $cotizacionEstructuras->Contacto = $request->Contacto;
        $cotizacionEstructuras->AreaM2 = $request->AreaM2;
        $cotizacionEstructuras->m2 = $request->m2;
        $cotizacionEstructuras->Incluye_Montaje = $request->Incluye_Montaje;


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