<?php

use App\Http\Controllers\ListaEmpaquesController;
use Illuminate\Support\Facades\Route;

use App\Exports\SimpleExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    //return view('welcome');
	return redirect()->route('home');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    // PERFIL DE USUARIO -------------------------------------------------------------------------------------------------------------------------------	
        Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);//REVISAR ESTO
    
    
    //LISTA DE EMPAQUES
        Route::get('/home', 'App\Http\Controllers\ListaEmpaquesController@index')->name('home');

        Route::get('/lista_empaques', ['as' => 'lista_empaques.index', 'uses' => 'App\Http\Controllers\ListaEmpaquesController@index']);
        Route::get('/lista_empaques/{id}/show', ['as' => 'lista_empaques.show', 'uses' => 'App\Http\Controllers\ListaEmpaquesController@show']);
        Route::post('/lista_empaques/store', ['as' => 'lista_empaques.store', 'uses' => 'App\Http\Controllers\ListaEmpaquesController@store']);
        Route::post('/lista_empaques/{id}/update', ['as' => 'lista_empaques.update', 'uses' => 'App\Http\Controllers\ListaEmpaquesController@update']);
        Route::delete('/lista_empaques/{id}/delete', ['as' => 'lista_empaques.delete', 'uses' => 'App\Http\Controllers\ListaEmpaquesController@delete']);
        Route::get('/lista_empaques/{id}/documento_adjunto', ['as'=>'lista_empaques.documento', 'uses'=>'App\Http\Controllers\ListaEmpaquesController@ver_documento']);
    
    //EMPAQUES
        Route::get('/empaques', ['as' => 'empaque.index', 'uses' => 'App\Http\Controllers\EmpaqueController@index']);
        Route::post('/empaque/store', ['as' => 'empaque.store', 'uses' => 'App\Http\Controllers\EmpaqueController@store']);
        Route::post('/empaque/{id}/update', ['as' => 'empaque.update', 'uses' => 'App\Http\Controllers\EmpaqueController@update']);
        Route::delete('/empaque/{id}/delete', ['as' => 'empaque.delete', 'uses' => 'App\Http\Controllers\EmpaqueController@delete']);
    
    //MOVIMIENTOS
        Route::post('/movimiento/store', ['as' => 'movimiento.store', 'uses' => 'App\Http\Controllers\MovimientoController@store']);

    //PERSONAL
    
    //REPORTES
        Route::get('/reporte_listas', ['as' => 'reporte.listas', 'uses' => 'App\Http\Controllers\ReportesController@reporteListas']);
        Route::post('/reporte_listas', ['as' => 'reporte.listas', 'uses' => 'App\Http\Controllers\ReportesController@reporteListas']);

        Route::get('/reporte_empaques', ['as' => 'reporte.empaques', 'uses' => 'App\Http\Controllers\ReportesController@reporteEmpaques']);
        Route::post('/reporte_empaques', ['as' => 'reporte.empaques', 'uses' => 'App\Http\Controllers\ReportesController@reporteEmpaques']);

        Route::post('/reporteEmpaquesExcel', ['as' => 'reporte.empaques.excel', 'uses' => 'App\Http\Controllers\ReportesController@reporteEmpaquesExcel']);
        Route::post('/reporteListasExcel', ['as' => 'reporte.listas.excel', 'uses' => 'App\Http\Controllers\ReportesController@reporteListasExcel']);

        //reporte.empaques_movimiento
        Route::get('/reporte_empaques_detallado', ['as' => 'reporte.empaques_movimiento', 'uses' => 'App\Http\Controllers\ReportesController@reporteEmpaquesDetallado']);
        Route::post('/reporte_empaques_detallado', ['as' => 'reporte.empaques_movimiento', 'uses' => 'App\Http\Controllers\ReportesController@reporteEmpaquesDetallado']);

        Route::get('/reporte_egresos', ['as' => 'reporte.egresos', 'uses' => 'App\Http\Controllers\ReportesController@reporteEgresados']);
        Route::post('/reporte_egresos', ['as' => 'reporte.egresos', 'uses' => 'App\Http\Controllers\ReportesController@reporteEgresados']);
        
        
        Route::post('/reporteEgresadosExcel', ['as' => 'reporte.lista_egresos.excel', 'uses' => 'App\Http\Controllers\ReportesController@reporteEgresadosExcel']);

});




