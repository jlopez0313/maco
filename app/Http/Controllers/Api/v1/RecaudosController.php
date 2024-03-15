<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RecaudosRequest;
use App\Http\Resources\RecaudosResource;
use App\Models\Recaudos;
use App\Models\Facturas;
use Inertia\Inertia;


class RecaudosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $recaudo = Recaudos::create( $data );
        return new RecaudosResource( $recaudo );
    }

    /**
     * Display the specified resource.
     */
    public function show(Recaudos $recaudo)
    {
        return new RecaudosResource( $recaudo );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recaudos $recaudo)
    {
        $data = $request->all();
        $recaudo->update( $data );
        return new RecaudosResource( $recaudo );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recaudos $recaudo)
    {
        $recaudo->delete();
        return new RecaudosResource( $recaudo );
    }
}
