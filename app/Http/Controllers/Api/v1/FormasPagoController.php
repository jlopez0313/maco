<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\FormasPagoRequest;
use App\Http\Resources\FormasPagoResource;
use App\Models\FormasPago;
use Inertia\Inertia;


class FormasPagoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tipo = FormasPago::create( $data );
        return new FormasPagoResource( $tipo );
    }

    /**
     * Display the specified resource.
     */
    public function show(FormasPago $forma_pago)
    {
        return new FormasPagoResource( $forma_pago );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormasPago $forma_pago)
    {
        $forma_pago->update( $request->all() );
        return new FormasPagoResource( $forma_pago );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormasPago $forma_pago)
    {
        $forma_pago->delete();
        return new FormasPagoResource( $forma_pago );
    }
}
