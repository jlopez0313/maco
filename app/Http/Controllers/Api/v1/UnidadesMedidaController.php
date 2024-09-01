<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UnidadesMedidaRequest;
use App\Http\Resources\UnidadesMedidaResource;
use App\Models\UnidadesMedida;
use Inertia\Inertia;


class UnidadesMedidaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tipo = UnidadesMedida::create( $data );
        return new UnidadesMedidaResource( $tipo );
    }

    /**
     * Display the specified resource.
     */
    public function show(UnidadesMedida $unidades_medida)
    {
        return new UnidadesMedidaResource( $unidades_medida );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnidadesMedida $unidades_medida)
    {
        $unidades_medida->update( $request->all() );
        return new UnidadesMedidaResource( $unidades_medida );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadesMedida $unidades_medida)
    {
        $unidades_medida->delete();
        return new UnidadesMedidaResource( $unidades_medida );
    }
}
