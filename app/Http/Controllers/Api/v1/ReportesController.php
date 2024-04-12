<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Resources\FacturasResource;
use App\Http\Resources\GastosResource;

use App\Models\Facturas;
use App\Models\Gastos;

class ReportesController extends Controller
{

    public function inventario(Request $request) {
        
    }
    
    
    public function existencia_articulo(Request $request) {
        
    }
    
    
    public function articulos_vendidos(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with('detalles.producto.inventario')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:00:00' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function compras(Request $request) {
        $data = $request->all();
        
        $query = Facturas::with('detalles', 'cliente')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:00:00' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function gastos(Request $request) {
        $data = $request->all();
        
        $query = Gastos::with('concepto', 'cliente')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:00:00' ])
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
            ->where('tipo_pago', 'CR')
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:00:00' ])
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
            ->where('tipo_pago', 'CR')
            ->where('clientes_id', $data['clientes_id'])
            ->whereBetween('created_at', [ $data['fecha_inicial'] . ' 00:00:00', $data['fecha_final'] . ' 23:00:00' ])
            ->get()
        ;

        return FacturasResource::collection($query);
    }
    
    
    public function utilidad(Request $request) {
        
    }


}