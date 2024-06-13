<?php

namespace App\Http\Controllers\BodegasSAP;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MaterialesSAP\ConsumiblesController;
use App\Models\BodegasSAP\BodegasSAP;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodegasSAPController extends Controller
{
    public function importBodegas() {
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
            CURLOPT_URL => env('URI') . "/Warehouses?".$cadenados."=WarehouseCode,WarehouseName",
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
            $response = json_decode($response, true);
            if(isset($response['odata.nextLink'])){
               $nextLink = $response['odata.nextLink'];
               $curl = curl_init();
               curl_setopt_array($curl, [
                    CURLOPT_PORT => "50000",
                    CURLOPT_URL =>env('URI') . "/".$nextLink,
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
                $nextResponse = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    return "cURL Error #:" . $err;
                } else {
                     $nextResponse = json_decode($nextResponse, true);
                     $response['value'] = array_merge($response['value'], $nextResponse['value']);
                     return json_encode($response);
                }
            }else{
               return json_encode($response);
            }
        }
        
    }


    public function GuardarBodegasbd(){
        $response = new BodegasSAPController();
        $response = $response-> importBodegas();
        $datos= array('response'=>json_decode($response,true));
        $materiales = $datos['response']['value'];
      
        foreach ($materiales as $material){
            BodegasSAP::updateOrCreate(
                ['WarehouseCode' => $material['WarehouseCode']],
                ['WarehouseName' => $material['WarehouseName']]
            );
        }
      
        return redirect()->back()->with('success', 'Importación ejecutada correctamente');
    }



   
    }