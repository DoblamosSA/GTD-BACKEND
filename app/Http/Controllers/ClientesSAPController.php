<?php

namespace App\Http\Controllers;



use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiClientesSAP;
use App\Models\ClientesSAP;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ClientesSAPController extends Controller
{

    public function index(Request $request){
        
        $clientesSAP = ClientesSAP::all();
        
        return view('ClientesSap.index',compact('clientesSAP'));

    }

    public function create(Request $request){

        
      $clientesSAP = ClientesSAP::all();
        return view('ClientesSap.create',compact('clientesSAP'));

    }

    public function RegistroClienteSAP(Request $request){

        // Api para autenticarse y generacion de token SAP

        $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_PORT => "50000",
                CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Login",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"PRUEBAS_DOBLAMOS_NOV30\",\n    \"Password\": \"DOB890\",\n    \"UserName\": \"manager\"\n}",
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
        
        //metodo para crear en SAP el cliente pasandole el SesionID

        //las variables a continuacion vienen del formulario clientes, aqui se capturan para luego pasarsela a la api
        $CardCode = $request->input("CardCode");
        $CardName= $request->input("CardName");
        $FederalTaxID = $request->input("FederalTaxID");
        $Address = $request->input("Address");
        $Phone1 = $request->input("Phone1");
        $City = $request->input("City");
        $Country = $request->input("Country");
        $EmailAddress = $request->input("EmailAddress");
        // $GroupCode = $request->input("GroupCode");

        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/BusinessPartners',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "CardCode":"'.$CardCode.'",
            "CardName":"'.$CardName.'",
           "CardType": "L",
            "FederalTaxID":"'.$FederalTaxID.'",
            "Address":"'.$Address.'",
            "Phone1":"'.$Phone1.'",
            "City":"'.$City.'",
            "Country":"'.$Country.'",
            "EmailAddress":"'.$EmailAddress.'",
            "GroupCode":"108",
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Cookie: B1SESSION=".$SessionId."; ROUTEID=.node2"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

       
        
        return redirect()->route('ClientesSap.create')->with('msj',$response);
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function ConsultarClientesSAP(){
          
        $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_PORT => "50000",
                CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Login",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"PRUEBAS_DOBLAMOS_NOV30\",\n    \"Password\": \"DOB890\",\n    \"UserName\": \"manager\"\n}",
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
                CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/BusinessPartners?".$cadenados."=CardCode,CardName,Cellular,Phone1,CardType,Currency".$cadena."=GroupCode+eq+108",
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

    public function RegistroClienteBD(Request $request){

        $response = new ClientesSAPController();
        $response = $response-> ConsultarClientesSAP();
        $datos= array('response'=>json_decode($response,true));
        $clientes = $datos['response']['value'];
      foreach ($clientes as $cliente){

        $clientedb = new ClientesSAP();
        try{

            $clientedb->CardCode = $cliente['CardCode'] ;
            $clientedb->CardName = $cliente['CardName'] ;
            $clientedb->CardType = $cliente['CardType'];
            $clientedb->Phone1 = $cliente['Phone1'];
            $clientedb->Currency = $cliente['Currency'];
            $clientedb->Cellular = $cliente['Cellular'];
            $clientedb->save();

        }catch(Exception $e){
       
        $post = ClientesSAP::firstOrNew(['CardCode' => $cliente['CardCode']]); 
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
      return redirect()->back()->with('success', 'Importacion masiva ejecutada correctamente'); 
    }
  



    public function ConsultaClientesManualSAP( Request $request){

        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_PORT => "50000",
            CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"PRUEBAS_DOBLAMOS_NOV30\",\n    \"Password\": \"DOB890\",\n    \"UserName\": \"manager\"\n}",
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
    
      
        //CONSULTA MANUAL SOCIOS DE NEGOCIO
        $CardCode =$request->input("Cedula");
       
        $curl = curl_init();
            
        $cadena = '&$filter';
        $cadenados = '$select';
        curl_setopt_array($curl, [
            CURLOPT_PORT => "50000",
            CURLOPT_URL =>"https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/BusinessPartners('".$CardCode."')?".$cadenados."=CardCode,CardName,Cellular,Phone1,CardType,Currency",
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

}