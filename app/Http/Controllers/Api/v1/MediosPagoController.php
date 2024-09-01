<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\MediosPagoRequest;
use App\Http\Resources\MediosPagoResource;
use App\Models\MediosPago;
use Inertia\Inertia;


class MediosPagoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tipo = MediosPago::create( $data );
        return new MediosPagoResource( $tipo );
    }

    /**
     * Display the specified resource.
     */
    public function show(MediosPago $medios_pago)
    {
        return new MediosPagoResource( $medios_pago );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediosPago $medios_pago)
    {
        $medios_pago->update( $request->all() );
        return new MediosPagoResource( $medios_pago );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediosPago $medios_pago)
    {
        $medios_pago->delete();
        return new MediosPagoResource( $medios_pago );
    }
}
