<?php

declare(strict_types=1);

use App\Http\Controllers\BancosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\ConceptosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\ImpuestosController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MedidasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\RecaudosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ResponsabilidadesFiscalesController;
use App\Http\Controllers\UnidadesMedidaController;
use App\Http\Controllers\FormasPagoController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\MediosPagoController;
use App\Http\Controllers\TiposClientesController;
use App\Http\Controllers\TiposDocumentosController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    });

    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => false,
            'laravelVersion' => '1.0.0',
        ]);
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::prefix('parametros')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Parametros/Index');
        })->name('parametros');

        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('parametros.usuarios');
        });

        Route::prefix('responsabilidades_fiscales')->group(function () {
            Route::get('/', [ResponsabilidadesFiscalesController::class, 'index'])->name('parametros.responsabilidades');
        });

        Route::prefix('tipos_clientes')->group(function () {
            Route::get('/', [TiposClientesController::class, 'index'])->name('parametros.clientes');
        });

        Route::prefix('tipos_documentos')->group(function () {
            Route::get('/', [TiposDocumentosController::class, 'index'])->name('parametros.documentos');
        });

        Route::prefix('unidades_medida')->group(function () {
            Route::get('/', [UnidadesMedidaController::class, 'index'])->name('parametros.unidades');
        });
        
        Route::prefix('medios_pago')->group(function () {
            Route::get('/', [MediosPagoController::class, 'index'])->name('parametros.medios_pago');
        });

        Route::prefix('formas_pago')->group(function () {
            Route::get('/', [FormasPagoController::class, 'index'])->name('parametros.formas_pago');
        });

        Route::prefix('conceptos')->group(function () {
            Route::get('/', [ConceptosController::class, 'index'])->name('parametros.conceptos');
        });

        Route::prefix('bancos')->group(function () {
            Route::get('/', [BancosController::class, 'index'])->name('parametros.bancos');
        });

        Route::prefix('medidas')->group(function () {
            Route::get('/', [MedidasController::class, 'index'])->name('parametros.medidas');
        });

        Route::prefix('colores')->group(function () {
            Route::get('/', [ColoresController::class, 'index'])->name('parametros.colores');
        });

        Route::prefix('impuestos')->group(function () {
            Route::get('/', [ImpuestosController::class, 'index'])->name('parametros.impuestos');
        });
    })->middleware(['auth', 'verified']);

    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClientesController::class, 'index'])->name('clientes');
        Route::get('/create', [ClientesController::class, 'create'])->name('clientes.create');
        Route::get('/edit/{id}', [ClientesController::class, 'edit'])->name('clientes.edit');
    })->middleware(['auth', 'verified']);

    Route::prefix('empresas')->group(function () {
        Route::get('/', [EmpresasController::class, 'index'])->name('empresas');
    })->middleware(['auth', 'verified']);

    Route::prefix('proveedores')->group(function () {
        Route::get('/', [ProveedoresController::class, 'index'])->name('proveedores');
        Route::get('/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
        Route::get('/edit/{id}', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
    })->middleware(['auth', 'verified']);

    Route::prefix('remisiones')->group(function () {
        Route::get('/', [FacturasController::class, 'index'])->name('remisiones');
        Route::get('/show/{id}', [FacturasController::class, 'show'])->name('remisiones.show');
        Route::get('/edit/{id}', [FacturasController::class, 'edit'])->name('remisiones.edit');
        Route::get('/pdf/{id}', [FacturasController::class, 'pdf'])->name('remisiones.pdf');
        Route::get('/qr/{id}', [FacturasController::class, 'qr'])->name('remisiones.qr');
    })->middleware(['auth', 'verified']);

    Route::prefix('inventario')->group(function () {
        Route::get('/', [InventarioController::class, 'index'])->name('inventario');
        Route::get('show/{id}', [InventarioController::class, 'show'])->name('inventario.show');
        Route::get('add/{id}', [InventarioController::class, 'add'])->name('inventario.add');
        Route::get('modify/{inventario}/{id}', [InventarioController::class, 'modify'])->name('inventario.modify');
    })->middleware(['auth', 'verified'])->name('inventario');

    Route::prefix('/gastos')->group(function () {
        Route::get('/', [GastosController::class, 'index'])->name('gastos');
    })->middleware(['auth', 'verified']);

    Route::get('/creditos', function () {
        return Inertia::render('Creditos');
    })->middleware(['auth', 'verified'])->name('creditos');

    Route::prefix('/recaudos')->group(function () {
        Route::get('/', [RecaudosController::class, 'index'])->name('recaudos');
        Route::get('/edit/{id}', [RecaudosController::class, 'edit'])->name('recaudos.edit');
        Route::get('/qr/{id}', [RecaudosController::class, 'qr'])->name('recaudos.qr');
        Route::get('/pdf/{id}', [RecaudosController::class, 'pdf'])->name('recaudos.pdf');
    })->middleware(['auth', 'verified']);

    Route::prefix('reportes')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Reportes/Index');
        })->name('reportes');

        Route::prefix('inventario')->group(function () {
            Route::get('/', [ReportesController::class, 'inventario'])->name('reportes.inventario');
            Route::get('/excel', [ReportesController::class, 'inventario_export'])->name('reportes.inventario_export');
            Route::get('/pdf', [ReportesController::class, 'inventario_pdf'])->name('reportes.inventario_pdf');
            Route::get('/qr', [ReportesController::class, 'inventario_qr'])->name('reportes.inventario_qr');
        });
        Route::prefix('existencia_articulo')->group(function () {
            Route::get('/', [ReportesController::class, 'existencia_articulo'])->name('reportes.existencia_articulo');
            Route::get('/excel', [ReportesController::class, 'existencia_articulo_export'])->name('reportes.existencia_articulo_export');
            Route::get('/pdf', [ReportesController::class, 'existencia_articulo_pdf'])->name('reportes.existencia_articulo_pdf');
            Route::get('/qr', [ReportesController::class, 'existencia_articulo_qr'])->name('reportes.existencia_articulo_qr');
        });
        Route::prefix('articulos_vendidos')->group(function () {
            Route::get('/', [ReportesController::class, 'articulos_vendidos'])->name('reportes.articulos_vendidos');
            Route::get('/excel', [ReportesController::class, 'articulos_vendidos_export'])->name('reportes.articulos_vendidos_export');
            Route::get('/pdf', [ReportesController::class, 'articulos_vendidos_pdf'])->name('reportes.articulos_vendidos_pdf');
            Route::get('/qr', [ReportesController::class, 'articulos_vendidos_qr'])->name('reportes.articulos_vendidos_qr');
        });
        Route::prefix('ventas')->group(function () {
            Route::get('/', [ReportesController::class, 'ventas'])->name('reportes.ventas');
            Route::get('/excel', [ReportesController::class, 'ventas_export'])->name('reportes.ventas_export');
            Route::get('/pdf', [ReportesController::class, 'ventas_pdf'])->name('reportes.ventas_pdf');
            Route::get('/qr', [ReportesController::class, 'ventas_qr'])->name('reportes.ventas_qr');
        });
        Route::prefix('gastos')->group(function () {
            Route::get('/', [ReportesController::class, 'gastos'])->name('reportes.gastos');
            Route::get('/excel', [ReportesController::class, 'gastos_export'])->name('reportes.gastos_export');
            Route::get('/pdf', [ReportesController::class, 'gastos_pdf'])->name('reportes.gastos_pdf');
            Route::get('/qr', [ReportesController::class, 'gastos_qr'])->name('reportes.gastos_qr');
        });
        Route::prefix('estado_cuenta_general')->group(function () {
            Route::get('/', [ReportesController::class, 'estado_cuenta_general'])->name('reportes.estado_cuenta_general');
            Route::get('/excel', [ReportesController::class, 'estado_cuenta_general_export'])->name('reportes.estado_cuenta_general_export');
            Route::get('/pdf', [ReportesController::class, 'estado_cuenta_general_pdf'])->name('reportes.estado_cuenta_general_pdf');
            Route::get('/qr', [ReportesController::class, 'estado_cuenta_general_qr'])->name('reportes.estado_cuenta_general_qr');
        });
        Route::prefix('estado_cuenta_cliente')->group(function () {
            Route::get('/', [ReportesController::class, 'estado_cuenta_cliente'])->name('reportes.estado_cuenta_cliente');
            Route::get('/excel', [ReportesController::class, 'estado_cuenta_cliente_export'])->name('reportes.estado_cuenta_cliente_export');
            Route::get('/pdf', [ReportesController::class, 'estado_cuenta_cliente_pdf'])->name('reportes.estado_cuenta_cliente_pdf');
            Route::get('/qr', [ReportesController::class, 'estado_cuenta_cliente_qr'])->name('reportes.estado_cuenta_cliente_qr');
        });
        Route::prefix('utilidad')->group(function () {
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

// require __DIR__.'/tenant_auth.php';
