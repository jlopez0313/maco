<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResolucionesResource;
use App\Models\Resoluciones;
use Illuminate\Http\Request;

class ResolucionesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->estado == 'A') {
            Resoluciones::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }

        $resolucione = Resoluciones::create($request->all());
        return new ResolucionesResource($resolucione);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resoluciones $resolucione)
    {
        return new ResolucionesResource($resolucione);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resoluciones $resolucione)
    {
        if ($request->estado == 'A') {
            Resoluciones::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }

        $resolucione->update( $request->all() );
        return new ResolucionesResource($resolucione);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resoluciones $resolucione)
    {
        $resolucione->delete();
        return new ResolucionesResource($resolucione);
    }

    public function byEmpresa( $empresa )
    {
        return ResolucionesResource::collection(
            Resoluciones::with('empresa')
            ->where('empresas_id', $empresa)
            ->get()
        );
    }

    public function consecutivo( $empresa )
    {
        return new ResolucionesResource(
            Resoluciones::with('empresa')
            ->where('empresas_id', $empresa)
            ->orderByDesc('consecutivo_final')
            ->first()
        );
    }
}
