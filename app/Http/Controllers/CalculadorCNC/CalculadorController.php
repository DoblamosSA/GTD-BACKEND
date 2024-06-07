<?php

namespace App\Http\Controllers\CalculadorCNC;

use App\Http\Controllers\Controller;
use App\Models\BodegasSAP\BodegasSAP;
use App\Models\RecursosSAP\RecursosSAP;
use App\Models\CalculadorCNC\Calculador;

use App\Models\Calibre\Calibre;
use App\Models\CostoNocalidad;
use App\Models\Lamina\Lamina;
use App\Models\MaterialesSAP\Materiales;
use App\Models\TransporteDoblamos\Transporte;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\TryCatch;

class CalculadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request, $id)
{

    $materiales = DB::table('materiales')
                  ->join('bodegas_s_a_p_s', 'materiales.warehouse_id', '=', 'bodegas_s_a_p_s.WarehouseCode')
                  ->select('materiales.ItemCode','materiales.id', 'materiales.ItemName', 'materiales.StandardAveragePrice', 'bodegas_s_a_p_s.WarehouseName')
                  ->where('materiales.StandardAveragePrice', '>', 0)
                  ->whereIn('bodegas_s_a_p_s.WarehouseCode', [ 15]) // Agregamos esta línea
                  ->orderBy('bodegas_s_a_p_s.WarehouseName')
                  ->get();
    
    $transporte = Transporte::all();
    $recursos = RecursosSAP::all();
    $laminas = Lamina::all();
    $calibres = Calibre::all();
    $bodegas = BodegasSAP::all();
   
    $costonocalidad = CostoNocalidad::findOrFail($id);
    $costonocalidad->SaldoFinalCNC = $request->total_final;
    $costonocalidad->save();        
    return view('CNC.calculador',compact('laminas','recursos','calibres','costonocalidad','bodegas','materiales','transporte'));
}

    public function getCalibres($laminaId)
    {
        $calibres = DB::table('calibre_lamina')
            ->join('calibres', 'calibre_lamina.calibre_id', '=', 'calibres.id')
            ->where('calibre_lamina.lamina_id', '=', $laminaId)
            ->select('calibres.id', 'calibres.Calibre', 'calibre_lamina.precio')
            ->get();
        return response()->json(['calibres' => $calibres]);
    }

    public function getCalibresMaterialrecuperadoMp($laminaId){
        $materialrecuperadomp = $this->getCalibres($laminaId);
        return response()->json($materialrecuperadomp);

    }

    public function getCalibresmrecuperado($laminaId){
        $calibresmp = DB::table('calibre_lamina')
        ->join('calibres', 'calibre_lamina.calibre_id', '=', 'calibres.id')
        ->where('calibre_lamina.lamina_id', '=', $laminaId)
        ->select('calibres.id', 'calibres.Calibre', 'calibre_lamina.precio')
        ->get();
    return response()->json(['calibresmp' => $calibresmp]);
    }

    public function getTransporteLogistico($codigo){

        $transportelogistico = DB::table('transportes')
        ->select('transportes.Codigo','transportes.Descripcion','transportes.valorTransporte')
        ->where('Codigo', '=', $codigo)
        ->get();
        return response()->json($transportelogistico);

    }

    public function getRecurso($id){
        $recurso = RecursosSAP::select('id', 'Cost1', 'UnitOfMeasure')
                    ->findOrFail($id);
                    return response()->json([
                        'id' => $recurso->id,
                        'Cost1' => $recurso->Cost1,
                        'UnitOfMeasure' => $recurso->UnitOfMeasure,
                    ]);
    }

    public function MateriaRecuperadoChatarra($id)
    {
        $chatarraRecuperada = $this->getRecurso($id);
    
        return $chatarraRecuperada;
    }
    

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'Articulo_id' => 'required|exists:materiales,id',
            'Recurso_id' => 'required|exists:recursos_s_a_p_s,id',
            'costo_nocalidad_id' => 'required|exists:costo_nocalidads,id',
            'user_costea_id' => 'required|exists:users,id',
            'Cantidad_Piezas' => 'required|numeric',
            'Espesor_Material' => 'required|numeric',
            'Ancho_Platina' => 'required|numeric',
            'Longitud' => 'required|numeric',
            'Total' => 'required|numeric',
        ]);
    
    try{
// Crear un nuevo registro en la tabla 'calculadors'
        $calculador = new Calculador();
        $calculador->Articulo_id = $validatedData['Articulo_id'];
        $calculador->calibres_id = $validatedData['calibres_id'];
        $calculador->Recurso_id = $validatedData['Recurso_id'];
        $calculador->costo_nocalidad_id = $validatedData['costo_nocalidad_id'];
        $calculador->user_costea_id = $validatedData['user_costea_id'];
        $calculador->Cantidad_Piezas = $validatedData['Cantidad_Piezas'];
        $calculador->Espesor_Material = $validatedData['Espesor_Material'];
        $calculador->Ancho_Platina = $validatedData['Ancho_Platina'];
        $calculador->Longitud = $validatedData['Longitud'];
        $calculador->Total = $validatedData['Total'];
        $calculador->save();
        return redirect()->route('CalculadorCNC.index')
        ->with('success', 'Se ha actualizado el costo.');
    }catch (\Exception $e) {
        return redirect()->back()
        ->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }


    public function obtenerMaterialesPorBodega($bodega)
    {
        $bodegaSap = BodegasSAP::where('WarehouseCode', $bodega)->first();
        $materiales = Materiales::where('warehouse_id', $bodegaSap->WarehouseCode.'')->get();
        return response()->json($materiales);
    }


        
    public function obtenerPrecioPorMaterial($material)
    {
        $material = DB::table('materiales')
            ->select('ItemCode', 'ItemName', 'StandardAveragePrice')
            ->where('id', $material)
            ->first();

            return response()->json($material);
    }
    
    

}
   