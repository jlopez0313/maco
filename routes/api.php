<?php

use App\Http\Controllers\Api\v1\SoapController;
use App\Http\Controllers\Api\v1\DocumentoSoporteController;
use App\Http\Controllers\Api\v1\TenantsController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    'universal',
    InitializeTenancyByDomain::class,
])
->prefix('v1')->group(function () {
    Route::prefix('usuarios')->group(function () {
        Route::post('/get-admin', [UserController::class, 'getAdmin']);
    });
});

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])
->prefix('v1')->group(function () {
    Route::apiResource('usuarios', UserController::class);

    Route::post('login', [UserController::class, 'login']);

    Route::prefix('ciudades')->group(function () {
        Route::get('/{depto}', [App\Http\Controllers\Api\v1\CiudadesController::class, 'byDepto']);
    });

    Route::apiResource('bancos', App\Http\Controllers\Api\v1\BancosController::class);
    Route::apiResource('colores', App\Http\Controllers\Api\v1\ColoresController::class);
    Route::apiResource('conceptos', App\Http\Controllers\Api\v1\ConceptosController::class);
    Route::apiResource('credenciales', App\Http\Controllers\Api\v1\CredencialesController::class);
    Route::apiResource('impresiones', App\Http\Controllers\Api\v1\ImpresionesController::class);
    Route::apiResource('impuestos', App\Http\Controllers\Api\v1\ImpuestosController::class);

    Route::prefix('clientes')->group(function () {
        Route::post('by-document/{cedula}', [App\Http\Controllers\Api\v1\ClientesController::class, 'byDocument']);
    });
    Route::apiResource('clientes', App\Http\Controllers\Api\v1\ClientesController::class);

    Route::prefix('facturas')->group(function () {
        Route::post('registrar/{id}', [App\Http\Controllers\Api\v1\FacturasController::class, 'registrar']);
        Route::post('cierre', [App\Http\Controllers\Api\v1\FacturasController::class, 'cierre']);
    });
    Route::apiResource('facturas', App\Http\Controllers\Api\v1\FacturasController::class);

    Route::prefix('gastos')->group(function () {
        Route::post('registrar/{id}', [App\Http\Controllers\Api\v1\GastosController::class, 'registrar']);
        Route::post('cierre', [App\Http\Controllers\Api\v1\GastosController::class, 'cierre']);
    });
    Route::apiResource('gastos', App\Http\Controllers\Api\v1\GastosController::class);


    Route::apiResource('inventarios', App\Http\Controllers\Api\v1\InventariosController::class);
    Route::apiResource('medidas', App\Http\Controllers\Api\v1\MedidasController::class);
    Route::apiResource('proveedores', App\Http\Controllers\Api\v1\ProveedoresController::class);

    Route::prefix('productos')->group(function () {
        Route::get('referencia/{referencia}', [App\Http\Controllers\Api\v1\ProductosController::class, 'byReferencia']);
    });
    Route::apiResource('productos', App\Http\Controllers\Api\v1\ProductosController::class);    

    Route::apiResource('responsabilidades-fiscales', App\Http\Controllers\Api\v1\ResponsabilidadesFiscalesController::class);
    Route::apiResource('tipo-clientes', App\Http\Controllers\Api\v1\TipoClientesController::class);
    Route::apiResource('tipo-documentos', App\Http\Controllers\Api\v1\TipoDocumentosController::class);
    Route::apiResource('unidades-medida', App\Http\Controllers\Api\v1\UnidadesMedidaController::class);
    Route::apiResource('formas-pago', App\Http\Controllers\Api\v1\FormasPagoController::class);
    Route::apiResource('medios-pago', App\Http\Controllers\Api\v1\MediosPagoController::class);
    Route::apiResource('detalles', App\Http\Controllers\Api\v1\DetallesController::class);
    Route::apiResource('empresas', App\Http\Controllers\Api\v1\EmpresasController::class);
    Route::apiResource('recaudos', App\Http\Controllers\Api\v1\RecaudosController::class);

    Route::prefix('consecutivos')->group(function () {
        Route::get('/first/{from}', [App\Http\Controllers\Api\v1\ConsecutivosController::class, 'first']);
    });
    Route::apiResource('consecutivos', App\Http\Controllers\Api\v1\ConsecutivosController::class);

           
    Route::prefix('contactos')->group(function () {
        Route::get('empresa/{empresa}', [App\Http\Controllers\Api\v1\ContactosController::class, 'byEmpresa']);
        Route::get('cliente/{cliente}', [App\Http\Controllers\Api\v1\ContactosController::class, 'byCliente']);
        Route::get('proveedor/{proveedor}', [App\Http\Controllers\Api\v1\ContactosController::class, 'byProveedor']);
    });
    Route::apiResource('contactos', App\Http\Controllers\Api\v1\ContactosController::class);

    
    Route::prefix('autorizaciones')->group(function () {
        Route::get('empresa/{empresa}', [App\Http\Controllers\Api\v1\AutorizacionesController::class, 'byEmpresa']);
        Route::get('consecutivo/{empresa}', [App\Http\Controllers\Api\v1\AutorizacionesController::class, 'consecutivo']);
    });
    Route::apiResource('autorizaciones', App\Http\Controllers\Api\v1\AutorizacionesController::class);


    Route::prefix('resoluciones')->group(function () {
        Route::get('empresa/{empresa}', [App\Http\Controllers\Api\v1\ResolucionesController::class, 'byEmpresa']);
        Route::get('consecutivo/{empresa}', [App\Http\Controllers\Api\v1\ResolucionesController::class, 'consecutivo']);
    });
    Route::apiResource('resoluciones', App\Http\Controllers\Api\v1\ResolucionesController::class);


    Route::prefix('reportes')->group(function () {
        Route::prefix('inventario')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'inventario']);
        });
        Route::prefix('existencia_articulo')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'existencia_articulo']);
        });
        Route::prefix('articulos_vendidos')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'articulos_vendidos']);
        });
        Route::prefix('ventas')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'ventas']);
        });
        Route::prefix('gastos')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'gastos']);
        });
        Route::prefix('estado_cuenta_general')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'estado_cuenta_general']);
        });
        Route::prefix('estado_cuenta_cliente')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'estado_cuenta_cliente']);
        });
        Route::prefix('utilidad')->group(function () {
            Route::post('/', [App\Http\Controllers\Api\v1\ReportesController::class, 'utilidad']);
        });
    });

    Route::prefix('soap')->group(function () {
        Route::get('generarNumeracion', [SoapController::class, 'generarNumeracion']);
        Route::get('consultaNumeracion', [SoapController::class, 'consultaNumeracion']);
        Route::get('actualizarNumTipoDocumento', [SoapController::class, 'actualizarNumTipoDocumento']);
        Route::get('upload/{id}', [SoapController::class, 'upload']);
        Route::get('status/{id}', [SoapController::class, 'status']);
        Route::get('download/{id}', [SoapController::class, 'download']);
        // Route::get('upload', [SoapController::class, 'upload']);
        // Route::get('upload', [SoapController::class, 'upload']);
    });

    
    Route::prefix('documento_soporte')->group(function () {
        Route::get('generarNumeracion', [DocumentoSoporteController::class, 'generarNumeracion']);
        Route::get('consultaNumeracion', [DocumentoSoporteController::class, 'consultaNumeracion']);
        Route::get('actualizarNumTipoDocumento', [DocumentoSoporteController::class, 'actualizarNumTipoDocumento']);
        Route::get('upload/{id}', [DocumentoSoporteController::class, 'upload']);
        Route::get('status/{id}', [DocumentoSoporteController::class, 'status']);
        Route::get('download/{id}', [DocumentoSoporteController::class, 'download']);
        // Route::get('upload', [SoapController::class, 'upload']);
        // Route::get('upload', [SoapController::class, 'upload']);
    });
});

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('tenants', TenantsController::class);
})->middleware(['auth:sanctum', 'verified']);
