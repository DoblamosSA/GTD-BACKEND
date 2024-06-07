<?php

use App\Http\Controllers\CotizacionEstructuraController;
use App\Http\Controllers\EstructuraMetalicaController;
use App\Http\Controllers\VorteController;
use App\Http\Controllers\LlamadasServicioSAPController;
use App\Http\Controllers\FachadaController;
use App\Models\CotizacionEstructura;
use App\Http\Controllers\Clientescontroller;
use App\Http\Controllers\ClientesSAPController;
use App\Http\Controllers\ApiClientesSAP;
use App\Http\Controllers\HomeController;
use App\Utils\RolesNames;
use App\Http\Controllers\VortexController;
use App\Models\ClientesSAP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DepartamentoTI\InventarioController;
use App\Http\Controllers\DepartamentoTI\Licencias\LicenciasController;
/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

//Ver imagen
Route::get('storage/{filename?}', function ($filename  = null) {
    try {
        if (!empty($filename)) {
            $path = storage_path('app/' . "public/documents" . "/" . $filename);
            if (!File::exists($path)) {
                return false;
            }
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        }
    } catch (Throwable $e) {
    }
})->name('storage');


Route::middleware(['auth'])->group(function () {

     Route::get('/home',[HomeController::class,'index']);

    Route::namespace('App\Http\Controllers\InformePartesMagnetica')->prefix('informe-partes-magneticas')
        ->name('informe-partes-magneticas.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');
        });

    Route::namespace('App\Http\Controllers\InformeLiquidoPenetrante')->prefix('informe-liquidos-penetrante')
        ->name('informe-liquidos-penetrante.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');
        });

    Route::namespace('App\Http\Controllers\InformeUltrasonido')->prefix('informe-ultrasonido')
        ->name('informe-ultrasonido.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');
        });

    Route::namespace('App\Http\Controllers\InformeVertMetalica')->prefix('informe-vert-metalica')
        ->name('informe-vert-metalica.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::put('/destroy/{id}', 'PageController@destroy')->name('destroy');
        });

    Route::namespace('App\Http\Controllers\JuntasInformeLiquidosPenetrante')->prefix('juntas-informe-liquidos-penetrantes')
        ->name('juntas-informe-liquidos-penetrantes.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');

            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByInfLiquidosPenetrantes/{id}', 'PageController@api_getByInfLiquidosPenetrantes')->name('api_getByInfLiquidosPenetrantes');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

    Route::namespace('App\Http\Controllers\JuntasInformePartesMagneticas')->prefix('juntas-informe-partes-magneticas')
        ->name('juntas-informe-partes-magneticas.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');

            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByInfParticulaMagnetica/{id}', 'PageController@api_getByInfParticulaMagnetica')->name('api_getByInfParticulaMagnetica');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

    Route::namespace('App\Http\Controllers\JuntasInformeUltrasonido')->prefix('juntas-informe-ultrasonido')
        ->name('juntas-informe-ultrasonido.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');

            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByInformeId/{id}', 'PageController@api_getByInformeId')->name('api_getByInformeId');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

    Route::namespace('App\Http\Controllers\JuntasInformeVertMetalica')->prefix('juntas-informe-vert-metalica')
        ->name('juntas-informe-vert-metalica.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');

            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByInfVertMetalica/{id}', 'PageController@api_getByInfVertMetalica')->name('api_getByInfVertMetalica');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

        Route::namespace('App\Http\Controllers\DatosJuntasInformeUltrasonido')->prefix('datos-juntas-informe-ultrasonido')
        ->name('datos-juntas-informe-ultrasonido.')->group(function () {
            Route::get('/index', 'PageController@index')->name('index');
            Route::get('/edit/{id}', 'PageController@edit')->name('edit');
            Route::get('/show/{id}', 'PageController@show')->name('show');
            Route::get('/create', 'PageController@create')->name('create');
            Route::post('/store', 'PageController@store')->name('store');
            Route::patch('/update/{id}', 'PageController@update')->name('update');
            Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy');

            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByJuntaId/{id}', 'PageController@api_getByJuntaId')->name('api_getByJuntaId');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

    Route::namespace('App\Http\Controllers\Reportes')->prefix('reportes-pdf')
        ->name('reportes-pdf.')->group(function () {
            Route::get('/partes-magneticas/{id}', 'PageController@partes_magneticas')->name('partes-magneticas');
            Route::get('/liquidos-penetrante/{id}', 'PageController@liquidos_penetrante')->name('liquidos-penetrante');
            Route::get('/ultrasonido/{id}', 'PageController@ultrasonido')->name('ultrasonido');
            Route::get('/vert-metalica/{id}', 'PageController@ver_metalica')->name('vert-metalica');
        });

    // Route::namespace('App\Http\Controllers')->prefix('home')
    //     ->name('home.')->group(function () {
    //         // Route::get('/', 'HomeController@index')->name('index');
    //         Route::get('/inicio', 'HomeController@inicio')->name('inicio');
    //     });

    Route::namespace('App\Http\Controllers\InformePartesMagnetica')->prefix('home')
        ->name('home.')->group(function () {
            // Route::get('/', 'HomeController@index')->name('index');
            Route::get('/index', 'PageController@index')->name('index');
        });

    Route::namespace('App\Http\Controllers\Admin')->prefix('admin')
    ->middleware(['role:' . RolesNames::$administrador])
        ->name('admin.')->group(function () {
            // Route::get('/', 'PageController@index')->name('index');
            Route::get('/list_users', 'PageController@list_users')->name('list_users');
            Route::get('/edit_user/{id}', 'PageController@edit_user')->name('edit_user');
            Route::get('/create_user', 'PageController@create_user')->name('create_user');
            Route::post('/store_user', 'PageController@store_user')->name('store_user');
            Route::patch('/update_user/{id}', 'PageController@update_user')->name('update_user');
            Route::get('/disable_user/{id}', 'PageController@disable_user')->name('disable_user');
            Route::get('/enable_user/{id}', 'PageController@enable_user')->name('enable_user');
            Route::get('/delete_user/{id}', 'PageController@delete_user')->name('delete_user');            
            Route::get('/edit_password/{id}', 'PageController@edit_password')->name('edit_password');
            Route::patch('/change_password/{id}', 'PageController@change_password')->name('change_password');
        });

    Route::namespace('App\Http\Controllers\ProfileUser')->prefix('profile_user')
        ->name('profile_user.')->group(function () {
            Route::get('/data_profile', 'PageController@data_profile')->name('data_profile');
            Route::post('/update_data_profile', 'PageController@update_data_profile')->name('update_data_profile');
            Route::get('/change_password', 'PageController@change_password')->name('change_password');
            Route::post('/update_password', 'PageController@update_password')->name('update_password');
            Route::post('/update_signature_image', 'PageController@update_signature_image')->name('update_signature_image');
        });

        Route::namespace('App\Http\Controllers\JuntasLiquidosPenetrantesImagenes')->prefix('juntas-liquidos-penetrantes-imagenes')
        ->name('juntas-liquidos-penetrantes-imagenes.')->group(function () {
            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByIdJunta/{id}', 'PageController@api_getByIdJunta')->name('api_getByIdJunta');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

        Route::namespace('App\Http\Controllers\JuntasPartesMagneticasImagenes')->prefix('juntas-partes-magneticas-imagenes')
        ->name('juntas-partes-magneticas-imagenes.')->group(function () {
            Route::get('/api_getById/{id}', 'PageController@api_getById')->name('api_getById');
            Route::get('/api_getByIdJunta/{id}', 'PageController@api_getByIdJunta')->name('api_getByIdJunta');
            Route::post('/api_add_update', 'PageController@api_add_update')->name('api_add_update');
            Route::post('/api_add', 'PageController@api_add')->name('api_add');
            Route::post('/api_update', 'PageController@api_update')->name('api_update');
            Route::post('/api_delete/{id}', 'PageController@api_delete')->name('api_delete');
        });

    // Route::namespace('App\Http\Controllers\FileAdmin')->prefix('file_admin')
    //     ->name('file_admin.')->group(function () {
    //         Route::get('/getByIdJunta/{id_junta}', 'PageController@getByIdJunta')->name('getByIdJunta');
    //         Route::post('/store-file', 'PageController@store')->name('store-file');
    //     });


    
    //Rutas ingenieria estructuras metalicas
        Route::get('/index',[CotizacionEstructuraController::class,'index'])->name('cotizacion.index');
        Route::get('/cotizacion/create',[CotizacionEstructuraController::class,'create'])->name('cotizacion.create');
        Route::post('cotizacion/store',[CotizacionEstructuraController::class,'store'])->name('cotizacion.store');
        Route::put('/cotizacion/destroy/{id}', [CotizacionEstructuraController::class, 'destroy'])->name('cotizacion.destroy');
        Route::patch('/cotizaciones/update/{id}', [CotizacionEstructuraController::class, 'update'])->name('cotizaciones.update');
        Route::get('/cotizacion/edit/{id}',[CotizacionEstructuraController::class,'edit'])->name('cotizacion.edit');
        Route::get('cotizacion',[CotizacionEstructuraController::class,'import'])->name('cotizacion.import');
        Route::post('cotizacion',[CotizacionEstructuraController::class,'importStore'])->name('cotizacion.importStore');
        Route::get('/export', [CotizacionEstructuraController::class, 'exportExcel'])->name('export.export');



//Rutas Formaletas
        Route::get('/cotizaciones-formaletas',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'index'])->name('cotizaciones-formaletas.index');
        Route::get('/cotizaciones-formaletas/create',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'create']);
 	Route::get('Historico-formaletas',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'historicoformaleta']);
        Route::post('Historico-formaletas',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'upload']);
        Route::post('/cotizaciones-formaletas/store',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'store'])->name('cotizaciones-formaletas.store');
        Route::get('/buscar-cliente-SAP-Prueba',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'ConsultarClienteSAPPrueba']);
        Route::put('/cotizaciones-formaletas/destroy/{id}', [App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class, 'destroy'])->name('cotizaciones-formaletas.destroy');
        Route::get('/cotizaciones-formaletas/edit/{id}',[App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class,'edit'])->name('cotizaciones-formaletas.edit');
        Route::patch('/cotizaciones-formaleta/update/{id}', [App\Http\Controllers\Cotizaciones_Formaletas\CotizacionesController::class, 'update'])->name('cotizaciones-formaleta.update');
		 Route::get('Cotizaciones-formaletas-Indicadores',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'Indicadores']);
       


