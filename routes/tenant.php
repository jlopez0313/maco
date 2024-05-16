<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Inertia\Inertia;

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\RecaudosController;
use App\Http\Controllers\TiposClientesController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\ConceptosController;
use App\Http\Controllers\MedidasController;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])
->prefix('v1')->group(function () {

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


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => false,
            'laravelVersion' => '1.0.0',
        ]);
    });
    
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    
    Route::prefix('parametros')->group( function() {
        
        Route::get('/', function () {
            return Inertia::render('Parametros/Index');
        })->name('parametros');

        Route::prefix('usuarios')->group( function() {
            Route::get('/', [UserController::class, 'index'])->name('parametros.usuarios');
        });
    
        Route::prefix('tipos_clientes')->group( function() {
            Route::get('/', [TiposClientesController::class, 'index'])->name('parametros.tipos');
        });
    
        Route::prefix('conceptos')->group( function() {
            Route::get('/', [ConceptosController::class, 'index'])->name('parametros.conceptos');
        });
    
        Route::prefix('bancos')->group( function() {
            Route::get('/', [BancosController::class, 'index'])->name('parametros.bancos');
        });
    
        Route::prefix('medidas')->group( function() {
            Route::get('/', [MedidasController::class, 'index'])->name('parametros.medidas');
        });
    
        Route::prefix('colores')->group( function() {
            Route::get('/', [ColoresController::class, 'index'])->name('parametros.colores');
        });
    
    
    })->middleware(['auth', 'verified']);
    
    
    Route::prefix('clientes')->group( function() {
        Route::get('/', [ClientesController::class, 'index'])->name('clientes');   
    })->middleware(['auth', 'verified']);
    
    
    Route::prefix('proveedores')->group( function() {
        Route::get('/', [ProveedoresController::class, 'index'])->name('proveedores');    
    })->middleware(['auth', 'verified']);
    
    
    Route::prefix('remisiones')->group( function() {
        Route::get('/', [FacturasController::class, 'index'])->name('remisiones');
        Route::get('/show/{id}', [FacturasController::class, 'show'])->name('remisiones.show');
        Route::get('/edit/{id}', [FacturasController::class, 'edit'])->name('remisiones.edit');
        Route::get('/pdf/{id}', [FacturasController::class, 'pdf'])->name('remisiones.pdf');
        Route::get('/qr/{id}', [FacturasController::class, 'qr'])->name('remisiones.qr');
        
    })->middleware(['auth', 'verified']);
    
    
    Route::prefix('inventario')->group( function() {
        Route::get('/', [InventarioController::class, 'index'])->name('inventario');
        Route::get('edit/{id}', [InventarioController::class, 'edit'])->name('inventario.edit');
    })->middleware(['auth', 'verified'])->name('inventario');
    
    
    Route::prefix('/gastos')->group( function() {
        Route::get('/', [GastosController::class, 'index'])->name('gastos');
    })->middleware(['auth', 'verified']);
    
    
    Route::get('/creditos', function () {
        return Inertia::render('Creditos');
    })->middleware(['auth', 'verified'])->name('creditos');
    
    
    Route::prefix('/recaudos')->group( function() {
        Route::get('/', [RecaudosController::class, 'index'])->name('recaudos');
        Route::get('/edit/{id}', [RecaudosController::class, 'edit'])->name('recaudos.edit');
        Route::get('/qr/{id}', [RecaudosController::class, 'qr'])->name('recaudos.qr');
        Route::get('/pdf/{id}', [RecaudosController::class, 'pdf'])->name('recaudos.pdf');
    
    })->middleware(['auth', 'verified']);
    
    
    Route::prefix('reportes')->group( function() {
        Route::get('/', function () {
            return Inertia::render('Reportes/Index');
        })->name('reportes');
    
        Route::prefix('inventario')->group( function() {
            Route::get('/', [ReportesController::class, 'inventario'])->name('reportes.inventario');
            Route::get('/excel', [ReportesController::class, 'inventario_export'])->name('reportes.inventario_export');
            Route::get('/pdf', [ReportesController::class, 'inventario_pdf'])->name('reportes.inventario_pdf');
            Route::get('/qr', [ReportesController::class, 'inventario_qr'])->name('reportes.inventario_qr');
        });
        Route::prefix('existencia_articulo')->group( function() {
            Route::get('/', [ReportesController::class, 'existencia_articulo'])->name('reportes.existencia_articulo');
            Route::get('/excel', [ReportesController::class, 'existencia_articulo_export'])->name('reportes.existencia_articulo_export');
            Route::get('/pdf', [ReportesController::class, 'existencia_articulo_pdf'])->name('reportes.existencia_articulo_pdf');
            Route::get('/qr', [ReportesController::class, 'existencia_articulo_qr'])->name('reportes.existencia_articulo_qr');
        });
        Route::prefix('articulos_vendidos')->group( function() {
            Route::get('/', [ReportesController::class, 'articulos_vendidos'])->name('reportes.articulos_vendidos');
            Route::get('/excel', [ReportesController::class, 'articulos_vendidos_export'])->name('reportes.articulos_vendidos_export');
            Route::get('/pdf', [ReportesController::class, 'articulos_vendidos_pdf'])->name('reportes.articulos_vendidos_pdf');
            Route::get('/qr', [ReportesController::class, 'articulos_vendidos_qr'])->name('reportes.articulos_vendidos_qr');
        });
        Route::prefix('compras')->group( function() {
            Route::get('/', [ReportesController::class, 'compras'])->name('reportes.compras');
            Route::get('/excel', [ReportesController::class, 'compras_export'])->name('reportes.compras_export');
            Route::get('/pdf', [ReportesController::class, 'compras_pdf'])->name('reportes.compras_pdf');
            Route::get('/qr', [ReportesController::class, 'compras_qr'])->name('reportes.compras_qr');
        });
        Route::prefix('gastos')->group( function() {
            Route::get('/', [ReportesController::class, 'gastos'])->name('reportes.gastos');
            Route::get('/excel', [ReportesController::class, 'gastos_export'])->name('reportes.gastos_export');
            Route::get('/pdf', [ReportesController::class, 'gastos_pdf'])->name('reportes.gastos_pdf');
            Route::get('/qr', [ReportesController::class, 'gastos_qr'])->name('reportes.gastos_qr');
        });
        Route::prefix('estado_cuenta_general')->group( function() {
            Route::get('/', [ReportesController::class, 'estado_cuenta_general'])->name('reportes.estado_cuenta_general');
            Route::get('/excel', [ReportesController::class, 'estado_cuenta_general_export'])->name('reportes.estado_cuenta_general_export');
            Route::get('/pdf', [ReportesController::class, 'estado_cuenta_general_pdf'])->name('reportes.estado_cuenta_general_pdf');
            Route::get('/qr', [ReportesController::class, 'estado_cuenta_general_qr'])->name('reportes.estado_cuenta_general_qr');
        });
        Route::prefix('estado_cuenta_cliente')->group( function() {
            Route::get('/', [ReportesController::class, 'estado_cuenta_cliente'])->name('reportes.estado_cuenta_cliente');
            Route::get('/excel', [ReportesController::class, 'estado_cuenta_cliente_export'])->name('reportes.estado_cuenta_cliente_export');
            Route::get('/pdf', [ReportesController::class, 'estado_cuenta_cliente_pdf'])->name('reportes.estado_cuenta_cliente_pdf');
            Route::get('/qr', [ReportesController::class, 'estado_cuenta_cliente_qr'])->name('reportes.estado_cuenta_cliente_qr');
        });
        Route::prefix('utilidad')->group( function() {
            Route::get('/', [ReportesController::class, 'utilidad'])->name('reportes.utilidad');
            Route::get('/excel', [ReportesController::class, 'utilidad_export'])->name('reportes.utilidad_export');
            Route::get('/pdf', [ReportesController::class, 'utilidad_pdf'])->name('reportes.utilidad_pdf');
            Route::get('/qr', [ReportesController::class, 'utilidad_qr'])->name('reportes.utilidad_qr');
        });
    })->middleware(['auth', 'verified']);
    
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});
