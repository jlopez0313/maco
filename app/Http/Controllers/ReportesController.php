<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Resources\ClientesCollection;
use App\Http\Resources\FacturasCollection;
use App\Http\Resources\GastosCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\RecaudosCollection;

use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\Gastos;
use App\Models\Inventarios;
use App\Models\Productos;
use App\Models\Recaudos;

use Inertia\Inertia;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArticulosVendidosExport;
use App\Exports\ComprasExport;
use App\Exports\GastosExport;
use App\Exports\InventarioExport;
use App\Exports\EstadoCuentaGeneralExport;
use App\Exports\EstadoCuentaClienteExport;
use App\Exports\ExistenciaArticuloExport;
use App\Exports\UtilidadExport;


class ReportesController extends Controller
{

    public function inventario() {
        $query = Inventarios::with('productos.color', 'productos.medida')
            ->get()
        ;
        return Inertia::render('Reportes/Inventario', [ 'facturas' => $query ]);
    }

    public function inventario_export(Request $request) 
    {
        return Excel::download(new InventarioExport( $request->all() ), 'Inventario.xlsx');
    }

    public function inventario_pdf(Request $request) 
    {
        $query = Inventarios::with('productos')
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.inventario', $data);
    
        return $pdf->download('inventario.pdf');
    }

