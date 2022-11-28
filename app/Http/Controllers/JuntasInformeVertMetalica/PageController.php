<?php

namespace App\Http\Controllers\JuntasInformeVertMetalica;

use App\Http\Controllers\Controller;
use App\Models\JuntasInformeVertMetalica;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juntasInformeVertMetalica = JuntasInformeVertMetalica::paginate();

        return view('juntas-informe-vert-metalica.index', compact('juntasInformeVertMetalica'))
            ->with('i', (request()->input('page', 1) - 1) * $juntasInformeVertMetalica->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $juntasInformeVertMetalica = new JuntasInformeVertMetalica();
        return view('juntas-informe-vert-metalica.create', compact('juntasInformeVertMetalica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(JuntasInformeVertMetalica::$rules);

        $juntasInformeVertMetalica = JuntasInformeVertMetalica::create($request->all());

        return redirect()->route('juntas-informe-vert-metalica.index')
            ->with('success', 'juntasInformeVertMetalica created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juntasInformeVertMetalica = JuntasInformeVertMetalica::find($id);

        return view('juntas-informe-vert-metalica.show', compact('juntasInformeVertMetalica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juntasInformeVertMetalica = JuntasInformeVertMetalica::find($id);

        return view('juntas-informe-vert-metalica.edit', compact('juntasInformeVertMetalica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  JuntasInformeVertMetalica $juntasInformeVertMetalica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JuntasInformeVertMetalica $juntasInformeVertMetalica)
    {
        request()->validate(JuntasInformeVertMetalica::$rules);

        $juntasInformeVertMetalica->update($request->all());

        return redirect()->route('juntas-informe-vert-metalica.index')
            ->with('success', 'juntasInformeVertMetalica updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $juntasInformeVertMetalica = JuntasInformeVertMetalica::find($id)->delete();

        return redirect()->route('juntas-informe-vert-metalica.index')
            ->with('success', 'juntasInformeVertMetalica deleted successfully');
    }

    ///Metodos api

    public function api_getByInfVertMetalica(Request $request, $id)
    {
        $data = new JuntasInformeVertMetalica();

        $data = JuntasInformeVertMetalica::where('inf_vert_met_id', $id);
        if ($data) {
            $data = $data->get()->toJson(JSON_PRETTY_PRINT);
        }

        return response($data, 200);
    }

    public function api_getById(Request $request, $id)
    {
        $data = new JuntasInformeVertMetalica();
        $data = JuntasInformeVertMetalica::where('id', $id)->get()->first();
        if ($data) {
            $data =  $data->toJson(JSON_PRETTY_PRINT);
        }
        return response($data, 200);
    }

    public function api_add(Request $request)
    {
        $input = $request->all();
        $data = JuntasInformeVertMetalica::create($input);

        return response($data, 200);
    }

    public function api_update(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $data = JuntasInformeVertMetalica::find($id);
        if ($data) {
            $data->update($request->all());
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }

        return response($data, 200);
    }

    public function api_delete($id)
    {
        $data = JuntasInformeVertMetalica::find($id);
        if ($data) {
            $juntasInformeVertMetalica = $data->delete();
            return response()->json([
                "message" => "Data deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }
}
