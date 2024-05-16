<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\TenantsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')
->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])
->prefix('api/v1')->group(function () {

    Route::apiResource('usuarios', UserController::class);

    Route::prefix('ciudades')->group( function() {
        Route::get('/{depto}', [App\Http\Controllers\Api\v1\CiudadesController::class, 'byDepto']);
    });
    
    Route::apiResource('bancos', App\Http\Controllers\Api\v1\BancosController::class);
    Route::apiResource('colores', App\Http\Controllers\Api\v1\ColoresController::class);
    Route::apiResource('conceptos', App\Http\Controllers\Api\v1\ConceptosController::class);
    
    Route::prefix('clientes')->group( function() {
        Route::post('by-document/{cedula}', [App\Http\Controllers\Api\v1\ClientesController::class, 'byDocument']);
    });
    Route::apiResource('clientes', App\Http\Controllers\Api\v1\ClientesController::class);

    Route::prefix('facturas')->group( function() {
        Route::post('registrar/{id}', [App\Http\Controllers\Api\v1\FacturasController::class, 'registrar']);
    });
    Route::apiResource('facturas', App\Http\Controllers\Api\v1\FacturasController::class);
    
    Route::apiResource('gastos', App\Http\Controllers\Api\v1\GastosController::class);
    Route::apiResource('inventarios', App\Http\Controllers\Api\v1\InventariosController::class);
    Route::apiResource('medidas', App\Http\Controllers\Api\v1\MedidasController::class);
    Route::apiResource('proveedores', App\Http\Controllers\Api\v1\ProveedoresController::class);
    
    Route::prefix('productos')->group( function() {
        Route::get('referencia/{referencia}', [App\Http\Controllers\Api\v1\ProductosController::class, 'byReferencia']);
    });
    Route::apiResource('productos', App\Http\Controllers\Api\v1\ProductosController::class);
    
    Route::apiResource('tipo-clientes', App\Http\Controllers\Api\v1\TipoClientesController::class);
    Route::apiResource('detalles', App\Http\Controllers\Api\v1\DetallesController::class);
    Route::apiResource('recaudos', App\Http\Controllers\Api\v1\RecaudosController::class);

    Route::prefix('reportes')->group( function() {
        Route::prefix('inventario')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'inventario']);
        });
        Route::prefix('existencia_articulo')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'existencia_articulo']);
        });
        Route::prefix('articulos_vendidos')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'articulos_vendidos']);
        });
        Route::prefix('compras')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'compras']);
        });
        Route::prefix('gastos')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'gastos']);
        });
        Route::prefix('estado_cuenta_general')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'estado_cuenta_general']);
        });
        Route::prefix('estado_cuenta_cliente')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'estado_cuenta_cliente']);
        });
        Route::prefix('utilidad')->group( function() {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'utilidad']);
        });
    });
});


Route::group(['prefix' => 'v1'], function () {

    Route::apiResource('tenants', TenantsController::class);  


    Route::prefix('usuarios')->group( function() {
        Route::post('/get-admin', [UserController::class, 'getAdmin']);
    });
    // Route::apiResource('usuarios', UserController::class);

})->middleware(['auth:sanctum', 'verified']);
