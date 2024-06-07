<?php

namespace App\Http\Controllers\Calibres;

use App\Http\Controllers\Controller;
use App\Models\Calibre\Calibre;
use Exception;
use Illuminate\Http\Request;

class CalibresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $calibres = Calibre::all();
       
        return view('Calibres.index',compact('calibres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Calibre' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ], [
            'Calibre.numeric' => 'El campo Calibre debe ser numérico.'
        ]);
        
        
        
            try {
                $calibre = new Calibre;
                $calibre->Calibre = $validatedData['Calibre'];
                $calibre->save();
                return redirect()->route('Calibres.index')->with('success', 'Calibre registrado!');
            } catch(\Exception $e) {
                return redirect()->route('Calibres.index')->with('error', 'Error al registrar el calibre: '.$e->getMessage());
            }
       
        
    }


    public function destroy($id){

        $calibres = Calibre::find($id);
        if($calibres){
            $calibres->delete();
            return redirect()->route('Calibres.index')
             ->with('eliminar', 'ok');
        }else{
            session()->flash('error','No se pudo eliminar el registro');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $calibre = Calibre::find($id);
        $calibre->Calibre = $request->input('Calibre');
        $calibre->save();
    
        return redirect()->route('Calibres.index');
    }
    

  
}