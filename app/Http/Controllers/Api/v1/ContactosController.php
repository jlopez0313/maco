<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactosResource;
use App\Models\Contactos;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->principal == 'S') {
            Contactos::where('empresas_id', $request->empresas_id)
            ->update(['principal' => 'N']);
        }

        $contacto = Contactos::create($request->all());
        return new ContactosResource($contacto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contactos $contacto)
    {
        return new ContactosResource($contacto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contactos $contacto)
    {
        if ($request->principal == 'S') {
            Contactos::where('empresas_id', $request->empresas_id)
            ->update(['principal' => 'N']);
        }

        $contacto->update( $request->all() );
        return new ContactosResource($contacto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactos $contacto)
    {
        $contacto->delete();
        return new ContactosResource($contacto);
    }

    public function byEmpresa( $empresa )
    {
        return ContactosResource::collection(
            Contactos::with('empresa')
            ->where('empresas_id', $empresa)
            ->get()
        );
    }
}