    public function inventario_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/inventario/pdf') );
    }


    public function existencia_articulo() {
        $query = Inventarios::get();
        return Inertia::render('Reportes/ExistenciaArticulo', ['inventarios' => $query]);
    }

    public function existencia_articulo_export(Request $request) 
    {
        return Excel::download(new ExistenciaArticuloExport( $request->all() ), 'Existencia_Articulo.xlsx');
    }

    public function existencia_articulo_pdf(Request $request) 
    {
        $query = Inventarios::with('productos.color', 'productos.medida')
            ->find( $request['inventario'] )
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.existencia_articulo', $data);
    
        return $pdf->download('existencia_articulo.pdf');
    }

    public function existencia_articulo_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/existencia_articulo/pdf?inventario=' . $request['inventario']) );
    }


    public function articulos_vendidos() {
        return Inertia::render('Reportes/ArticulosVendidos');
    }

    public function articulos_vendidos_export(Request $request) 
    {
        return Excel::download(new ArticulosVendidosExport( $request->all() ), 'ArticulosVendidos.xlsx');
    }

    public function articulos_vendidos_pdf(Request $request) 
    {
        $query = Facturas::with('detalles.producto.inventario')
            ->whereBetween('created_at', [ $request['fecha_inicial'] . ' 00:00:00', $request['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.articulos_vendidos', $data);
    
        return $pdf->download('articulos_vendidos.pdf');
    }

    public function articulos_vendidos_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/articulos_vendidos/pdf?fecha_inicial=' . $request['fecha_inicial'] . ' 00:00:00' . '&fecha_final=' . $request['fecha_final'] . ' 23:59:59') );
    }


    public function compras() {
        return Inertia::render('Reportes/Compras');
    }

    public function compras_export(Request $request) 
    {
        return Excel::download(new ComprasExport( $request->all() ), 'Compras.xlsx');
    }

    public function compras_pdf(Request $request) 
    {
        $query = Facturas::with('detalles', 'cliente')
            ->whereBetween('created_at', [ $request['fecha_inicial'] . ' 00:00:00', $request['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.compras', $data);
    
        return $pdf->download('compras.pdf');
    }

    public function compras_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/compras/pdf?fecha_inicial=' . $request['fecha_inicial'] . ' 00:00:00' . '&fecha_final=' . $request['fecha_final'] . ' 23:59:59') );
    }
    
    
    public function gastos() {
        return Inertia::render('Reportes/Gastos');
    }

    public function gastos_export(Request $request) 
    {
        return Excel::download(new GastosExport( $request->all() ), 'Gastos.xlsx');
    }

    public function gastos_pdf(Request $request) 
    {
        $query = Gastos::with('concepto', 'cliente')
            ->whereBetween('created_at', [ $request['fecha_inicial'] . ' 00:00:00', $request['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.gastos', $data);
    
        return $pdf->download('gastos.pdf');
    }

    public function gastos_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/gastos/pdf?fecha_inicial=' . $request['fecha_inicial'] . ' 00:00:00' . '&fecha_final=' . $request['fecha_final'] . ' 23:59:59') );
    }
    
    
    public function estado_cuenta_general() {
        return Inertia::render('Reportes/EstadoCuentaGeneral');
    }
    
    public function estado_cuenta_general_export(Request $request) 
    {
        return Excel::download(new EstadoCuentaGeneralExport( $request->all() ), 'EstadoCuentaGeneral.xlsx');
    }

    public function estado_cuenta_general_pdf(Request $request) 
    {
        $query = Facturas::with(
                'cliente', 'detalles', 'recaudos'
            )
            ->has('detalles')
            ->where('tipos_id', '1')
            ->whereBetween('created_at', [ $request['fecha_inicial'] . ' 00:00:00', $request['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.estado_cuenta_general', $data);
    
        return $pdf->download('estado_cuenta_general.pdf');
    }

    public function estado_cuenta_general_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/estado_cuenta_general/pdf?fecha_inicial=' . $request['fecha_inicial'] . ' 00:00:00' . '&fecha_final=' . $request['fecha_final'] . ' 23:59:59') );
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

    public function estado_cuenta_cliente_pdf(Request $request) 
    {
        $query = Facturas::with(
                'cliente', 'detalles', 'recaudos'
            )
            ->has('detalles')
            ->where('tipos_id', '1')
            ->where('clientes_id', $request['clientes_id'])
            ->whereBetween('created_at', [ $request['fecha_inicial'] . ' 00:00:00', $request['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        $data = [
            'invoices' => $query
        ];

        $pdf = \PDF::loadView('exports.estado_cuenta_cliente', $data);
    
        return $pdf->download('estado_cuenta_cliente.pdf');
    }

    public function estado_cuenta_cliente_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/estado_cuenta_cliente/pdf?fecha_inicial=' . $request['fecha_inicial'] . ' 00:00:00' . '&fecha_final=' . $request['fecha_final'] . ' 23:59:59' . '&clientes_id=' . $request['clientes_id']) );
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

    public function utilidad_pdf(Request $request) 
    {
        $facturas = Facturas::with(
            'cliente', 'detalles.producto.inventario',
        )->get();

        $data = [
            'facturas' => $facturas,
            'inventario' => $this->onSetProductos( Productos::get() ),
            'compraCredito' => $this->onSetCompraCredito($facturas),
            'compraContado' => $this->onSetCompraContado($facturas),
            'recaudos' => $this->onSetRecaudos( Recaudos::get() ),
            'gastos' => $this->onSetGastos( Gastos::get() ),
        ];

        $pdf = \PDF::loadView('exports.utilidad', $data);
    
        return $pdf->download('utilidad.pdf');
    }

    public function utilidad_qr(Request $request) {
        echo \QrCode::size(700)->generate( url('/reportes/utilidad/pdf') );
    }

    public function onSetProductos($productos) {
        return $productos->reduce( function ($sum, $prod ) {
            return $sum + ($prod->cantidad * $prod->precio );
        }, 0) ;
    }

    public function onSetCompraCredito($facturas) {
        $lista = $facturas->filter( 
            function ($item) { 
                return $item->forma_pago?->id == "1" ;
        });

        $total = $lista->map( function ($item) {
            return (
                $item->detalles->reduce(
                    function ($sum, $det) { 
                        return $sum + ($det->precio_venta * $det->cantidad) ;
                    },
                    0
                ) ?? 0
            );
        });

        $nacional = $lista->map( function($item) { return $item->detalles?->filter( function ($detalle) { return $detalle->producto?->inventario?->origen == 'N' ;} ) ?? []; }) ;
        $importado = $lista->map( function($item) { return $item->detalles?->filter( function ($detalle) { return $detalle->producto?->inventario?->origen == 'I' ;} ) ?? []; }) ;

        return [
            'total' => $total->reduce( function ($sum, $item) { return $sum + $item ; }, 0),
            'nacional' => $nacional->flatten(1)->reduce( function ($sum, $item) { return $sum + ( ($item['cantidad'] ?? 0) * ($item['precio_venta'] ?? 0) ) ;}, 0),
            'importado' => $importado->flatten(1)->reduce( function ($sum, $item) { return $sum + ( ($item['cantidad'] ?? 0) * ($item['precio_venta'] ?? 0) ) ;}, 0),
        ] ;
    }

    public function onSetCompraContado($facturas) {
        $lista = $facturas->filter( 
            function ($item) { 
                return $item->forma_pago?->id == "2" ;
        });

        $total = $lista->map( function ($item) {
            return (
                $item->$detalles->reduce(
                    function ($sum, $det) { 
                        return $sum + ($det->precio_venta * $det->cantidad) ;
                    },
                    0
                ) ?? 0
            );
        });

        $nacional = $lista->map( function($item) { return $item->detalles?->filter( function ($detalle) { return $detalle->producto?->inventario?->origen == 'N' ;} ) ?? []; }) ;
        $importado = $lista->map( function($item) { return $item->detalles?->filter( function ($detalle) { return $detalle->producto?->inventario?->origen == 'I' ;} ) ?? []; }) ;

        return [
            'total' => $total->reduce( function ($sum, $item) { return $sum + $item ; }, 0),
            'nacional' => $nacional->flatten(1)->reduce( function ($sum, $item) { return $sum + ( ($item['cantidad'] ?? 0) * ($item['precio_venta'] ?? 0) ) ;}, 0),
            'importado' => $importado->flatten(1)->reduce( function ($sum, $item) { return $sum + ( ($item['cantidad'] ?? 0) * ($item['precio_venta'] ?? 0) ) ;}, 0),
        ] ;
    }

    public function onSetRecaudos($recaudos) {
        return $recaudos->reduce( function ($sum, $prod ) {
            return $sum + $prod->valor;
        }, 0);
    }

    public function onSetGastos($gastos) {
        $total = $gastos->reduce (
            function ($sum, $det) {
                return $sum + $det->valor;
            }, 
            0
        );

        $nacional = $gastos->filter( function ($detalle) { return $detalle->origen == 'N' ; }  ) ?? [];

        $importado = $gastos->filter( function ($detalle) { return $detalle->origen == 'I' ; } ) ?? [] ;
        
        return [
            'total' => $total,
            'nacional' =>  $nacional->flatten(1)->reduce( function ($sum, $det) { return $sum + $det->valor ;}, 0),
            'importado' =>  $importado->flatten(1)->reduce( function ($sum, $det) { return $sum + $det->valor ;}, 0),
        ] ;
    }

}