//Indicadore Formaletas
       Route::get('/ventas-mes-seguimientoFor-ajax/{seguimientosano}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'obtenerVentasMesseguimientoAjax']);
    Route::get('/ventas-mes-ajaxFor/{anios}',[ App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'obtenerVentasMesAjax']);
    Route::get('/coti-mes-tipologia-seguimiforaletas-ajax/{anio}/{tipologiaseguimiento}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'obtenerVenTipolSeguimiformaletajax']);
    Route::get('/ventas-mes-tipologia-ajaxforma/{anio}/{tipologia}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'obtenerVentasTipologiaAjax']);
    Route::get('/VentasGeneralesTipologiaformaletas/{anio}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'GraficoTipologiasGeneralesAjax']);
    Route::get('/CotizacionesGeneralesTipologiaFormaletas/{anio}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'GraficoTipologiasGeneralesCotizacionesAjax']);
    Route::get('VentasOrigenesFormaletas/{anio}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'GraficoVentasOrigenAjax']);
    Route::get('/Ventas-mes-pais-seguimiento-forma/{anio}/{mes}',[App\Http\Controllers\IndicadoreFormaletas\IndicadoresForController::class,'obtenerVentasPaisSeguimientoAjax']);
	
    // Rutas vortex

    Route::get('/vortexDoblamos', [VorteController::class, 'index'])->name('vortexDoblamos.index');
    Route::get('/vortexDoblamos/create',[VorteController::class, 'create'])->name('vortexDoblamos.create');
    Route::post('/vortexDoblamos/store',[VorteController::class, 'store'])->name('vortexDoblamos.store');
    Route::get('/vortexDoblamos/edit/{id}',[VorteController::class,'edit'])->name('vortexDoblamos.edit');
    Route::PATCH('/vortexDoblamos/update/{id}',[Vortecontroller::class,'update'])->name('vortexDoblamos.update');
    Route::get('/vortex', [Vortecontroller::class, 'exportExcelvortex'])->name('vortex.export');
    Route::put('/vortex/destroy/{id}',[Vortecontroller::class,'destroy'])->name('vortex.destroy');
  Route::get('/buscar-cliente',[VorteController::class,'BuscarCliente']);
 Route::get('vortexDoblamos/Historico',[VorteController::class,'HistoricoCotizaciones']);
   Route::post('vortexDoblamos/cotizacionesHistoricas',[VorteController::class,'upload']);
Route::get('Seguimientos-vortex',[VorteController::class,'seguimiento']);

 Route::get('/Indicadores-Vortex',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'Indicadores'])->name('vortex.Indicadores');
 Route::get('/Indicadores-vortex-mes/{anios?}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'Indicadores']);
 Route::get('/ventas-mes-ajax/{anios}',[ App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasMesAjax']);
 Route::get('/ventas-mes-seguimiento-ajax/{seguimientosano}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasMesseguimientoAjax']);
Route::get('/ventas-mes-tipologia-ajax/{anio}/{tipologia}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasTipologiaAjax']);
Route::get('/ventas-mes-tipologia-seguimiento-ajax/{anio}/{tipologiaseguimiento}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasTipologiaSeguimientoajax']);
Route::get('/Ventas-mes-pais/{anio}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasPaisAjax']);
Route::get('/Ventas-mes-pais-seguimiento/{anio}/{mes}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'obtenerVentasPaisSeguimientoAjax']);
Route::get('/VentasGeneralesTipologia/{anio}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'GraficoTipologiasGeneralesAjax']);
Route::get('/CotizacionesGeneralesTipologia/{anio}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'GraficoTipologiasGeneralesCotizacionesAjax']);
Route::get('VentasOrigenes/{anio}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'GraficoVentasOrigenAjax']);
Route::get('/Costos-nocalidad-vortex/{anio}',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'costosnocalidadajax']);
Route::get('/VentasAsesor/{anio}/{mes}', [App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class, 'VentasAsesorAjax']);
Route::get('VentasAsesorSeguimiento/{anio}/{mes}',[\App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'VentasAsesorSeguimientoAjax']);
Route::get('/MetrosCuadrados/{anio}',[\App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'consultaMetrosCuadradosPorMesAjax']);
Route::get('/Porcentaje-Exito-cotizaciones/{anio}',[\App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'calcularPorcentajeExitoVentas']);

    //pais longitud y latitud
    Route::get('Paises-Geocalizacion',[App\Http\Controllers\IndicadoresVortex\Indicadoresvorte::class,'PaisGeocalizacion']);

//Estructuras Metalicas

Route::get('/estructurasMetalicas',[EstructuraMetalicaController::class,'index'])->name('estructurasMetalicas.index');
Route::get('/estructurasMetalicas/create',[EstructuraMetalicaController::class,'create'])->name('estructurasMetalicas.create');
Route::post('/estructurasMetalicas',[EstructuraMetalicaController::class,'store'])->name('estructurasMetalicas.store');
Route::get('/estructurasMetalicas/edit/{id}',[EstructuraMetalicaController::class,'edit'])->name('estructurasMetalicas.edit');
Route::patch('/estructurasMetalicas/update/{id}',[EstructuraMetalicaController::class,'update'])->name('estructurasMetalicas.update');
Route::put('/destroy/{id}',[EstructuraMetalicaController::class,'destroy'])->name('estructurasMetalicas.destroy');
Route::get('/estructurasMetalicas/export',[EstructuraMetalicaController::class,'exportExcelEstr'])->name('estructurasMetalicas.export');
Route::get('/estructurasMetalicas/import',[EstructuraMetalicaController::class,'importExcel'])->name('estructurasMetalicas.import');
Route::post('/estructurasMetalicas-import',[EstructuraMetalicaController::class,'impStore'])->name('estructurasMetalicas-import.impStore');



//Rutas Clientes SAP

Route::get('/ClientesSap',[ClientesSAPController::class,'index'])->name('ClientesSap.index');
Route::get('/ClientesSAP',[ClientesSAPController::class,'create'])->name('ClientesSap.create');
Route::post('ClientesSAP/RegistroSAP',[ClientesSAPController::class,'RegistroClienteSAP'])->name('ClientesSAP.RegistroClienteSAP');
Route::get('Clientes/sql',[ClientesSAPController::class,'RegistroClienteBD'])->name('Clientes.RegistroClienteBD');



//CNC

Route::get('/Costo-No-Calidad',[App\Http\Controllers\CNC\CostosnocalidadController::class,'index'])->name('Costo-No-Calidad.index');
Route::post('Costo-No-Calidad',[App\Http\Controllers\CNC\CostosnocalidadController::class,'store'])->name('Costo-No-Calidad.store');
Route::get('/Coso-No-Calidad',[App\Http\Controllers\CNC\CostosnocalidadController::class,'create'])->name('Coso-No-Calidad.create');
Route::get('Costo-No-Calidad/edit/{id}',[App\Http\Controllers\CNC\CostosnocalidadController::class,'edit'])->name('Costo-No-Calidad.edit');
Route::patch('Costo-No-Calidad/update/{id}',[App\Http\Controllers\CNC\CostosnocalidadController::class,'update'])->name('Costo-No-Calidad.update');
Route::put('Costo-No-Calidad/destroy/{id}',[App\Http\Controllers\CNC\CostosnocalidadController::class,'destroy'])->name('Costo-No-Calidad.destroy');
Route::get('/Costo-No-Calidad/export',[App\Http\Controllers\CNC\CostosnocalidadController::class,'exportcnc'])->name('Costo-No-Calidad.export');
Route::get('/Costo-No-Calidad/Informe/{id}',[App\Http\Controllers\CNC\CostosnocalidadController::class,'Informecnc'])->name('Costo-No-Calidad.Informecnc');
Route::get('Costo-No-Calidad/Indicadores',[App\Http\Controllers\CNC\CostosnocalidadController::class,'Indicadores'])->name('Costo-No-Calidad.Indicadores');
Route::post('Costo-No-Calidad/Indicadores',[App\Http\Controllers\CNC\CostosnocalidadController::class,'Indicadores'])->name('Costo-No-Calidad.IndicadoresC');
Route::get('Costo-No-Calidad/duplicar/{id}',[App\Http\Controllers\CNC\CostosnocalidadController::class,'duplicate'])->name('Costo-No-Calidad.duplicate');
Route::get('/llamada-Servicio',[App\Http\Controllers\IntegracionSAP\LlamadasServicioSAPController::class,'ConsultarLlamadaServicio'])->name('llamada-Servicio.ConsultarLlamadaServicio');
Route::get('/costo-no-calidad/search', [App\Http\Controllers\CNC\CostosnocalidadController::class,'search'])->name('costo-no-calidad.search');
Route::get('/CNC-COSTEADOS',[App\Http\Controllers\CNC\CostosnocalidadController::class,'cnccosteados']);



//importacion masiva SAP
Route::get('Empleados-SAP',[App\Http\Controllers\IntegracionSAP\EmpleadosSAPController::class,'EmpleadosSAP']);

Route::post('LLamadaServicio/RegistroSAP',[App\Http\Controllers\IntegracionSAP\LlamadasServicioSAPController::class,'GuardarCNCSAP']);


//Areas

Route::get('/Areas',[App\Http\Controllers\Areas\Areacontroller::class,'index'])->name('Areas.index');
Route::post('/Areas',[App\Http\Controllers\Areas\Areacontroller::class,'store'])->name('Areas.store');

//Asesores:

Route::get('/Asesores',[\App\Http\Controllers\Asesores\Asesorcontroller::class,'index'])->name('Asesores.index');
Route::post('/Asesores/store',[\App\Http\Controllers\Asesores\Asesorcontroller::class,'store'])->name('Asesores.store');
Route::put('/Asesores/destroy/{id}',[\App\Http\Controllers\Asesores\Asesorcontroller::class,'destroy'])->name('Asesores.destroy');
Route::put('/asesores/{id}', [\App\Http\Controllers\Asesores\Asesorcontroller::class, 'update']);



//materiales

Route::get('Materiales',[App\Http\Controllers\MaterialesSAP\MaterialesController::class, 'index'])->name('Materiales.index');
Route::get('Materiales-SAP',[\App\Http\Controllers\MaterialesSAP\MaterialesController::class,'materialesEstandarSAPbd']);
Route::get('Materiales-consumibles',[App\Http\Controllers\MaterialesSAP\ConsumiblesController::class, 'index']);
Route::get('Materiales-consumible',[App\Http\Controllers\MaterialesSAP\ConsumiblesController::class, 'GuardarConsumiblesSAPbd']);



//Recursos SAP

Route::get('Recursos',[\App\Http\Controllers\RecursosSAP\RecursosSAPController::class,'index']);
Route::get('Recursos-SAP',[\App\Http\Controllers\RecursosSAP\RecursosSAPController::class,'GuardarRecursosSAP']);



//Calculadorcnc

Route::get('CalculadorCNC/{id}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'index'])->name('CalculadorCNC.index');
Route::post('CalculadorCNC/store',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'store'])->name('CalculadorCNC.store');
Route::get('/get-calibres/{laminaId}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getCalibres']);
Route::get('/get-calibresmrecuperado/{laminaId}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getCalibres']);
Route::get('/recursos/{id}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getRecurso']);
Route::get('/material-recuperado-chatarra/{id}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'MateriaRecuperadoChatarra']);
Route::get('/material-recuperado-materia-prima/{laminaId}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getCalibresMaterialrecuperadoMp']);
Route::get('/get-precio/{calibreId}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getPrecio']);
Route::get('/get-transporte/{codigo}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'getTransporteLogistico']);



//Calibres

Route::get('Calibres',[App\Http\Controllers\Calibres\CalibresController::class,'index'])->name('Calibres.index');
Route::post('Calibres/store',[App\Http\Controllers\Calibres\CalibresController::class,'store']);
Route::PUT('Calibres/destroy/{id}',[App\Http\Controllers\Calibres\CalibresController::class,'destroy'])->name('Calibres.destroy');
Route::put('calibres/update/{id}',[App\Http\Controllers\Calibres\CalibresController::class,'update'])->name('calibres.update');



//laminas
Route::get('Laminas',[App\Http\Controllers\Laminas\LaminasController::class,'index'])->name('Laminas.index');
Route::get('Laminas/create',[App\Http\Controllers\Laminas\LaminasController::class,'create'])->name('Laminas.create');
Route::post('Laminas/store',[App\Http\Controllers\Laminas\LaminasController::class,'store']);
//Route::PUT('Laminas/destroy/{id}',[App\Http\Controllers\Laminas\LaminasController::class,'destroy'])->name('Laminas.destroy');
Route::get('Laminas/edit/{id}',[App\Http\Controllers\Laminas\LaminasController::class,'edit'])->name('Laminas.edit');
Route::put('Laminas/{id}', [App\Http\Controllers\Laminas\LaminasController::class, 'update'])->name('Laminas.update');
Route::delete('Laminas/destroy/{id}', [App\Http\Controllers\Laminas\LaminasController::class, 'destroy'])->name('Laminas.destroy');


Route::get('get-bodegas',[App\Http\Controllers\Laminas\LaminasController::class,'getbodegaslaminas']);

//Importar bodegas:
Route::get('Bodegas-SAP',[App\Http\Controllers\BodegasSAP\BodegasSAPController::class,'GuardarBodegasbd']);


Route::get('obtener-materiales/{bodega}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'obtenerMaterialesPorBodega']);
Route::get('obtener-precio/{material}',[App\Http\Controllers\CalculadorCNC\CalculadorController::class,'obtenerPrecioPorMaterial']);


Route::get('Trasporte',[App\Http\Controllers\TransporteDoblamos\TransporteController::class,'index'])->name('Transaporte.index');
Route::post('Transporte',[App\Http\Controllers\TransporteDoblamos\TransporteController::class,'store'])->name('Transporte.store');
Route::delete('Transporte/{id}', [App\Http\Controllers\TransporteDoblamos\TransporteController::class, 'destroy'])->name('Transporte.destroy');
Route::put('Transporte/{id}', [App\Http\Controllers\TransporteDoblamos\TransporteController::class, 'update'])->name('Transporte.update');


//Analisis de venta SAP

Route::get('Analisis_venta',[App\Http\Controllers\IntegracionSAP\AnalisisVentaController::class,'Index']);
Route::get('Analisis_ventavor',[App\Http\Controllers\IntegracionSAP\AnalisisVentaVorteController::class,'Index']);

//Routes modulo finanzas modulo facture.
Route::get('Modulo-finanzas',[App\Http\Controllers\ModuloFinanzas\ModuloFacture\SolicitudCompraController::class,'index']);
Route::get('Ordenes-Compra-SAP',[App\Http\Controllers\ModuloFinanzas\ModuloFacture\PedidoCompraController::class,'index']);



Route::get('Modulo-Finanzas',[App\Http\Controllers\ModuloFinanzas\ModuloFacture\PedidoCompraController::class,'pedidocompra']);


//logistica
Route::get('Logistica',[App\Http\Controllers\Logistica\LogisticaController::class,'index']);
Route::get('Log_revalorizaciones_sap',[App\Http\Controllers\Logistica\CostoProductosController::class,'Log_Revalorizaciones_SAP']);


//Administrador
Route::get('Usuarios',[App\Http\Controllers\AuthController::class,'usuarios']);
Route::get('Usuarios-registrar',[App\Http\Controllers\AuthController::class,'registrarusuarios']);
Route::get('Roles',[App\Http\Controllers\AuthController::class,'roles']);
Route::get('Permisos',[App\Http\Controllers\PermissionController::class,'index'])->name('permisos.index');
Route::get('usuarios-edit/{id}',[App\Http\Controllers\AuthController::class,'editarusuarios']);



//Rutas departamento t.i
Route::get('checkList',[App\Http\Controllers\DepartamentoTI\CheckListController::class,'index']);
Route::post('Tareas-TI',[App\Http\Controllers\DepartamentoTI\CheckListController::class,'TareasPendientes']);

Route::post('clientes/ferias',[ClientesSAPController::class,'upload']);

//portal clientes
Route::get('Portal-Clientes-Doblamos',[App\Http\Controllers\PortalClientes\PortalClientesController::class,'Portal']);
Route::get('Solicitud-credito',[App\Http\Controllers\PortalClientes\PortalClientesController::class,'solicredito']);
Route::get('Gestion-Cartera',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'index']);
Route::get('Solicitudes-creditos',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'solicitudesCreditoNuevas']);
Route::get('Solicitudes-creditos-aprobadas',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'solicitudesCreditoaprobadas']);
Route::get('Solicitudes-creditos-rechazadas',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class,'Solicitudesrechazadas']);
Route::get('/descargar-archivo/{nombreArchivo}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'descargarArchivo'])->name('descargar.archivo');
Route::get('/ver-documento/{nombreArchivo}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'verDocumento'])
    ->name('ver.documento');
Route::get('Informes-doblamos-cartera',[App\Http\Controllers\ModuloFinanzas\ModuloCartera\CuentasporpagarController::class,'InformesDoblamos']);


Route::get('/descargar-archivo/cartera/{nombreArchivo}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'descargarArchivocartera']); 
Route::get('/ver-documento/cartera/{nombreArchivo}', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'verDocumentocartera'])
->name('ver.documento-cartera'); 


//MRP SAP
Route::get('Abastecimiento_MRP_SAP',[App\Http\Controllers\Logistica\AbastecimientoMRPSAP\AbastecimientoController::class,'Abastecimiento_MRP_SAP']);
Route::get('Abastecimiento_MRP_SAP_ALMACEN',[App\Http\Controllers\Logistica\AbastecimientoMRPSAP\Abastecimiento_MRP_ALMACENController::class,'Abastecimiento_MRP_SAP_Almacen']);


//modulo solicitudes de compra
Route::get('Solicitud-Compras',[App\Http\Controllers\Compras\ComprasController::class,'VistaPrincipal']);
Route::get('Solicitud-Compras-aplicativo',[App\Http\Controllers\Compras\ComprasController::class,'SolicitudesCreditoaplicativo']);
Route::get('Solicitudes-compra-aprobar', [App\Http\Controllers\Compras\ComprasController::class, 'SolicitudesAprobardesdeaplicacion']);
Route::get('ver-anexos-solicitudes-compra/{nombreArchivo}', [App\Http\Controllers\Compras\ComprasController::class, 'veranexossolicitudescompra']);
    


Route::get('Inventario-TI',[InventarioController::class,'index']);
Route::get('Licencias',[LicenciasController::class,'index']);
});






Route::post('/checklist', [App\Http\Controllers\DepartamentoTI\CheckListController::class, 'store'])->name('checklist.store');

Route::get('pruebaevent', function () {
    event(new NuevaSolicitudCreditoEvent);
    return 'field';
});

Route::get('/enviar-correo-prueba', [App\Http\Controllers\ModuloFinanzas\ModuloCartera\SolicitudesCreditoController::class, 'enviarCorreoPrueba']);
Route::get('/prueba-conexion-hanna', [App\Http\Controllers\ConexionBDHannaSAPController::class,'prueba']);

Route::get('vista-return-aprobacion-gerencia', [SolicitudesCreditoController::class, 'Vistaaprobogerencia'])->name('vista-return-aprobacion-gerencia.Vistaaprobogerencia');
Route::get('vista-return-rechazo-gerencia', [SolicitudesCreditoController::class, 'Vistaarechazogerencia'])->name('vista-return-rechazo-gerencia.Vistaarechazogerencia');

