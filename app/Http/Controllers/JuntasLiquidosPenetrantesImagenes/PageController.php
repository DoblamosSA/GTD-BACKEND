<?php

namespace App\Http\Controllers\JuntasLiquidosPenetrantesImagenes;

use App\Http\Controllers\Controller;
use App\Models\JuntasLiqPenIma;
use App\Models\Utilidades;
use Illuminate\Http\Request;

class PageController extends Controller
{
     ///Metodos api

     public function api_getByIdJunta(Request $request, $id)
     {
         $data = new JuntasLiqPenIma();
 
         $data = JuntasLiqPenIma::where('junta_liq_penetran_id', $id);
         if ($data) {
             $data = $data->get()->toJson(JSON_PRETTY_PRINT);
         }
 
         return response($data, 200);
     }
 
     public function api_getById(Request $request, $id)
     {
         $data = new JuntasLiqPenIma();
         $data = JuntasLiqPenIma::where('id', $id)->get()->first();
         if ($data) {
             $data =  $data->toJson(JSON_PRETTY_PRINT);
         }
         return response($data, 200);
     }
 
     public function api_add(Request $request)
     {
         $input = $request->all();
         $input['file_path']=(new Utilidades())->guardarImagen($request);        
         $data = JuntasLiqPenIma::create($input);
 
         return response($data, 200);
     }
 
     public function api_update(Request $request)
     {
         $input = $request->all();
         $id = $input['id'];
         $data = JuntasLiqPenIma::find($id);
         if ($data) {
            (new Utilidades())->guardarImagen($request);
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
         $data = JuntasLiqPenIma::find($id);
         if ($data) {
            (new Utilidades())->eliminarImagen($data->file_path);   
             $juntasInformeVertMetalica = $data->delete();
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
