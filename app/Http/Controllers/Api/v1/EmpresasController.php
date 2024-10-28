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

        if ( $request->logo ) {
            
            $filename = $request->logo->store('files/logos');
            $empresa->update( [...$data, 'logo' => $filename] );
        } else {
            $empresa = Empresas::create( $data );
        }

        $this->makeLink();

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

        if ( $request->logo ) {
            
            if( $empresa->logo ) {
                \Storage::delete( $empresa->logo );
            }

            $filename = $request->logo->store('files/logos');
            $url = Storage::url($filename);
            $empresa->update( [...$data, 'logo' => $url] );
        } else {
            $empresa->update( $data );
        }

        $this->makeLink();

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

    public function makeLink() {
        if  ( !is_link( 'tenant_' . tenant()->id ) ) {
            symlink(storage_path() . '/app', 'tenant_' . tenant()->id);
        }
    }
}
