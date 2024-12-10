<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AutorizacionesResource;
use App\Models\Consecutivos;
use App\Models\Autorizaciones;
use Illuminate\Http\Request;

class AutorizacionesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->estado == 'A') {
            Autorizaciones::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }


        $autorizacione = Autorizaciones::create($request->all());

        $consecutivo = Consecutivos::where('from', 'c')->first();
        if ( !$consecutivo ) {
            $consecutivo = Consecutivos::create([ 'consecutivo' => $request->consecutivo_inicial, 'from' => 'c' ]);
        } else {
            $consecutivo->update([ 'consecutivo' => $request->consecutivo_inicial ]);
        }

        return new AutorizacionesResource($autorizacione);
    }

    /**
     * Display the specified resource.
     */
    public function show(Autorizaciones $autorizacione)
    {
        return new AutorizacionesResource($autorizacione);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Autorizaciones $autorizacione)
    {
        if ($request->estado == 'A') {
            Autorizaciones::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }

        $autorizacione->update( $request->all() );
        return new AutorizacionesResource($autorizacione);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autorizaciones $autorizacione)
    {
        $autorizacione->delete();
        return new AutorizacionesResource($autorizacione);
    }

    public function byEmpresa( $empresa )
    {
        return AutorizacionesResource::collection(
            Autorizaciones::with('empresa')
            ->where('empresas_id', $empresa)
            ->get()
        );
    }

    public function consecutivo( $empresa )
    {
        return new AutorizacionesResource(
            Autorizaciones::with('empresa')
            ->where('empresas_id', $empresa)
            ->orderByDesc('consecutivo_final')
            ->first()
        );
    }
}
