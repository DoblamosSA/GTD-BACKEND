<?php

namespace App\Http\Controllers\IntegracionSAP;


use App\Http\Controllers\Controller;
use App\Models\EmpledoSAP;
use Illuminate\Http\Request;
use Exception;

class EmpleadosSAPController extends Controller
{
    public function ConsultarEmpleadosSAP(){
          
        $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_PORT => "50000",
                CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Login",
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
                CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/BusinessPartners?".$cadenados."=CardCode,CardName,Cellular,Phone1,CardType,Currency".$cadena."=GroupCode+eq+111",
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
                // dd($response);
                
                 
            }

           
    }

    public function EmpleadosSAP(request $request){
       
        $response = new EmpleadosSAPController();
        $response = $response-> ConsultarEmpleadosSAP();
        $datos= array('response'=>json_decode($response,true));
        $clientes = $datos['response']['value'];
      foreach ($clientes as $cliente){

        $clientedb = new EmpledoSAP();
        try{

            $clientedb->CardCode = $cliente['CardCode'] ;
            $clientedb->CardName = $cliente['CardName'] ;
            $clientedb->CardType = $cliente['CardType'];
            $clientedb->Phone1 = $cliente['Phone1'];
            $clientedb->Currency = $cliente['Currency'];
            $clientedb->Cellular = $cliente['Cellular'];
            $clientedb->save();

        }catch(Exception $e){
       
        $post = EmpledoSAP::firstOrNew(['CardCode' => $cliente['CardCode']]); 
        // update record
        $post->CardCode =   $cliente['CardCode'];
        $post->CardName =   $cliente['CardName'];
        $post->CardType =   $cliente['CardType'];
        $post->Phone1 =     $cliente['Phone1'];
        $post->Currency =   $cliente['Currency'];
        $post->Cellular =   $cliente['Cellular'];
        $post->save();
       
        }
      

      
      }
      return redirect()->back()->with('success', 'Importacion masiva ejecutada correctamente!'); 
    }
}