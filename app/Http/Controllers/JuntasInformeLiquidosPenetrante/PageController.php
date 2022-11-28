<?php

namespace App\Http\Controllers\JuntasInformeLiquidosPenetrante;

use App\Http\Controllers\Controller;
use App\Models\JuntasInformeLiquidosPenetrante;
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
        $juntasInformeLiquidosPenetrantes = JuntasInformeLiquidosPenetrante::paginate();

        return view('juntas-informe-liquidos-penetrante.index', compact('juntasInformeLiquidosPenetrantes'))
            ->with('i', (request()->input('page', 1) - 1) * $juntasInformeLiquidosPenetrantes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $juntasInformeLiquidosPenetrante = new JuntasInformeLiquidosPenetrante();
        return view('juntas-informe-liquidos-penetrante.create', compact('juntasInformeLiquidosPenetrante'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(JuntasInformeLiquidosPenetrante::$rules);

        $juntasInformeLiquidosPenetrante = JuntasInformeLiquidosPenetrante::create($request->all());

        return redirect()->route('juntas-informe-liquidos-penetrantes.index')
            ->with('success', 'JuntasInformeLiquidosPenetrante created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juntasInformeLiquidosPenetrante = JuntasInformeLiquidosPenetrante::find($id);

        return view('juntas-informe-liquidos-penetrante.show', compact('juntasInformeLiquidosPenetrante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juntasInformeLiquidosPenetrante = JuntasInformeLiquidosPenetrante::find($id);

        return view('juntas-informe-liquidos-penetrante.edit', compact('juntasInformeLiquidosPenetrante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  JuntasInformeLiquidosPenetrante $juntasInformeLiquidosPenetrante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate(JuntasInformeLiquidosPenetrante::$rules);
        $data = JuntasInformeLiquidosPenetrante::find($id);
        $data->update($request->all());

       // return redirect()->route('juntas-informe-liquidos-penetrantes.index')
       return redirect()->back()
            ->with('success', 'JuntasInformeLiquidosPenetrante updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $juntasInformeLiquidosPenetrante = JuntasInformeLiquidosPenetrante::find($id)->delete();

        return redirect()->route('juntas-informe-liquidos-penetrantes.index')
            ->with('success', 'JuntasInformeLiquidosPenetrante deleted successfully');
    }

       ///Metodos api

       public function api_getByInfLiquidosPenetrantes(Request $request, $id)
       {
           $data = new JuntasInformeLiquidosPenetrante();
   
           $data = JuntasInformeLiquidosPenetrante::where('inf_liq_penetran_id', $id);
           if ($data) {
               $data = $data->get()->toJson(JSON_PRETTY_PRINT);
           }
   
           return response($data, 200);
       }
   
       public function api_getById(Request $request, $id)
       {
           $data = new JuntasInformeLiquidosPenetrante();
           $data = JuntasInformeLiquidosPenetrante::where('id', $id)->get()->first();
           if ($data) {
               $data =  $data->toJson(JSON_PRETTY_PRINT);
           }
           return response($data, 200);
       }
   
       public function api_add(Request $request)
       {
           $input = $request->all();
           $data = JuntasInformeLiquidosPenetrante::create($input);
   
           return response($data, 200);
       }
   
       public function api_update(Request $request)
       {
           $input = $request->all();
           $id = $input['id'];
           $data = JuntasInformeLiquidosPenetrante::find($id);
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
           $data = JuntasInformeLiquidosPenetrante::find($id);
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
