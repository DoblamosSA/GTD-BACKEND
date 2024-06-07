<?php

namespace App\Http\Controllers\MaterialesSAP;

use App\Http\Controllers\Controller;
use App\Models\BodegasSAP\BodegasSAP;
use App\Models\MaterialesSAP\Materiales;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiales = DB::table('materiales')
                  ->join('bodegas_s_a_p_s', 'materiales.warehouse_id', '=', 'bodegas_s_a_p_s.WarehouseCode')
                  ->select('materiales.ItemCode','materiales.id', 'materiales.ItemName', 'materiales.StandardAveragePrice', 'bodegas_s_a_p_s.WarehouseName')
                  ->where('materiales.StandardAveragePrice', '>', 0)
                  ->whereIn('bodegas_s_a_p_s.WarehouseCode', [1, 4, 8, 12, 15]) // Agregamos esta línea
                  ->orderBy('bodegas_s_a_p_s.WarehouseName')
                  ->get();
    
        return view('Materiales.index', compact('materiales'));
    }
    



    public function  ImportarMateriales(){
    
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
                CURLOPT_URL =>"https://vm-hbt-hm7.heinsohncloud.com.co:50000/b1s/v1/Items?".$cadenados."=ItemCode,ItemName,SalesUnitWeight,ItemWarehouseInfoCollection".$cadena."=U_DOB_Grupo+eq+'04'",
                CURLOPT_RETURNTRANSFER => true,
                ini_set('memory_limit', '1024M'),
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
            $json = json_decode($response, true);
            $items = $json['value'];
            
            
            foreach ($items as $item) {
              $itemCode = $item['ItemCode'];
              $itemName = $item['ItemName'];
            
              foreach ($item['ItemWarehouseInfoCollection'] as $warehouseInfo) {

                $warehouseCode = $warehouseInfo['WarehouseCode'];
                $StandardAveragePrice = $warehouseInfo['StandardAveragePrice'];
                // hacer algo con el WarehouseCode
              }
            }
            return $items;
           
          
    }


    public function materialesEstandarSAPbd(){
        $items = new MaterialesController();
        $items = $items-> ImportarMateriales();
     

        foreach ($items as $material) {
            $itemCode = $material['ItemCode'];
            $itemName = $material['ItemName'];
            $SalesUnitWeight =$material['SalesUnitWeight'];
            foreach ($material['ItemWarehouseInfoCollection'] as $warehouseInfo) {
                $warehouseCode = $warehouseInfo['WarehouseCode'];
                $StandardAveragePrice = $warehouseInfo['StandardAveragePrice'];
                // Actualizar el precio del material en la bodega correspondiente
                Materiales::updateOrCreate(
                    ['ItemCode' => $itemCode, 'warehouse_id' => $warehouseCode],
                    ['ItemName' => $itemName, 'StandardAveragePrice' => $StandardAveragePrice, 'SalesUnitWeight' => $SalesUnitWeight]
                  
                );
            }
        }
      
        return redirect()->back()->with('success', 'Importación ejecutada correctamente');
    }


   
  
    
    
    
}