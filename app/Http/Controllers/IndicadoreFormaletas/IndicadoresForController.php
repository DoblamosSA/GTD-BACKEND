<?php

namespace App\Http\Controllers\IndicadoreFormaletas;

use App\Http\Controllers\Controller;
use App\Models\Asesores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndicadoresForController extends Controller
{
   public function Indicadores(Request $request){

    $asesores = Asesores::all();
    $anios = $request->input('anios') ?? date('Y');
    $seguimientosano = $request->input('seguimientosano') ?? date('Y');
    $aniotipologia = $request->input('aniotipologia') ?? date('Y');
    $ventaspaisseguimiento = $request->input('ventaspaisseguimiento') ?? date('Y');
    $aniotipologiaseguimiento = $request->input('aniotipologiaseguimiento') ?? date('Y');
    $aniocostonocalidad = $request->input('aniocostonocalidad') ?? date('Y');
    $messeguimiento = $request->input('messeguimiento');
    $tipologia = $request->input('tipologia');
    $ventas_mes = $this->obtenerVentasMes($anios);
    $VentasGeneralesTipologiasanio = $request->input('VentasGeneralesTipologiasanio');
    $ventas_tipologia = $this->obtenerVentasTipologiaAjax($aniotipologia, $tipologia);
    $ventasasesoranio = $request->input('ventasasesoranio') ?? date('Y');
    $mesasesor = $request->input('mesasesor');
    $CotizacionesGeneralesTipologiasanio = $request->input('CotizacionesGeneralesTipologiasanio');
    $ventasasesoranioseguimiento = $request->input('ventasasesoranioseguimiento');
    $CotizacionesOrigenanio = $request->input('CotizacionesOrigenanio');
    $mesasesorseguimiento= $request->input('mesasesorseguimiento');
    $ventaspais = $request->input('ventaspais');
    $anioMetroscuadrados = $request->input('anioMetroscuadrados');
    $porcentajeExito = $request->input('porcentajeExito');
    return view('CotizacionesFormaletas.Indicador', compact('porcentajeExito','anioMetroscuadrados','ventaspais','CotizacionesOrigenanio','CotizacionesGeneralesTipologiasanio','mesasesorseguimiento','ventasasesoranioseguimiento','mesasesor','ventasasesoranio','asesores','messeguimiento','aniocostonocalidad','VentasGeneralesTipologiasanio','ventaspaisseguimiento','ventas_mes', 'anios', 'seguimientosano', 'aniotipologia', 'aniotipologiaseguimiento'));
    
   }

      

   public function obtenerVentasMesseguimiento($anios){
    $ventasseguimiento = DB::table('cotizaciones__formaletas')
        ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, SUM(Valor_Adjudicado) as total'))
        ->whereNotNull('Fecha_Cotizada')
        ->whereYear('Fecha_Cotizada', '=', $anios)
        ->where('Estado', '=' ,'Seguimiento')
        ->groupBy(DB::raw('MONTH(Fecha_Cotizada)'))
        ->orderBy(DB::raw('MONTH(Fecha_Cotizada)'))
        ->get();
    return $ventasseguimiento;
}



 //funcion para que se hereda de obtenerVentasMes en seguimiento para pasar en json la respuesta de la pediticion que hace ajax
 public function obtenerVentasMesseguimientoAjax($seguimientosano){

    $ventasseguimiento = $this->obtenerVentasMesseguimiento($seguimientosano);
    return response()->json($ventasseguimiento);

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //funcion para consultar las ventas mensuales
    public function obtenerVentasMes($anio)
    {
        $ventas_mes = DB::table('cotizaciones__formaletas')
            ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, SUM(Valor_Adjudicado) as total'))
            ->whereNotNull('Fecha_Cotizada')
            ->whereYear('Fecha_Cotizada', '=', $anio)
            ->where('Estado', '=', 'Vendida')
            ->groupBy(DB::raw('MONTH(Fecha_Cotizada)'))
            ->orderBy(DB::raw('MONTH(Fecha_Cotizada)'))
            ->get();

        return $ventas_mes;
    }   

    // Función para obtener las ventas por país usando AJAX
    public function obtenerVentasMesAjax($anio)
    {
        $ventas_mes = $this->obtenerVentasMes($anio);
        return response()->json($ventas_mes);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////






/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //obtener ventas por tipologia y año vendidas
    public function obtenerVentasTipologia($anio,$tipologia){
        $ventas_tipologia = DB::table('cotizaciones__formaletas')
            ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, SUM(Valor_Adjudicado) as total'))
            ->whereNotNull('Fecha_Cotizada')
            ->whereYear('Fecha_Cotizada', '=', $anio)
            ->where('Tipologia', '=', $tipologia)
            ->where('Estado', '=', 'Vendida')
            ->groupBy(DB::raw('MONTH(Fecha_Cotizada)'))
            ->orderBy(DB::raw('MONTH(Fecha_Cotizada)'))
            ->get();
        return $ventas_tipologia;
    }
    
    public function obtenerVentasTipologiaAjax($anio,$tipologia){

        $ventas_tipologia = $this->obtenerVentasTipologia($anio,$tipologia);
       return response()->json($ventas_tipologia);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function obtenerVentasTipologiaSeguimientofor($anio,$tipologiaseguimiento){
        $ventas_tipologiaseguimiento = DB::table('cotizaciones__formaletas')
        ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, SUM(Valor_Adjudicado) as total'))
        ->whereNotNull('Fecha_Cotizada')
        ->whereYear('Fecha_Cotizada', '=', $anio)
        ->where('Tipologia', '=', $tipologiaseguimiento)
        ->where('Estado', '=', 'Seguimiento')
        ->groupBy(DB::raw('MONTH(Fecha_Cotizada)'))
        ->orderBy(DB::raw('MONTH(Fecha_Cotizada)'))
        ->get();
            return $ventas_tipologiaseguimiento;
    }
   
    public function obtenerVenTipolSeguimiformaletajax($anio,$tipologiaseguimiento){

        $ventas_tipologiaseguimiento= $this->obtenerVentasTipologiaSeguimientofor($anio,$tipologiaseguimiento);
        return response()->json($ventas_tipologiaseguimiento);
     
        }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function obtenerVentasPais($anio)
{
    $ventasPorPais = DB::table('cotizaciones__formaletas')
        ->select('pais_cordenadas.latitude', 'pais_cordenadas.longitude', 'pais_cordenadas.countryName', DB::raw('SUM(cotizaciones__formaletas.Valor_Adjudicado) as ventas'))
        ->join('pais_cordenadas', 'cotizaciones__formaletas.Pais_id', '=', 'pais_cordenadas.id')
        ->whereNotNull('cotizaciones__formaletas.Fecha_Cotizada')
        ->whereYear('cotizaciones__formaletas.Fecha_Cotizada', '=', $anio)
        ->where('cotizaciones__formaletas.Estado', '=', 'Vendida')
        ->groupBy('cotizaciones__formaletas.Pais_id', 'pais_cordenadas.latitude', 'pais_cordenadas.longitude', 'pais_cordenadas.countryName')
        ->get();

    return $ventasPorPais;
}



public function obtenerVentasPaisAjax($anio){
    $ventasPorPais = $this->obtenerVentasPais($anio);
    return response()->json($ventasPorPais);
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function obtenerVentasPaisSeguimiento($anio, $mes) {
    $ventasPorPaisSeguimiento = DB::table('cotizaciones__formaletas')
        ->select(
            'pais_cordenadas.latitude',
            'pais_cordenadas.longitude',
            'pais_cordenadas.countryName',
            DB::raw('SUM(cotizaciones__formaletas.Valor_Adjudicado) as ventas'),
            DB::raw('COUNT(cotizaciones__formaletas.id) as cotizaciones'),
            DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada) as mes')
        )
        ->join('pais_cordenadas', 'cotizaciones__formaletas.Pais_id', '=', 'pais_cordenadas.id')
        ->whereNotNull('cotizaciones__formaletas.Fecha_Cotizada')
        ->whereYear('cotizaciones__formaletas.Fecha_Cotizada', '=', $anio)
        ->whereMonth('cotizaciones__formaletas.Fecha_Cotizada', '=', $mes)
        ->where('cotizaciones__formaletas.Estado', '=', 'Seguimiento')
        ->groupBy(
            'cotizaciones__formaletas.Pais_id',
            'pais_cordenadas.latitude',
            'pais_cordenadas.longitude',
            'pais_cordenadas.countryName',
            DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada)')
        )
        ->get();

    return $ventasPorPaisSeguimiento;
}



    public function obtenerVentasPaisSeguimientoAjax($anio, $mes){  
        $ventasPorPaisseguimiento = $this->obtenerVentasPaisSeguimiento($anio,$mes);
        return response()->json($ventasPorPaisseguimiento);
    }
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
   
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function GraficoTipologiasGenerales($anio){

    $VentasTipologiaGeneral = DB::table('cotizaciones__formaletas')
    ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, Tipologia, SUM(Valor_Adjudicado) as total'))
    ->whereNotNull('Fecha_Cotizada')
    ->whereYear('Fecha_Cotizada', '=', $anio)
    ->where('Estado', '=', 'Vendida')
    ->groupBy(DB::raw('MONTH(Fecha_Cotizada), Tipologia'))
    ->orderBy(DB::raw('MONTH(Fecha_Cotizada), Tipologia'))
    ->get();

return $VentasTipologiaGeneral;

}

public function GraficoTipologiasGeneralesAjax($anio){
    $VentasTipologiaGeneral = $this->GraficoTipologiasGenerales($anio);
   return response()->json($VentasTipologiaGeneral);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
    


public function GraficoTipologiasGeneralesCotizaciones($anio){

    $CotizacionesTipologiaGeneral = DB::table('cotizaciones__formaletas')
    ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, Tipologia, SUM(Valor_Adjudicado) as total'))
    ->whereNotNull('Fecha_Cotizada')
    ->whereYear('Fecha_Cotizada', '=', $anio)
    ->where('Estado', '=', 'Seguimiento')
    ->groupBy(DB::raw('MONTH(Fecha_Cotizada), Tipologia'))
    ->orderBy(DB::raw('MONTH(Fecha_Cotizada), Tipologia'))
    ->get();
    return $CotizacionesTipologiaGeneral;
}

public function GraficoTipologiasGeneralesCotizacionesAjax ($anio){
    $CotizacionesTipologiaGeneral = $this->GraficoTipologiasGeneralesCotizaciones($anio);
    return response()->json($CotizacionesTipologiaGeneral);
}

public function GraficoVentasOrigen($anio){

    $CotizacionesSeguimientoOrigen =DB::table('cotizaciones__formaletas')
   ->select(DB::raw('MONTH(Fecha_Cotizada) as mes, Origen, SUM(Valor_Adjudicado) as total'))
    ->whereNotNull('Fecha_Cotizada')
    ->whereYear('Fecha_Cotizada', '=', $anio)
    ->where('Estado', '=', 'Seguimiento')
    ->groupBy(DB::raw('MONTH(Fecha_Cotizada), Origen'))
    ->orderBy(DB::raw('MONTH(Fecha_Cotizada), Origen'))
    ->get();
    return $CotizacionesSeguimientoOrigen;
}

public function GraficoVentasOrigenAjax($anio){
    $CotizacionesSeguimientoOrigen= $this->GraficoVentasOrigen($anio);
    return response()->json($CotizacionesSeguimientoOrigen);
}

public function PaisGeocalizacion()
{
    $username = 'stivenmadrid6';
        $url = "http://api.geonames.org/countryInfoJSON?username=$username";

        // Realizar la solicitud a la API
        $response = file_get_contents($url);

        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        // Acceder a los datos de los países
        $countries = $data['geonames'];

        // Recorrer y guardar los países en la base de datos
        foreach ($countries as $country) {
            $countryName = $country['countryName'];
            $latitude = isset($country['north']) ? $country['north'] : null;
            $longitude = isset($country['west']) ? $country['west'] : null;

            // Crear una nueva instancia del modelo PaisCordenadas
            $paisCordenadas = new PaisCordenadas();
            $paisCordenadas->countryName = $countryName;
            $paisCordenadas->latitude = $latitude;
            $paisCordenadas->longitude = $longitude;

            // Guardar el país en la base de datos
            $paisCordenadas->save();
        }

        return response()->json(['message' => 'Información de países guardada en la base de datos']);
}
public function costosnocalidad($anio)
{
    $costosnocalidad = DB::table('costo_nocalidads')
    ->select(DB::raw('  DATENAME(month, FechaCNC) as mes_alias, SUM(CostoCNC) as total'))
    ->where('AreaResponsableCNC', 'Formaletas')
    ->whereYear('fechaCNC', '=', $anio)
    ->whereNotNull('CostoCNC') // Filtra los registros con costos no nulos
    ->groupBy(DB::raw('MONTH(FechaCNC), DATENAME(month, FechaCNC)'))
    ->orderBy(DB::raw('MONTH(FechaCNC)'))
    ->get();

    return $costosnocalidad;
}



public function costosnocalidadajax($anio){

    $costosnocalidad = $this->costosnocalidad($anio);
    return response()->json($costosnocalidad);
}



public function VentasAsesor($anio, $mes) {
    $ventasAsesor = DB::table('cotizaciones__formaletas')
        ->select(DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada) as mes, COUNT(*) as total_ventas, SUM(cotizaciones__formaletas.Valor_Adjudicado) as total_valor, asesores.Nombre_Asesor'))
        ->join('asesores', 'cotizaciones__formaletas.Asesor_id', '=', 'asesores.id')
        ->whereNotNull('cotizaciones__formaletas.Fecha_Cotizada')
        ->whereYear('cotizaciones__formaletas.Fecha_Cotizada', '=', $anio)
        ->whereMonth('cotizaciones__formaletas.Fecha_Cotizada', '=', $mes)
        ->where('cotizaciones__formaletas.Estado', '=', 'Vendida')
        ->groupBy('asesores.Nombre_Asesor', DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada)'))
        ->orderBy(DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada)'))
        ->get();

    return $ventasAsesor;
}


public function VentasAsesorAjax($anio, $mes) {
    $ventasAsesor = $this->VentasAsesor($anio, $mes);
    return response()->json($ventasAsesor);
}


public function VentasAsesorSeguimiento($anio, $mes)
{
    $ventasAsesorSeguimiento = DB::table('cotizaciones__formaletas')
        ->select(DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada) as mes, COUNT(*) as total_ventas, SUM(cotizaciones__formaletas.Valor_Adjudicado) as total_valor, asesores.Nombre_Asesor'))
        ->join('asesores', 'cotizaciones__formaletas.Asesor_id', '=', 'asesores.id')
        ->whereNotNull('cotizaciones__formaletas.Fecha_Cotizada')
        ->whereYear('cotizaciones__formaletas.Fecha_Cotizada', '=', $anio)
        ->whereMonth('cotizaciones__formaletas.Fecha_Cotizada', '=', $mes)
        ->where('cotizaciones__formaletas.Estado', '=', 'Seguimiento')
        ->groupBy('asesores.Nombre_Asesor', DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada)'))
        ->orderBy(DB::raw('MONTH(cotizaciones__formaletas.Fecha_Cotizada)'))
        ->get();

    return $ventasAsesorSeguimiento;
}



public function VentasAsesorSeguimientoAjax($anio,$mes){
    $ventasAsesorSeguimiento= $this->VentasAsesorSeguimiento($anio,$mes);
    return response()->json($ventasAsesorSeguimiento);
}


function consultaMetrosCuadradosPorMes($anio)
{
    $metrosCuadrados = DB::table('vortes')
        ->selectRaw('YEAR(Fecha_Cotizada) as anio, MONTH(Fecha_Cotizada) as mes, COUNT(*) as cantidad_registros, SUM(Metros_Cuadrados) as total_metros_cuadrados')
        ->whereNotNull('Fecha_Cotizada')
        ->whereYear('Fecha_Cotizada', '=', $anio)
        ->where('Estado', '=', 'Seguimiento')
        ->groupByRaw('YEAR(Fecha_Cotizada), MONTH(Fecha_Cotizada)')
        ->get();

    return $metrosCuadrados;
}


public function consultaMetrosCuadradosPorMesAjax($anio){

    $metrosCuadrados = $this->consultaMetrosCuadradosPorMes($anio);
    return response()->json($metrosCuadrados);
}





public function calcularPorcentajeExitoVentas($anio)
{
    $cotizaciones = DB::table('cotizaciones__formaletas')
        ->selectRaw('MONTH(Fecha_Cotizada) as mes, COUNT(*) as cotizaciones')
        ->whereYear('Fecha_Cotizada', $anio)
        ->whereIn('Estado', ['Seguimiento', 'Vendida', 'Perdida'])
        ->groupByRaw('MONTH(Fecha_Cotizada)')
        ->get();

    $ventas = DB::table('cotizaciones__formaletas')
        ->selectRaw('MONTH(Fecha_Venta) as mes, COUNT(*) as ventas')
        ->whereYear('Fecha_Venta', $anio)
        ->whereIn('Estado', ['Vendida'])
        ->groupByRaw('MONTH(Fecha_Venta)')
        ->get();

    $porcentajes = [];
    for ($mes = 1; $mes <= 12; $mes++) {
        $cotizacionesMes = 0;
        $ventasMes = 0;

        foreach ($cotizaciones as $cotizacion) {
            if ($cotizacion->mes == $mes) {
                $cotizacionesMes = $cotizacion->cotizaciones;
                break;
            }
        }

        foreach ($ventas as $venta) {
            if ($venta->mes == $mes) {
                $ventasMes = $venta->ventas;
                break;
            }
        }

        if ($cotizacionesMes > 0) {
            $porcentajeExito = ($ventasMes / $cotizacionesMes) * 100;
        } else {
            $porcentajeExito = 0;
        }

        $porcentajes[] = [
            'mes' => $mes,
            'porcentaje' => $porcentajeExito
        ];
    }

    return response()->json($porcentajes);
}






}
