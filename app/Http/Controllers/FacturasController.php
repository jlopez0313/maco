<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\DepartamentosCollection;
use App\Http\Resources\FacturasCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\TiposClientesCollection;
use App\Models\Productos;
use App\Models\Facturas;
use App\Models\Departamentos;
use App\Models\TiposClientes;
use Inertia\Inertia;

use Barryvdh\DomPDF\Facade\Pdf;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Facturas::with(
            'cliente', 'forma_pago'
        );
        
        if( $request->q ) {
            $query->where('id', 'LIKE', '%' . $request->q . '%')
            ->orWhere('created_at', 'LIKE', '%' . $request->q . '%')
            ->orWhereHas( 'cliente', function($q) use ($request) {
                    $q->where('nombre', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('direccion', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('celular', 'LIKE', '%' . $request->q . '%')
                ;
            })
            ;
        }

        return Inertia::render('Facturas/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new FacturasCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'payments' => new TiposClientesCollection(
                TiposClientes::orderBy('tipo')->get()
            ),
            'departments' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Facturas/Show', [
            'factura' => Facturas::with('detalles.producto.inventario', 'detalles.producto.color', 'detalles.producto.medida', 'cliente')
                ->find( $id )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Facturas/Edit', [
            'factura' => Facturas::with('detalles.producto.inventario', 'detalles.producto.color', 'detalles.producto.medida', 'cliente')
                ->find( $id )
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pdf(string $id)
    {

        $factura = Facturas::find( $id );

        $data = [
            'factura' => $factura
        ];

        $pdf = \PDF::loadView('factura', $data);
    
        return $pdf->download($factura->id . '.pdf');
    }

    public function qr( string $id) {
        echo \QrCode::size(700)->generate( url('/remisiones/pdf/' .  $id ) );
    }
}
