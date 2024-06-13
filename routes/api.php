<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IntegracionSAP\AnalisisVentaVorteController;
use App\Http\Controllers\ProyectosSAP\ProyectosSAPController;
use App\Http\Controllers\ModuloFinanzas\ModuloFacture\PedidoCompraController;
use App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController;
use App\Http\Controllers\Logistica\AbastecimientoMRPSAP\AbastecimientoController;
use App\Http\Controllers\Logistica\AbastecimientoMRPSAP\Abastecimiento_MRP_ALMACENController;
use App\Http\Controllers\ModuloFinanzas\ModuloCartera\CuentasporpagarController;
use App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\Compras\ComprasController;
use App\Http\Controllers\DepartamentoTI\InventarioController;
use App\Http\Controllers\DepartamentoTI\Licencias\LicenciasController;
use App\Http\Controllers\VorteController;
use App\Http\Controllers\EstructuraMetalicaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);


// Proteger todas las rutas con autenticaci�n Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('V1/register', [AuthController::class, 'register']);
    Route::delete('v1/usuarios/destroy/{id}', [AuthController::class, 'eliminarUsuario']);
    Route::put('v1/usuarios/actualizar/{id}', [AuthController::class, 'actualizarUsuario']);
    Route::get('V1/usuarios/{id}', [AuthController::class, 'listusers']);
  
    // Permisos
    Route::get('v1/roles', [RolesController::class, 'index']);
    Route::post('v1/roles/store', [RolesController::class, 'store']);
    Route::put('v1/roles/update/{id}', [RolesController::class, 'update']);
    Route::delete('v1/roles/destroy/{id}', [RolesController::class, 'destroy']);
    
    
    Route::get('V1/permissions', [PermissionController::class, 'index']);
    Route::post('V1/permissions', [PermissionController::class, 'store']);
    Route::put('V1/permissions/update/{id}', [PermissionController::class, 'update']);
    Route::delete('V1/permissions/destroy/{permission}', [PermissionController::class, 'destroy']);
    
 

    // Informe an�lisis ventas SAP
    Route::get('Analisis_venta', [AnalisisVentaController::class, 'consultarVentasSAP']);
    Route::get('Analisisventavorte', [AnalisisVentaVorteController::class, 'consultarVentasvorteSAP']);

    // Apis integraci�n SAPFACTURE
    Route::get('ConsultapedidosCompraSAP', [PedidoCompraController::class, 'pedidocompraSAP']);

    // Apis Modulo Log�stica
    Route::get('Logistica-costeo-articulos', [CostoProductosController::class, 'ConsultaCostoProductosSAP']);
    Route::get('Logistica-costeo-articulos-sendRevaluation', [CostoProductosController::class, 'sendRevaluation']);

    // Rutas para el aprobador de Cartera
Route::put('/solicitudes/aprobar/cartera/{id}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'aprobarCartera']);
Route::put('/solicitudes/aprobar/beratung/{id}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'aprobarBeratung']);
Route::put('/solicitudes/aprobar/sagrilaft/{id}',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'aprobarSagrilaft']);
Route::put('/solicitudes/aprobar/gerencia/{id}',[SolicitudesCreditoController::class,'aprobargerencia']);



Route::post('comentariossolicitudescredito/{id_solicitud}',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'seguimientosolicitudescomentarios']);
Route::get('solicitudes/obtener-comentarios/{id_solicitud}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'obtenerComentarios']);

Route::put('/solicitudes/rechazar/cartera/{id}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'rechazarCartera']);
Route::put('/solicitudes/rechazar/beratung/{id}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'rechazarBeratung']);
Route::put('/solicitudes/rechazar/sagrilaft/{id}',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'rechazarSagrilaft']);
Route::put('/solicitudes/rechazar/gerencia/{id}',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'rechazarGerencia']);
Route::put('/solicitud/actualizar/{id_solicitud}', [SolicitudesCreditoController::class, 'updatesolicitud']);
Route::put('/solicitud/actualizar/{id_solicitud}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'updatesolicitud']);
Route::put('/solicitud/actualizarrechazo/{id_solicitud}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'updatesolicitudrechazada']);

Route::put('adjuntos-cartera/solicitud/{id_solicitud}', [SolicitudesCreditoController::class, 'adjuntarDocumentoscartera']);

Route::put('/solicitud/actualizarmonto/{id_solicitud}', [SolicitudesCreditoController::class, 'updatesolicitudmonto']);
//Gesti�n de cartera:
Route::post('gerarseguimiento_cuentasporpagar/{id_cuenta}', [CuentasporpagarController::class, 'guardarSeguimientocuentasporpagar']);
Route::get('obtener_seguimientos_cuentasporpagar/{id_cuenta}', [CuentasporpagarController::class, 'obtenerSeguimientosCuentasporpagar']);
Route::get('cuentas-porpagar/obtener-comentarios/{id_cuenta}', [CuentasporpagarController::class, 'obtenerSeguimientosCuentasporpagar']);
Route::get('cuentas-porpagar',[CuentasporpagarController::class,'Cuentasporpagar']);
Route::post('gerarseguimiento_cuentasporpagar/{id_cuenta}', [CuentasporpagarController::class, 'guardarSeguimientocuentasporpagar']);
Route::patch('actualizar-correo-sap',[CuentasporpagarController::class, 'ModificarCorreoSAPGesCartera']);
//enviomasivoclientes por pagar
Route::post('enviar-correo-masivo-clientessaldopendiente', [CuentasporpagarController::class, 'enviarCorreoSaldoclientesporpagar']);
Route::get('/buscar-proveedor-SAP',[CotizacionesController::class,'ConsultarProveedoresSAP']);
Route::get('/ImportarProjectSAP',[ProyectosSAPController::class,'ImportarProjectSAP']);

});



// Guardar inventario
Route::post('GuardarInventario',[InventarioController::class,'AlmacenarDispositivo']);

Route::get('asesores', [\App\Http\Controllers\Asesores\AsesorController::class, 'consultaAsesoresApi']);
Route::post('Solicitud-Creditos',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'SolicitudesCreditostore']);
Route::get('consultar-solicitud', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'consultaEstadoSolicitud']);
Route::any('/aprobar-desde-correo/{id}/{numeroRadicado}/{usergerencia}', [SolicitudesCreditoController::class, 'aprobarDesdeCorreogerenciasolicitud']);
Route::any('/rechazar-desde-correo/{id}/{numeroRadicado}/{usergerencia}', [SolicitudesCreditoController::class, 'rechazarDesdeCorreogerenciasolicitud']);


