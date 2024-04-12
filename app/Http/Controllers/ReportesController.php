<?php

namespace App\Http\Controllers;

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


    public function compras() {
        return Inertia::render('Reportes/Compras');
    }
    
    
    public function gastos() {
        return Inertia::render('Reportes/Gastos');
    }
    
    
    public function estado_cuenta_general() {
        return Inertia::render('Reportes/EstadoCuentaGeneral');
    }
    
    
    public function estado_cuenta_cliente() {
        return Inertia::render('Reportes/EstadoCuentaCliente', [
            'clientes' => new ClientesCollection(
                Clientes::orderBy('nombre')->get()
            ),
        ]);
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


}