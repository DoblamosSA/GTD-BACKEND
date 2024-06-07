<?php

namespace App\Http\Controllers\Asesores;

use App\Http\Controllers\Controller;
use App\Models\Asesores;
use COM;
use Exception;
use Illuminate\Http\Request;

class Asesorcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Asesor = Asesores::paginate(15);
        return view('Asesores.index',compact('Asesor'));
    }

   
    public function store(Request $request)
    {
     
        try{
            $Asesor = new Asesores();
            $Asesor->Nombre_Asesor = $request->Nombre_Asesor;
            $Asesor->correo_asesor = $request->correo_asesor;
            $Asesor->save();
            session()->flash('success','Asesor registrado correctamente!');
        }catch(Exception $error){
            session()->flash('error','No se pudo registrar el asesor!'.$error->getMessage());
        }

        return redirect()->back();
       
    }


    public function destroy($id){


        $Asesor = Asesores::find($id);
        if($Asesor){
            $Asesor->delete();
            session()->flash('success','Registro eliminado con éxito');
        }else{
            session()->flash('error','No se pudo eliminar el registro');
        }
        return redirect()->back();
    }


    public function edit(request $request, $id){


    }
}
