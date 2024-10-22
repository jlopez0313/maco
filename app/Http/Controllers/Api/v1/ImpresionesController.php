<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ImpresionesRequest;
use App\Http\Resources\ImpresionesResource;
use App\Models\Impresiones;
use Inertia\Inertia;


class ImpresionesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $impresione = Impresiones::create( $data );
        return new ImpresionesResource( $impresione );
    }

    /**
     * Display the specified resource.
     */
    public function show(Impresiones $impresione)
    {
        return new ImpresionesResource( $impresione );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Impresiones $impresione)
    {
        $impresione->update( $request->all() );
        return new ImpresionesResource( $impresione );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Impresiones $impresione)
    {
        $impresione->delete();
        return new ImpresionesResource( $impresione );
    }
}
