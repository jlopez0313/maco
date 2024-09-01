<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmpresasResource;
use App\Models\Empresas;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except(['depto', 'tipo', 'ciudad']);
        $data['ciudad_id'] = $request->ciudad;
        
        $empresa = Empresas::create($data);
        return new EmpresasResource($empresa);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresas $empresa)
    {
        return new EmpresasResource($empresa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresas $empresa)
    {
        $data = $request->except(['depto', 'tipo', 'ciudad']);
        $data['ciudad_id'] = $request->ciudad;

        $empresa->update( $data );
        return new EmpresasResource($empresa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresas $empresa)
    {
        $empresa->delete();
        return new EmpresasResource($empresa);
    }
}
