<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\FacturasCollection;
use App\Http\Resources\RecaudosCollection;
use App\Models\Facturas;
use App\Models\Detalles;
use App\Models\Recaudos;
use Inertia\Inertia;

use Barryvdh\DomPDF\Facade\Pdf;

class RecaudosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Facturas::with(
            'cliente', 'detalles', 'recaudos'
        )
        ->has('detalles');
        
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

        return Inertia::render('Recaudos/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new FacturasCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Recaudos/Edit', [
            'factura' => Facturas::with('detalles.producto.inventario', 'detalles.producto.color', 'detalles.producto.medida', 'recaudos', 'cliente')
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

    public function qr( string $id) {
        echo \QrCode::size(700)->generate( url('/recaudos/pdf/' .  $id ) );
    }

    public function pdf(string $id)
    {

        $factura = Facturas::with('detalles.producto.inventario', 'detalles.producto.color', 'detalles.producto.medida', 'recaudos', 'cliente')
        ->find( $id );

        $data = [
            'factura' => $factura
        ];

        $pdf = \PDF::loadView('recaudo', $data);
    
        return $pdf->download($factura->id . '.pdf');
    }
}
