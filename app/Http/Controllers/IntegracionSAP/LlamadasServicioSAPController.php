<?php

namespace App\Http\Controllers\IntegracionSAP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LlamadasServicioSAPController extends Controller
{
   public function ConsultarLlamadaServicio(){
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
        CURLOPT_URL => "https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/ServiceCalls",
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


   public function GuardarCNCSAP(Request $request){

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
        CURLOPT_POSTFIELDS => "{\n    \"CompanyDB\": \"PRUEBAS_DOBLAMOS_NOV30\",\n    \"Password\": \"1234\",\n    \"UserName\": \"manager\"\n}",
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

    $CustomerCode=$request->input("CustomerCode");
    $CreationDate= $request->input("CreationDate");
    $Description= $request->input("Description");
    $U_DOB_AsignadoA= $request->input("U_DOB_AsignadoA");
    $CallType= $request->input("CallType");
    $U_DOB_SubTipoPr= $request->input("U_DOB_SubTipoPr");

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/ServiceCalls',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
    "Subject":"COSTO DE NO CALIDAD",
    "CustomerCode":"E1007767612",
    "CreationDate":"26-01-2023",
    "Description": "Descripcion de prueba del costo de no calidad",
    "U_DOB_AsignadoA":"Producción Servicios",
    "CallType":"28",
    "U_DOB_SubTipoPr":"Pieza fabricada de mas"
}',
CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    "Cookie: B1SESSION=".$SessionId."; ROUTEID=.node2"
),
));

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