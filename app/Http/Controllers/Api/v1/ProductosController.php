<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductosResource;
use App\Models\Productos;
use App\Models\ProductosImpuestos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('impuestos');
        $producto = Productos::create($data);

        foreach ($request->impuestos as $impuesto) {
            ProductosImpuestos::create([
                'productos_id' => $producto->id,
                'impuestos_id' => $impuesto['impuestos_id'],
            ]);
        }

        return new ProductosResource($producto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Productos $producto)
    {
        $producto->loadMissing('impuestos.impuesto');

        return new ProductosResource($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productos $producto)
    {
        $data = $request->except('impuestos');
        $producto->update($data);

        ProductosImpuestos::where('productos_id', $producto->id)
        ->delete();

        foreach ($request->impuestos as $impuesto) {
            ProductosImpuestos::create([
                'productos_id' => $producto->id,
                'impuestos_id' => $impuesto['impuestos_id'],
            ]);
        }

        return new ProductosResource($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $producto)
    {
        $producto->delete();

        return new ProductosResource($producto);
    }

    public function byReferencia($referencia)
    {
        $producto = Productos::where('referencia', 'LIKE', $referencia.'%')
        ->first();

        return new ProductosResource(
            $producto
        );
    }
}
