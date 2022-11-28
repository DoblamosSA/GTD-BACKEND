<?php

namespace App\Http\Controllers\JuntasInformePartesMagneticas;

use App\Http\Controllers\Controller;
use App\Models\JuntasInformePartesMagneticas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juntasInformePartesMagneticas = JuntasInformePartesMagneticas::paginate();

        return view('juntas-informe-partes-magneticas.index', compact('juntasInformePartesMagneticas'))
            ->with('i', (request()->input('page', 1) - 1) * $juntasInformePartesMagneticas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $juntasInformePartesMagnetica = new JuntasInformePartesMagneticas();
        return view('juntas-informe-partes-magneticas.create', compact('juntasInformePartesMagnetica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(JuntasInformePartesMagneticas::$rules);

        $juntasInformePartesMagnetica = JuntasInformePartesMagneticas::create($request->all());

        return redirect()->route('juntas-informe-partes-magneticass.index')
            ->with('success', 'JuntasInformePartesMagnetica created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juntasInformePartesMagnetica = JuntasInformePartesMagneticas::find($id);

        return view('juntas-informe-partes-magneticas.show', compact('juntasInformePartesMagnetica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juntasInformePartesMagnetica = JuntasInformePartesMagneticas::find($id);

        return view('juntas-informe-partes-magneticas.edit', compact('juntasInformePartesMagnetica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  JuntasInformePartesMagnetica $juntasInformePartesMagnetica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JuntasInformePartesMagneticas $juntasInformePartesMagnetica)
    {
        request()->validate(JuntasInformePartesMagneticas::$rules);

        $juntasInformePartesMagnetica->update($request->all());

        return redirect()->route('juntas-informe-partes-magneticass.index')
            ->with('success', 'JuntasInformePartesMagnetica updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $juntasInformePartesMagnetica = JuntasInformePartesMagneticas::find($id)->delete();

        return redirect()->route('juntas-informe-partes-magneticass.index')
            ->with('success', 'JuntasInformePartesMagnetica deleted successfully');
    }

    ///Metodos api

    public function api_getByInfParticulaMagnetica(Request $request, $id)
    {
        $data = new JuntasInformePartesMagneticas();

        $data = JuntasInformePartesMagneticas::where('inf_part_magneticas_id', $id);
        if ($data) {
            $data = $data->get()->toJson(JSON_PRETTY_PRINT);
        }

        return response($data, 200);
    }

    public function api_getById(Request $request, $id)
    {
        $data = new JuntasInformePartesMagneticas();
        $data = JuntasInformePartesMagneticas::where('id', $id)->get()->first();
        if ($data) {
            $data =  $data->toJson(JSON_PRETTY_PRINT);
        }
        return response($data, 200);
    }

    public function api_add(Request $request)
    {
        $input = $request->all();
        $data = JuntasInformePartesMagneticas::create($input);

        return response($data, 200);
    }

    public function api_update(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $data = JuntasInformePartesMagneticas::find($id);
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
        $data = JuntasInformePartesMagneticas::find($id);
        if ($data) {
            $juntasInformePartesMagnetica = $data->delete();
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
