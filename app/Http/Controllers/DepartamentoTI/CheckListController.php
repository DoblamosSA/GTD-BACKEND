<?php

namespace App\Http\Controllers\DepartamentoTI;

use App\Http\Controllers\Controller;
use App\Models\CheckList;
use App\Models\TareasPendientesTI\tareasPentientes;
use Illuminate\Http\Request;

class CheckListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tareas = tareasPentientes::all();
        $inspeccion = CheckList::all();
        return view('DepartamentoTI.index',compact('tareas','inspeccion'));
    }

    public function TareasPendientes(Request $request)
    {
        try{
            $tareas = new tareasPentientes();
            $tareas->Descripcion_Tarea = $request->Descripcion_Tarea;
            $tareas->save();
            return response()->json(['message'=>'Tarea registrada con éxito']);
        }catch(\Exception $e){
            return response()->json(['message'=>'No se pudo registrar la tarea'. $e->getMessage()]);

        } 

    }


    public function store(Request $request)
{
    $checklistData = $request->input('checklistData');

    foreach ($checklistData as $data) {
        Checklist::create([
            'sede' => $data[0],
            'campo' => $data[1],
            'estado_Campo' => $data[2],
            'comentarios' => $data[3],
        ]);
    }

    return 'ok'; // Envía una respuesta de éxito al cliente
}

}


