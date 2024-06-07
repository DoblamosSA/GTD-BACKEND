<?php

namespace App\Http\Controllers\CNC;

use App\Http\Controllers\Controller;
use App\Models\CostoNocalidad;
use App\Models\EmpledoSAP;
use App\Exports\CostoNoCalidadExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Dompdf\Dompdf;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;

class CostosnocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quiencostea = $request->QuienCostea;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $costonocalidad = CostoNocalidad::with('empleado', 'analista');

        // Agregar la condición para QuienCostea si está presente
        if ($quiencostea) {
            $costonocalidad = $costonocalidad->where('QuienCostea', $quiencostea);
        }

        // Verificar si se ha enviado el formulario de búsqueda
        if ($request->has('start_date') && $request->has('end_date')) {
            if ($start_date && $end_date) {
                $costonocalidad = $costonocalidad->whereBetween('FechaCNC', [$start_date, $end_date]);
            }

            // Realizar la búsqueda y obtener los resultados
              $costonocalidad = $costonocalidad->get();
        } else {
            // Si no se ha enviado el formulario, no realizar la búsqueda y obtener una colección vacía
            $costonocalidad = collect();
        }

        return view('CNC.index', compact('costonocalidad', 'quiencostea', 'start_date', 'end_date'));
    }




    // CostoNocalidadController.php

    // public function search(Request $request)
    // {
    //     $quiencostea = $request->QuienCostea;
    //     $start_date = $request->start_date;
    //     $end_date = $request->end_date;

    //     $costonocalidad = CostoNocalidad::with('empleado', 'analista');

    //     if ($start_date && $end_date) {
    //         $costonocalidad = $costonocalidad->whereBetween('FechaCNC', [$start_date, $end_date]);
    //     }
    //     $costonocalidad = $costonocalidad->where('QuienCostea', $quiencostea)->where('EstadoCNC', 'No costeado')->get();

    //     return response()->json(['costonocalidad' => $costonocalidad]);
    // }



    // public function searchcosteado(Request $request)
    // {
    //     $quiencostea = $request->QuienCostea;
    //     $start_date = $request->start_date;
    //     $end_date = $request->end_date;

    //     $costonocalidad = CostoNocalidad::with('empleado', 'analista');

    //     if ($start_date && $end_date) {
    //         $costonocalidad = $costonocalidad->whereBetween('FechaCNC', [$start_date, $end_date]);
    //     }
    //     $costonocalidad = $costonocalidad->where('QuienCostea', $quiencostea)->where('EstadoCNC', 'Costeado')->get();

    //     return response()->json(['costonocalidad' => $costonocalidad]);
    // }


    public function cnccosteados(Request $request)
    {
        $quiencostea = $request->QuienCostea;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $costonocalidad = CostoNocalidad::with('empleado', 'analista');

        // Agregar la condición para QuienCostea si está presente
        if ($quiencostea) {
            $costonocalidad = $costonocalidad->where('QuienCostea', $quiencostea);
        }

        // Verificar si se ha enviado el formulario de búsqueda
        if ($request->has('start_date') && $request->has('end_date')) {
            if ($start_date && $end_date) {
                $costonocalidad = $costonocalidad->whereBetween('FechaCNC', [$start_date, $end_date]);
            }

            // Realizar la búsqueda y obtener los resultados
            $costonocalidad = $costonocalidad->where('EstadoCNC', 'Costeado')->get();
        } else {
            // Si no se ha enviado el formulario, no realizar la búsqueda y obtener una colección vacía
            $costonocalidad = collect();
        }

        return view('CNC.cnccosteados', compact('costonocalidad', 'quiencostea', 'start_date', 'end_date'));
    }




    public function create()
    {

        $empleadosSAP = EmpledoSAP::all();
        return view('CNC.create', compact('empleadosSAP'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sede' => 'required',
            'FechaCNC' => 'required',
            'Descripcion' => 'required',
            'Ccop' => 'required',
            'AreaResponsableCNC' => 'required',
            'IdResponsablecnc' => 'required|numeric',
            'IdAnalistaReporto' => 'required|numeric'
        ], [
            'sede.required' => 'Por favor ingresar la sede',
            'FechaCNC.required' => 'Fecha CNC vacia',
            'Descripcion.required' => 'Por favor ingrese la descripción del evento',
            'Ccop.required' => 'CC/OP vacio',
            'AreaResponsableCNC.required' => 'Seleccionar un area responsable del CNC',

        ]);

        $data = $request->all();
        CostoNocalidad::create($data);
        return redirect()->route('Costo-No-Calidad.index')->withErrors($validatedData);
    }

    public function duplicate($id)
    {
        $costonocalidad = CostoNocalidad::find($id);
        $duplicate = $costonocalidad->replicate();
        $duplicate->save();
        return redirect()->route('Costo-No-Calidad.index')
            ->with(['duplicar' => 'ok', 'duplicateId' => $duplicate->id]);
    }

    public function edit(request $request, $id)
    {


        $costonocalidad = CostoNocalidad::findOrFail($id);
        $empleadosSAP = EmpledoSAP::all();
        return view('CNC.edit', compact('costonocalidad', 'empleadosSAP'));
    }

    public function update(request $request, $id)
    {
        $costonocalidad = CostoNocalidad::findOrFail($id);
        $costonocalidad->update($request->all());
        return redirect()->route('Costo-No-Calidad.index')->with('Actualizar', 'Costo de no calidad actualizado con Éxito');
    }


    public function destroy($id)
    {

        $costonocalidad = CostoNocalidad::find($id)->delete();

        return redirect()->route('Costo-No-Calidad.index')
            ->with('eliminar', 'ok');
    }

    public function exportcnc()
    {
        return Excel::download(new CostoNoCalidadExport, 'Costo-No-Calidad.xlsx');
    }


    public function Informecnc(request $request, $id)
    {

        $costonocalidad = CostoNocalidad::find($id);

        $pdf = PDF::loadView('CNC.informe', ['costonocalidad' => $costonocalidad]);

        return $pdf->stream();
    }

    public function Indicadores(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $datos = DB::table('costo_nocalidads')
            ->select(DB::raw('AreaResponsableCNC, SUM(CostoCNC - COALESCE(SaldoRecuperado, 0)) as SaldoFinalCNC, count(AreaResponsableCNC) as TotalRegistros'))
            ->whereBetween('FechaCNC', [$fecha_inicio,  $fecha_fin])
            ->groupBy('AreaResponsableCNC')
            ->get();

        $cantidadCNC = DB::table('costo_nocalidads')
            ->select(DB::raw('AreaResponsableCNC, count(*) as cantidad'))
            ->whereBetween('FechaCNC', [$fecha_inicio,  $fecha_fin])
            ->groupBy('AreaResponsableCNC')
            ->get();


        $costosPendientes = DB::table('costo_nocalidads')
            ->select(DB::raw('AreaResponsableCNC, count(*) as count'))
            ->where('EstadoCNC', 'No Costeado')
            ->whereBetween('FechaCNC', [$fecha_inicio,  $fecha_fin])
            ->groupBy('AreaResponsableCNC')
            ->get();



        return view('CNC.Indicadores', compact('datos', 'cantidadCNC', 'costosPendientes'));
    }







    // public function IndicadoresSaldoRecuperadoMes(){
    //     $recuperadoPorArea = DB::table('costo_nocalidads')
    //     ->select(DB::raw('AreaResponsableCNC, sum(SaldoRecuperado) as recuperado'))
    //     ->groupBy('AreaResponsableCNC')
    //     ->get();
    //     $labels = $recuperadoPorArea->pluck('AreaResponsableCNC')->toArray();
    //     $recuperados = $recuperadoPorArea->pluck('recuperado')->toArray();

    //     return view('CNC.Indicadores', [
    //         'labels' => $labels,
    //         'recuperados' => $recuperados
    //     ]);
    // }




}
