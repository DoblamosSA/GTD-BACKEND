<?php

namespace App\Http\Controllers\JuntasInformeUltrasonido;

use App\Http\Controllers\Controller;
use App\Models\JuntasInformeUltrasonido;
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
        $juntasInformeUltrasonido = JuntasInformeUltrasonido::paginate();

        return view('juntas-informe-ultrasonido.index', compact('juntasInformeUltrasonido'))
            ->with('i', (request()->input('page', 1) - 1) * $juntasInformeUltrasonido->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $juntasInformeUltrasonido = new JuntasInformeUltrasonido();
        return view('juntas-informe-ultrasonido.create', compact('juntasInformeUltrasonido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(JuntasInformeUltrasonido::$rules);

        $juntasInformeUltrasonido = JuntasInformeUltrasonido::create($request->all());

        return redirect()->route('juntas-informe-ultrasonido.index')
            ->with('success', 'juntasInformeUltrasonido created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juntasInformeUltrasonido = JuntasInformeUltrasonido::find($id);

        return view('juntas-informe-ultrasonido.show', compact('juntasInformeUltrasonido'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juntasInformeUltrasonido = JuntasInformeUltrasonido::find($id);

        return view('juntas-informe-ultrasonido.edit', compact('juntasInformeUltrasonido'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  JuntasInformeUltrasonido $juntasInformeUltrasonido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JuntasInformeUltrasonido $juntasInformeUltrasonido)
    {
        request()->validate(JuntasInformeUltrasonido::$rules);

        $juntasInformeUltrasonido->update($request->all());

        return redirect()->route('juntas-informe-ultrasonido.index')
            ->with('success', 'juntasInformeUltrasonido updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $juntasInformeUltrasonido = JuntasInformeUltrasonido::find($id)->delete();

        return redirect()->route('juntas-informe-ultrasonido.index')
            ->with('success', 'juntasInformeUltrasonido deleted successfully');
    }

    ///Metodos api

    public function api_getByInformeId(Request $request, $id)
    {
        $data = new JuntasInformeUltrasonido();

        $data = JuntasInformeUltrasonido::where('inf_ultrasonido_id', $id);
        if ($data) {
            $data = $data->get()->toJson(JSON_PRETTY_PRINT);
        }

        return response($data, 200);
    }

    public function api_getById(Request $request, $id)
    {
        $data = new JuntasInformeUltrasonido();
        $data = JuntasInformeUltrasonido::where('id', $id)->get()->first();
        if ($data) {
            $data =  $data->toJson(JSON_PRETTY_PRINT);
        }
        return response($data, 200);
    }

    public function api_add(Request $request)
    {
        $input = $request->all();
        $data = JuntasInformeUltrasonido::create($input);

        return response($data, 200);
    }

    public function api_update(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $data = JuntasInformeUltrasonido::find($id);
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
        $data = JuntasInformeUltrasonido::find($id);
        if ($data) {
            $juntasInformeUltrasonido = $data->delete();
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
