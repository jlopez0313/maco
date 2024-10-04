<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Resources\FacturasResource;
use App\Http\Resources\GastosResource;
use App\Http\Resources\InventariosResource;
use App\Http\Resources\ProductosResource;

use App\Models\Facturas;
use App\Models\Gastos;
use App\Models\Inventarios;
use App\Models\Productos;

class ReportesController extends Controller
{

    public function inventario(Request $request) {
        
    }
    
    
    public function existencia_articulo(Request $request) {
        $data = $request->all();
        
        $query = Inventarios::with('productos.color', 'productos.medida')
            ->find( $request['inventario'] )
        ;

        return new InventariosResource($query);
    }
    
    
    public function articulos_vendidos(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with('detalles.producto.inventario', 'detalles.producto.impuestos.impuesto')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function ventas(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with('detalles.producto.inventario', 'detalles.producto.impuestos.impuesto', 'cliente')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function gastos(Request $request) {
        $data = $request->all();
        
        $query = Gastos::with('concepto', 'cliente')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return GastosResource::collection($query);
    }
    
    
    public function estado_cuenta_general(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with(
                'cliente', 'detalles', 'recaudos'
            )
            ->has('detalles')
            ->where('forma_pago_id', '2')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function estado_cuenta_cliente(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with(
                'cliente', 'detalles', 'recaudos'
            )
            ->has('detalles')
            ->where('forma_pago_id', '2')
            ->where('clientes_id', $data['clientes_id'])
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function utilidad(Request $request) {
        
    }


}