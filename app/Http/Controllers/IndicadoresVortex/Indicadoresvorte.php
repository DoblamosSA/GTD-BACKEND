<?php

namespace App\Http\Controllers\IndicadoresVortex;

use App\Http\Controllers\Controller;
use App\Models\Asesores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vorte;
use App\Models\Pais\PaisCordenadas;
class Indicadoresvorte extends Controller

{
    public function Indicadores(Request $request)
{
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
    return view('vortexDoblamos.Indicadores', compact('porcentajeExito','anioMetroscuadrados','ventaspais','CotizacionesOrigenanio','CotizacionesGeneralesTipologiasanio','mesasesorseguimiento','ventasasesoranioseguimiento','mesasesor','ventasasesoranio','asesores','messeguimiento','aniocostonocalidad','VentasGeneralesTipologiasanio','ventaspaisseguimiento','ventas_mes', 'anios', 'seguimientosano', 'aniotipologia', 'aniotipologiaseguimiento'));
}
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //funcion para consultar las ventas mensuales
    public function obtenerVentasMes($anios){
        $ventas_mes = DB::table('vortes')
            ->select(DB::raw('MONTH(Fecha_Venta) as mes, SUM(Valor_Adjudicado) as total'))
            ->whereNotNull('Fecha_Venta')
            ->whereYear('Fecha_Venta', '=', $anios)
            ->where('Estado', '=' ,'Vendida')
            ->groupBy(DB::raw('MONTH(Fecha_Venta)'))
            ->orderBy(DB::raw('MONTH(Fecha_Venta)'))
            ->get();
        return $ventas_mes;
    }
    

