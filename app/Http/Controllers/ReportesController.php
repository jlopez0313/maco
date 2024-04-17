<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ClientesCollection;
use App\Http\Resources\FacturasCollection;
use App\Http\Resources\GastosCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\RecaudosCollection;

use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\Gastos;
use App\Models\Productos;
use App\Models\Recaudos;

use Inertia\Inertia;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArticulosVendidosExport;
use App\Exports\ComprasExport;
use App\Exports\GastosExport;
use App\Exports\EstadoCuentaGeneralExport;
use App\Exports\EstadoCuentaClienteExport;
use App\Exports\UtilidadExport;


class ReportesController extends Controller
{

    public function inventario() {
        return Inertia::render('Reportes/Inventario');
    }


    public function existencia_articulo() {
        return Inertia::render('Reportes/ExistenciaArticulo');
    }


    public function articulos_vendidos() {
        return Inertia::render('Reportes/ArticulosVendidos');
    }

    public function articulos_vendidos_export(Request $request) 
    {
        return Excel::download(new ArticulosVendidosExport( $request->all() ), 'ArticulosVendidos.xlsx');
    }


    public function compras() {
        return Inertia::render('Reportes/Compras');
    }

    public function compras_export(Request $request) 
    {
        return Excel::download(new ComprasExport( $request->all() ), 'Compras.xlsx');
    }
    
    
    public function gastos() {
        return Inertia::render('Reportes/Gastos');
    }

    public function gastos_export(Request $request) 
    {
        return Excel::download(new GastosExport( $request->all() ), 'Gastos.xlsx');
    }
    
    
    public function estado_cuenta_general() {
        return Inertia::render('Reportes/EstadoCuentaGeneral');
    }
    
    public function estado_cuenta_general_export(Request $request) 
    {
        return Excel::download(new EstadoCuentaGeneralExport( $request->all() ), 'EstadoCuentaGeneral.xlsx');
    }
    

    public function estado_cuenta_cliente() {
        return Inertia::render('Reportes/EstadoCuentaCliente', [
            'clientes' => new ClientesCollection(
                Clientes::orderBy('nombre')->get()
            ),
        ]);
    }

    public function estado_cuenta_cliente_export(Request $request) 
    {
        return Excel::download(new EstadoCuentaClienteExport( $request->all() ), 'EstadoCuentaCliente.xlsx');
    }


    public function utilidad() {

        $facturas = Facturas::with(
            'cliente', 'detalles.producto.inventario',
        );

        return Inertia::render('Reportes/Utilidad', [
            'facturas' => new FacturasCollection(
                $facturas->get()
            ),
            'gastos' => new GastosCollection(
                Gastos::get()
            ),
            'recaudos' => new RecaudosCollection(
                Recaudos::get()
            ),
            'productos' => new ProductosCollection(
                Productos::get()
            )
        ]);
    }

    public function utilidad_export(Request $request) 
    {
        return Excel::download(new UtilidadExport( $request->all() ), 'Utilidad.xlsx');
    }


}