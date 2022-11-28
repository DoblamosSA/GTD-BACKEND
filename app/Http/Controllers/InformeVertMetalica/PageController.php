<?php

namespace App\Http\Controllers\InformeVertMetalica;

use App\Http\Controllers\Controller;
use App\Models\InformeVertMetalica;
use App\Models\Utilidades;
use Exception;
use Illuminate\Http\Request;

class PageController extends Controller
{
          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $informeVertMetalicas = InformeVertMetalica::paginate();

        return view('informe-vert-metalica.index', compact('informeVertMetalicas'))
            ->with('i', (request()->input('page', 1) - 1) * $informeVertMetalicas->perPage());
    }

    public function index(Request $request)
        {
            $busqueda = $request->busqueda;
            $informeVertMetalicas =  InformeVertMetalica::where('proyecto','LIKE','%'.$busqueda.'%')
            ->orWhere('created_at','LIKE','%'.$busqueda.'%')
            ->latest('id')->
            paginate(10);
            $data=[
                'informeVertMetalicas'=>$informeVertMetalicas,
            ];
            return view('informe-vert-metalica.index',$data);
    //     $fecha_inicio = $request->get('fecha_inicio');
    //     $fecha_final = $request->get('fecha_final');
    //     $informeVertMetalicas = [];

    //     try {
    //         $informeVertMetalicas = InformeVertMetalica::whereBetween('fecha_verificacion', [
    //                 (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_inicio),
    //                 (new Utilidades())->convertirFechaFormatoBaseDatos($fecha_final),
                  
                   
    //             ])
    //             ->get();
    //     } catch (Exception $ex) {
    //     }

    //     $data = [
    //         'informeVertMetalicas'  => $informeVertMetalicas,
    //         'fecha_inicio'  => $fecha_inicio,
    //         'fecha_final'  => $fecha_final,
           
    //     ];

    //     return view('informe-vert-metalica.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $informeVertMetalica = new InformeVertMetalica();
        return view('informe-vert-metalica.create', compact('informeVertMetalica'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(InformeVertMetalica::$rules);

        $informeVertMetalica = InformeVertMetalica::create($request->all());

        return redirect('informe-vert-metalica/edit/' . $informeVertMetalica->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        // $dato=\App\MenusOpciones\MenusOpciones::$sitioInspeccion;

        // MenusOpciones

        $informeVertMetalica = InformeVertMetalica::find($id);

        return view('informe-vert-metalica.show', compact('informeVertMetalica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $informeVertMetalica = InformeVertMetalica::find($id);

        return view('informe-vert-metalica.edit', compact('informeVertMetalica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  informeVertMetalica $informeVertMetalica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        request()->validate(InformeVertMetalica::$rules);
        $data = InformeVertMetalica::find($id);
        $data->update($request->all());

       // return redirect()->route('informe-vert-metalica.index')
       return redirect()->back()
            ->with('success', 'informeVertMetalica updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $informeVertMetalica = InformeVertMetalica::find($id)->delete();

        return redirect()->route('informe-vert-metalica.index')
            ->with('success', 'informeVertMetalica deleted successfully');
    }
}