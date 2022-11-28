<?php

namespace App\Http\Controllers\DatosJuntasInformeUltrasonido;

use App\Http\Controllers\Controller;
use App\Models\DatosJuntasInformeUltrasonido;
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

       ///Metodos api

       public function api_getByJuntaId(Request $request, $id)
       {
           $data = new DatosJuntasInformeUltrasonido();
   
           $data = DatosJuntasInformeUltrasonido::where('jun_inf_ult_id', $id);
           if ($data) {
               $data = $data->get()->toJson(JSON_PRETTY_PRINT);
           }
   
           return response($data, 200);
       }
   
       public function api_getById(Request $request, $id)
       {
           $data = new DatosJuntasInformeUltrasonido();
           $data = DatosJuntasInformeUltrasonido::where('id', $id)->get()->first();
           if ($data) {
               $data =  $data->toJson(JSON_PRETTY_PRINT);
           }
           return response($data, 200);
       }
   
       public function api_add(Request $request)
       {
           $input = $request->all();
           $data = DatosJuntasInformeUltrasonido::create($input);
   
           return response($data, 200);
       }
   
       public function api_update(Request $request)
       {
           $input = $request->all();
           $id = $input['id'];
           $data = DatosJuntasInformeUltrasonido::find($id);
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
           $data = DatosJuntasInformeUltrasonido::find($id);
           if ($data) {
               $data = $data->delete();
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
