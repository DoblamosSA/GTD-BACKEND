<?php

namespace App\Http\Controllers;

use App\Models\DatosJuntasInformeUltrasonido;
use Illuminate\Http\Request;

/**
 * Class DatosJuntasInformeUltrasonidoController
 * @package App\Http\Controllers
 */
class DatosJuntasInformeUltrasonidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datosJuntasInformeUltrasonidos = DatosJuntasInformeUltrasonido::paginate();

        return view('datos-juntas-informe-ultrasonido.index', compact('datosJuntasInformeUltrasonidos'))
            ->with('i', (request()->input('page', 1) - 1) * $datosJuntasInformeUltrasonidos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datosJuntasInformeUltrasonido = new DatosJuntasInformeUltrasonido();
        return view('datos-juntas-informe-ultrasonido.create', compact('datosJuntasInformeUltrasonido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(DatosJuntasInformeUltrasonido::$rules);

        $datosJuntasInformeUltrasonido = DatosJuntasInformeUltrasonido::create($request->all());

        return redirect()->route('datos-juntas-informe-ultrasonidos.index')
            ->with('success', 'DatosJuntasInformeUltrasonido created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datosJuntasInformeUltrasonido = DatosJuntasInformeUltrasonido::find($id);

        return view('datos-juntas-informe-ultrasonido.show', compact('datosJuntasInformeUltrasonido'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datosJuntasInformeUltrasonido = DatosJuntasInformeUltrasonido::find($id);

        return view('datos-juntas-informe-ultrasonido.edit', compact('datosJuntasInformeUltrasonido'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  DatosJuntasInformeUltrasonido $datosJuntasInformeUltrasonido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DatosJuntasInformeUltrasonido $datosJuntasInformeUltrasonido)
    {
        request()->validate(DatosJuntasInformeUltrasonido::$rules);

        $datosJuntasInformeUltrasonido->update($request->all());

        return redirect()->route('datos-juntas-informe-ultrasonidos.index')
            ->with('success', 'DatosJuntasInformeUltrasonido updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $datosJuntasInformeUltrasonido = DatosJuntasInformeUltrasonido::find($id)->delete();

        return redirect()->route('datos-juntas-informe-ultrasonidos.index')
            ->with('success', 'DatosJuntasInformeUltrasonido deleted successfully');
    }
}
