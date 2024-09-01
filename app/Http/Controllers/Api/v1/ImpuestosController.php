<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImpuestosResource;
use App\Models\Impuestos;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $impuesto = Impuestos::create($data);

        return new ImpuestosResource($impuesto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Impuestos $impuesto)
    {
        return new ImpuestosResource($impuesto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Impuestos $impuesto)
    {
        $impuesto->update($request->all());

        return new ImpuestosResource($impuesto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Impuestos $impuesto)
    {
        $impuesto->delete();

        return new ImpuestosResource($impuesto);
    }
}
