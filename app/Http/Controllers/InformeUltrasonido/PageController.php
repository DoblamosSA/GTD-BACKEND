<?php

namespace App\Http\Controllers\InformeUltrasonido;

use App\Http\Controllers\Controller;
use App\Models\InformeUltrasonido;
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
    public function index(Request $request)
    {
        // $informeUltrasonidos = InformeUltrasonido::paginate();
        $busqueda = $request->busqueda;
        $informeUltrasonidos =  InformeUltrasonido::where('proyecto','LIKE','%'.$busqueda.'%')
        ->orWhere('created_at','LIKE','%'.$busqueda.'%')
        ->latest('id')->
        paginate(10);
        $data=[
            'informeUltrasonidos'=>$informeUltrasonidos,
        ];
        return view('informe-ultrasonido.index',$data);
       

        // return view('informe-ultrasonido.index', compact('informeUltrasonidos'))
        //     ->with('i', (request()->input('page', 1) - 1) * $informeUltrasonidos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $informeUltrasonido = new InformeUltrasonido();
        return view('informe-ultrasonido.create', compact('informeUltrasonido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(InformeUltrasonido::$rules);

        $informeUltrasonido = InformeUltrasonido::create($request->all());

        return redirect('informe-ultrasonido/edit/' . $informeUltrasonido->id);
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

        $informeUltrasonido = InformeUltrasonido::find($id);

        return view('informe-ultrasonido.show', compact('informeUltrasonido'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $informeUltrasonido = InformeUltrasonido::find($id);

        return view('informe-ultrasonido.edit', compact('informeUltrasonido'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  informeUltrasonido $informeUltrasonido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        request()->validate(InformeUltrasonido::$rules);
        $data = InformeUltrasonido::find($id);
        $data->update($request->all());

       // return redirect()->route('informe-ultrasonido.index')
       return redirect()->back()
            ->with('success', 'informeUltrasonido updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $informeUltrasonido = InformeUltrasonido::find($id)->delete();

        return redirect()->route('informe-ultrasonido.index')
            ->with('success', 'informeUltrasonido deleted successfully');
    }
}
