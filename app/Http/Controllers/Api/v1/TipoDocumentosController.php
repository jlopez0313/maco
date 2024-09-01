<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\TiposDocumentosRequest;
use App\Http\Resources\TiposDocumentosResource;
use App\Models\TiposDocumentos;
use Inertia\Inertia;


class TipoDocumentosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tipo = TiposDocumentos::create( $data );
        return new TiposDocumentosResource( $tipo );
    }

    /**
     * Display the specified resource.
     */
    public function show(TiposDocumentos $tipo_documento)
    {
        return new TiposDocumentosResource( $tipo_documento );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TiposDocumentos $tipo_documento)
    {
        $tipo_documento->update( $request->all() );
        return new TiposDocumentosResource( $tipo_documento );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TiposDocumentos $tipo_documento)
    {
        $tipo_documento->delete();
        return new TiposDocumentosResource( $tipo_documento );
    }
}
