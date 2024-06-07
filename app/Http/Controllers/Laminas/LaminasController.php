<?php

namespace App\Http\Controllers\Laminas;

use App\Http\Controllers\Controller;
use App\Models\Calibre\Calibre;
use App\Models\Lamina\Lamina;
use Exception;
use Illuminate\Http\Request;

class LaminasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laminas = Lamina::with('calibres')->get();

        return view('laminas.index',compact('laminas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $calibres = Calibre::all();
        return view('laminas.create',compact('calibres'));
    }

    public function store(Request $request)
{
    $lamina = new Lamina();
    $lamina->codigo = $request->input('codigo');
    $lamina->descripcion = $request->input('descripcion');
    $lamina->save();
    
    $calibres = $request->input('calibres');
    $precios = $request->input('precios');
    
    foreach ($calibres as $key => $calibre_id) {
        $precio = $precios[$key];
        $lamina->calibres()->attach($calibre_id, ['precio' => $precio]);
    }
    
    return redirect()->route('Laminas.index');
}

    public function edit($id)
    {
        $lamina = Lamina::findOrFail($id);
        $calibres = Calibre::all();
        return view('laminas.edit', compact('lamina', 'calibres'));
    }
    

    public function update(Request $request, $id)
    {
        $lamina = Lamina::find($id);
        $lamina->codigo = $request->input('codigo');
        $lamina->descripcion = $request->input('descripcion');
        $lamina->save();
    
        $calibres = $request->input('calibres');
        $precios = $request->input('precios');
    
        foreach ($calibres as $index => $calibre_id) {
            $precio = $precios[$index];
            $lamina->calibres()->updateExistingPivot($calibre_id, ['precio' => $precio]);
        }
    
        return redirect()->route('Laminas.index')->with('success', 'Lámina actualizada correctamente.');
    }

    
    public function destroy($id){
        $lamina = Lamina::find($id);
        if($lamina){
            $lamina->delete();
            return redirect()->route('Laminas.index')->with('eliminar','ok');
        }else{
            session()->flash('error','No se pudo eliminar el registro');
        }
        return redirect()->back();
    }
     
    
}

    