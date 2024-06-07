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


    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'Nombre_Asesor' => 'required',
            'correo_asesor' => 'required|email',
            // Otros campos que necesitas validar...
        ]);

        // Obtener el asesor por su ID
        $asesor = Asesores::findOrFail($id);

        // Actualizar los campos del asesor con los nuevos valores
        $asesor->update([
            'Nombre_Asesor' => $request->input('Nombre_Asesor'),
            'correo_asesor' => $request->input('correo_asesor'),
            // Otros campos que necesitas actualizar...
        ]);

        session()->flash('success','Registro actualizado con éxito');
    }
    public function consultaAsesoresApi()
    {
        // Obtén los nombres e IDs de los asesores
        $asesores = Asesores::select('id', 'Nombre_Asesor')->get();
        
        // Devuelve una respuesta JSON con los nombres e IDs de los asesores
        return response()->json($asesores, 200);
    }
    
    
}
