<?php

namespace App\Http\Controllers;

use App\Models\JuntasPartesMagneticasImagene;
use Illuminate\Http\Request;

/**
 * Class JuntasPartesMagneticasImageneController
 * @package App\Http\Controllers
 */
class JuntasPartesMagneticasImageneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juntasPartesMagneticasImagenes = JuntasPartesMagneticasImagene::paginate();

        return view('juntas-partes-magneticas-imagene.index', compact('juntasPartesMagneticasImagenes'))
            ->with('i', (request()->input('page', 1) - 1) * $juntasPartesMagneticasImagenes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $juntasPartesMagneticasImagene = new JuntasPartesMagneticasImagene();
        return view('juntas-partes-magneticas-imagene.create', compact('juntasPartesMagneticasImagene'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(JuntasPartesMagneticasImagene::$rules);

        $juntasPartesMagneticasImagene = JuntasPartesMagneticasImagene::create($request->all());

        return redirect()->route('juntas-partes-magneticas-imagenes.index')
            ->with('success', 'JuntasPartesMagneticasImagene created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juntasPartesMagneticasImagene = JuntasPartesMagneticasImagene::find($id);

        return view('juntas-partes-magneticas-imagene.show', compact('juntasPartesMagneticasImagene'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juntasPartesMagneticasImagene = JuntasPartesMagneticasImagene::find($id);

        return view('juntas-partes-magneticas-imagene.edit', compact('juntasPartesMagneticasImagene'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  JuntasPartesMagneticasImagene $juntasPartesMagneticasImagene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JuntasPartesMagneticasImagene $juntasPartesMagneticasImagene)
    {
        request()->validate(JuntasPartesMagneticasImagene::$rules);

        $juntasPartesMagneticasImagene->update($request->all());

        return redirect()->route('juntas-partes-magneticas-imagenes.index')
            ->with('success', 'JuntasPartesMagneticasImagene updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $juntasPartesMagneticasImagene = JuntasPartesMagneticasImagene::find($id)->delete();

        return redirect()->route('juntas-partes-magneticas-imagenes.index')
            ->with('success', 'JuntasPartesMagneticasImagene deleted successfully');
    }
}