    //funcion para que se hereda de obtenerVentasMes para pasar en json la respuesta de la pediticion que hace ajax
        public function obtenerVentasMesAjax($anios)
    {
        $ventas_mes = $this->obtenerVentasMes($anios);
        return response()->json($ventas_mes);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function obtenerVentasMesseguimiento($anios){
        $ventasseguimiento = DB::table('vortes')
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //obtener ventas por tipologia y año vendidas
    public function obtenerVentasTipologia($anio,$tipologia){
        $ventas_tipologia = DB::table('vortes')
            ->select(DB::raw('MONTH(Fecha_Venta) as mes, SUM(Valor_Adjudicado) as total'))
            ->whereNotNull('Fecha_Venta')
            ->whereYear('Fecha_Venta', '=', $anio)
            ->where('Tipologia', '=', $tipologia)
            ->where('Estado', '=', 'Vendida')
            ->groupBy(DB::raw('MONTH(Fecha_Venta)'))
            ->orderBy(DB::raw('MONTH(Fecha_Venta)'))
            ->get();
        return $ventas_tipologia;
    }
    
    public function obtenerVentasTipologiaAjax($anio,$tipologia){

        $ventas_tipologia = $this->obtenerVentasTipologia($anio,$tipologia);
       return response()->json($ventas_tipologia);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function obtenerVentasTipologiaSeguimiento($anio,$tipologiaseguimiento){
        $ventas_tipologiaseguimiento = DB::table('vortes')
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
   
    public function obtenerVentasTipologiaSeguimientoajax($anio,$tipologiaseguimiento){

        $ventas_tipologiaseguimiento= $this->obtenerVentasTipologiaSeguimiento($anio,$tipologiaseguimiento);
        return response()->json($ventas_tipologiaseguimiento);
     
        }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function obtenerVentasPais($anio)
{
    $ventasPorPais = Vorte::select('pais_cordenadas.latitude', 'pais_cordenadas.longitude', 'pais_cordenadas.countryName',
     DB::raw('SUM(vortes.Valor_Adjudicado) as ventas'))
        ->join('pais_cordenadas', 'vortes.Pais', '=', 'pais_cordenadas.id')
        ->whereNotNull('Fecha_Venta')
        ->whereYear('Fecha_Venta', '=', $anio)
        ->where('vortes.Estado', '=', 'Vendida')
        ->groupBy('vortes.Pais', 'pais_cordenadas.latitude', 'pais_cordenadas.longitude', 'pais_cordenadas.countryName')
        ->get();

    return $ventasPorPais;
}

public function obtenerVentasPaisAjax($anio){
    $ventasPorPais = $this->obtenerVentasPais($anio);
    return response()->json($ventasPorPais);
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function obtenerVentasPaisSeguimiento($anio, $mes) {
   
    $ventasPorPaisSeguimiento = Vorte::select(
        'pais_cordenadas.latitude',
        'pais_cordenadas.longitude',
        'pais_cordenadas.countryName', 
        DB::raw('SUM(vortes.Valor_Adjudicado) as ventas'),
        DB::raw('COUNT(vortes.id) as cotizaciones'),
        DB::raw('MONTH(vortes.Fecha_Cotizada) as mes')
    )
    ->join('pais_cordenadas', 'vortes.Pais', '=', 'pais_cordenadas.id')
    ->whereNotNull('Fecha_Cotizada')
    ->whereYear('Fecha_Cotizada', '=', $anio)
    ->whereMonth('Fecha_Cotizada', '=', $mes)
    ->where('vortes.Estado', '=', 'Seguimiento')
    ->groupBy(
        'vortes.Pais',
        'pais_cordenadas.latitude',
        'pais_cordenadas.longitude',
        'pais_cordenadas.countryName',
        DB::raw('MONTH(vortes.Fecha_Cotizada)')
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

    $VentasTipologiaGeneral = DB::table('vortes')
    ->select(DB::raw('MONTH(Fecha_Venta) as mes, Tipologia, SUM(Valor_Adjudicado) as total'))
    ->whereNotNull('Fecha_Venta')
    ->whereYear('Fecha_Venta', '=', $anio)
    ->where('Estado', '=', 'Vendida')
    ->groupBy(DB::raw('MONTH(Fecha_Venta), Tipologia'))
    ->orderBy(DB::raw('MONTH(Fecha_Venta), Tipologia'))
    ->get();

return $VentasTipologiaGeneral;

}

public function GraficoTipologiasGeneralesAjax($anio){
    $VentasTipologiaGeneral = $this->GraficoTipologiasGenerales($anio);
   return response()->json($VentasTipologiaGeneral);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
    


public function GraficoTipologiasGeneralesCotizaciones($anio){

    $CotizacionesTipologiaGeneral = DB::table('vortes')
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

    $CotizacionesSeguimientoOrigen =DB::table('vortes')
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
    ->where('AreaResponsableCNC', 'vortex')
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
    $ventasAsesor = DB::table('vortes')
        ->select(DB::raw('MONTH(vortes.Fecha_Venta) as mes, COUNT(*) as total_ventas, SUM(vortes.Valor_Adjudicado) as total_valor, asesores.Nombre_Asesor'))
        ->join('asesores', 'vortes.Asesor_id', '=', 'asesores.id')
        ->whereNotNull('vortes.Fecha_Venta')
        ->whereYear('vortes.Fecha_Venta', '=', $anio)
        ->whereMonth('vortes.Fecha_Venta', '=', $mes)
        ->where('vortes.Estado', '=', 'Vendida')
        ->groupBy('asesores.Nombre_Asesor', DB::raw('MONTH(vortes.Fecha_Venta)'))
        ->orderBy(DB::raw('MONTH(vortes.Fecha_Venta)'))
        ->get();

    return $ventasAsesor;
}

public function VentasAsesorAjax($anio, $mes) {
    $ventasAsesor = $this->VentasAsesor($anio, $mes);
    return response()->json($ventasAsesor);
}


public function VentasAsesorSeguimiento($anio,$mes){
    $ventasAsesorSeguimiento = DB::table('vortes')
    ->select(DB::raw('MONTH(vortes.Fecha_Cotizada) as mes, COUNT(*) as total_ventas, SUM(vortes.Valor_Adjudicado) as total_valor, asesores.Nombre_Asesor'))
    ->join('asesores', 'vortes.Asesor_id', '=', 'asesores.id')
    ->whereNotNull('vortes.Fecha_Cotizada')
    ->whereYear('vortes.Fecha_Cotizada', '=', $anio)
    ->whereMonth('vortes.Fecha_Cotizada', '=', $mes)
    ->where('vortes.Estado', '=', 'Seguimiento')
    ->groupBy('asesores.Nombre_Asesor', DB::raw('MONTH(vortes.Fecha_Cotizada)'))
    ->orderBy(DB::raw('MONTH(vortes.Fecha_Cotizada)'))
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
     $cotizaciones = DB::table('vortes')
        ->selectRaw('MONTH(Fecha_Cotizada) as mes, COUNT(*) as cotizaciones')
        ->whereYear('Fecha_Cotizada', $anio)
        ->whereIn('Estado', ['Seguimiento', 'Vendida', 'Perdida'])
        ->groupByRaw('MONTH(Fecha_Cotizada)')
        ->get();

    $ventas = DB::table('vortes')
        ->selectRaw('MONTH(Fecha_Venta) as mes, COUNT(*) as ventas')
        ->whereYear('Fecha_Venta', $anio)
      ->where('Estado', '=', 'Vendida')
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