//MRP MATERIA PRIMA
Route::POST('consumirpromedioventaSAP', [AbastecimientoController::class, 'consumirpromedioventaSAP']);

Route::put('generar-solicitud-compra-updatesugerido',[AbastecimientoController::class,'actualizarSugeridos']);
Route::get('consultar-stock-bodega-articuloSAP',[AbastecimientoController::class,'consultarstockarticulosSAP']);

//MRP ALMACEN
Route::post('/generar-solicitud-compra-almacen', [Abastecimiento_MRP_ALMACENController::class, 'generarSolicitudCompraAPIalmacen']);
Route::get('consultar-stock-bodega-articuloSAP-Almacen',[Abastecimiento_MRP_ALMACENController::class,'consultarstockarticulosSAPAlmacen']);
Route::POST('consumirpromedioventaSAPAlmacen', [Abastecimiento_MRP_ALMACENController::class, 'consumirpromedioventaSAPalmacen']);

//sap recaudos
Route::get('consumir-recaudos-sap',[CuentasporpagarController::class,'recaudosSAPAPI']);
Route::get('obtenerRecaudos',[CuentasporpagarController::class,'obtenerRecaudos']); 
Route::get('/Indicadores-edades',[CuentasporpagarController::class,'informeedades']);


//apis solicitudes compra
Route::get('/obtener-nombre-articulo/{itemCode}',[ComprasController::class,'obtenerDescripcionArticulo']);
Route::post('/generarSolicitudCompraAplicativo',[ComprasController::class,'GenerarSolicitudCompraBorrador']);
Route::any('/aprobar-solicitudcompragerencia/{id}/{usergerencia}', [ComprasController::class, 'Aprbacionessolicitudescompra']);
Route::any('/aprobar-solicitudcompragerenciaaplicacion/{id}/{usergerencia}', [ComprasController::class, 'Aprbacionessolicitudescompraaplicacion']);
Route::get('Solicitudes-compra-consultar',[ComprasController::class,'consultarSolicitudesCompra']);
Route::get('api/detalle-solicitud-compra/{id}', [ComprasController::class,'detalleSolicitudCompra']);
Route::post('/generarSolicitudCompradesdeAplicativo/{id}',[ComprasController::class,'generarsolicitudsapdesdeaplicacion']);
Route::any('/aprobar-solicitudcompragerenciaaplicacion/{id}/{usergerencia}', [ComprasController::class, 'Aprbacionessolicitudescompraaplicacion']);
Route::get('/obtener-detalles-solicitud/{id}',[ComprasController::class,'obtenerDetallesSolicitud']);
Route::post('/solicitud-compra-comentarios/{id}/actualizar-comentario', [ComprasController::class, 'actualizarComentario']);
Route::any('/rechazar-solicitudcompragerencia/{id}/{usergerencia}', [ComprasController::class, 'rechazarsolicitudescompra']);
Route::get('consultarDocEntryordenesVSAP/{ordenventarelacionada}', [ComprasController::class, 'consultarDocEntryordenesVSAP']);
Route::get('pruebaconsumoodbc', [ComprasController::class, 'pruebaconsumoodbc']);
Route::get('/detalle-solicitud-compra-seleccionado/{id}',[ComprasController::class,'detallesolicitudcompraseleccionado']);


//Modulo inventario departamento t.i

Route::post('GuardarLicencias', [LicenciasController::class, 'store']);
Route::put('ActualizarLicencia/{id}', [LicenciasController::class, 'actualizarLicencia']);
Route::delete('EliminarLicencia/{id}', [LicenciasController::class, 'eliminarLicencia']);
Route::put('v1/reset-password/{id}', [AuthController::class, 'resetUserPassword']);

Route::post('/generar-solicitud-compra', [AbastecimientoController::class, 'generarSolicitudCompraAPI']);

//seguimientos vortex
Route::post('Generar-seguimiento-cotizaciones/{idseguimiento}', [VorteController::class,'GenerarSeguimientoCotizacion']);
Route::get('seguimientos-vortex-obtener-comentarios/{id}',[VorteController::class,'obtenerseguimientos']);
// Seguimientos Estructuras metalicas

Route::post('Generar-seguimiento-estructuras/{idseguimiento}', [EstructuraMetalicaController::class,'GenerarSeguimientoCotizacion']);
Route::get('seguimientos-estructuras-obtener-comentarios/{id}',[EstructuraMetalicaController::class,'obtenerseguimientos']);

