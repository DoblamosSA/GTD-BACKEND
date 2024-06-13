<?php

namespace App\Http\Controllers\RecursosSAP;

use App\Http\Controllers\Controller;
use App\Models\RecursosSAP\RecursosSAP;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Contracts\Session\Session;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;

class RecursosSAPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recursos = RecursosSAP::all();
        return view('RecursosSAP.index',compact('recursos'));
    }


    public function ImportarRecursos(){

           
        $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_PORT => "50000",
                CURLOPT_URL => env('URI') . "/Login",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"HBT_DOBLAMOS\",\n    \"Password\": \"DOB890\",\n    \"UserName\": \"manager\"\n}}",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: text/plain"
                ],
            ]);
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
        
            curl_close($curl);
        
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                $response = (array)json_decode($response);
                $SessionId = $response['SessionId'];
            }
        
            $cookie = "B1SESSION=" . $SessionId . "; ROUTEID=.node4";
        
            //EJECUTO CONSULTAS
        
            $curl = curl_init();
            
            $cadena = '&$filter';
            $cadenados = '$select';
            curl_setopt_array($curl, [
                CURLOPT_PORT => "50000",
                CURLOPT_URL => env('URI') . "/Resources?".$cadenados."=Code,Name,Cost1,UnitOfMeasure",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_COOKIE => $cookie,
                CURLOPT_HTTPHEADER => array(
                    "Expect:",
                    "Content-Type: application/json",
                    "Cookie: B1SESSION=".$SessionId."; ROUTEID=.node2"
                  )
                  
            ]);
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
        
            curl_close($curl);
        
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
             
                 return $response;
            
            }
    }

    public function GuardarRecursosSAP(request $request){
       
        $response = new RecursosSAPController();
        $response = $response-> ImportarRecursos();
        $datos= array('response'=>json_decode($response,true));
        $recursos = $datos['response']['value'];
      foreach ($recursos as $recurso){

        $recursodb = new RecursosSAP();
        try{

            $recursodb->Code = $recurso['Code'] ;
            $recursodb->Name = $recurso['Name'] ;
            $recursodb->Cost1 = $recurso['Cost1'];
            $recursodb->UnitOfMeasure = $recurso['UnitOfMeasure'];
            $recursodb->save();
            
        }catch(Exception $e){
       
        $post = RecursosSAP::firstOrNew(['Code' => $recurso['Code']]); 
        // update record
        $post->Code =   $recurso['Code'];
        $post->Name =   $recurso['Name'];
        $post->Cost1 = $recurso['Cost1'];
        $post->UnitOfMeasure = $recurso['UnitOfMeasure'];
        $post->save();
        return redirect()->back()->with('error', 'Error al guardar los datos: ' . $e->getMessage());
        }
      

      
      }
      return redirect()->back()->with('success', 'Importación ejecutada correctamente');
    }

}