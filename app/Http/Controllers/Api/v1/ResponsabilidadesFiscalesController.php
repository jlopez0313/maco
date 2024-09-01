<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ResponsabilidadesFiscalesRequest;
use App\Http\Resources\ResponsabilidadesFiscalesResource;
use App\Models\ResponsabilidadesFiscales;
use Inertia\Inertia;


class ResponsabilidadesFiscalesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tipo = ResponsabilidadesFiscales::create( $data );
        return new ResponsabilidadesFiscalesResource( $tipo );
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponsabilidadesFiscales $responsabilidades_fiscale)
    {
        return new ResponsabilidadesFiscalesResource( $responsabilidades_fiscale );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponsabilidadesFiscales $responsabilidades_fiscale)
    {
        $responsabilidades_fiscale->update( $request->all() );
        return new ResponsabilidadesFiscalesResource( $responsabilidades_fiscale );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponsabilidadesFiscales $responsabilidades_fiscale)
    {
        $responsabilidades_fiscale->delete();
        return new ResponsabilidadesFiscalesResource( $responsabilidades_fiscale );
    }
}
