<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermisosResource;
use App\Models\Consecutivos;
use App\Models\Permisos;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->estado == 'A') {
            Permisos::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }


        $permiso = Permisos::create($request->all());

        $consecutivo = Consecutivos::where('from', 'c')->first();
        if ( !$consecutivo ) {
            $consecutivo = Consecutivos::create([ 'consecutivo' => $request->consecutivo_inicial, 'from' => 'p' ]);
        } else {
            $consecutivo->update([ 'consecutivo' => $request->consecutivo_inicial ]);
        }

        return new PermisosResource($permiso);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permisos $permiso)
    {
        return new PermisosResource($permiso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permisos $permiso)
    {
        if ($request->estado == 'A') {
            Permisos::where('empresas_id', $request->empresas_id)
            ->update(['estado' => 'I']);
        }

        $permiso->update( $request->all() );
        return new PermisosResource($permiso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permisos $permiso)
    {
        $permiso->delete();
        return new PermisosResource($permiso);
    }

    public function byEmpresa( $empresa )
    {
        return PermisosResource::collection(
            Permisos::with('empresa')
            ->where('empresas_id', $empresa)
            ->get()
        );
    }

    public function consecutivo( $empresa )
    {
        return new PermisosResource(
            Permisos::with('empresa')
            ->where('empresas_id', $empresa)
            ->orderByDesc('consecutivo_final')
            ->first()
        );
    }
}
