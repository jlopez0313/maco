<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\facturasRequest;
use App\Http\Resources\facturasResource;
use App\Models\Productos;
use App\Models\Facturas;
use Inertia\Inertia;


class FacturasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['updated_by'] = $request->updated_by;
        $data['clientes_id'] = $request->clientes_id;
        $data['tipos_id'] = $request->tipo_pago;
        $data['valor'] = 0;
        $data['estado'] = 'A';

        if ( $request->correo ) {
            $cliente = Clientes::find( $request->clientes_id );
            $cliente->correo = $request->correo;
            $cliente->save();
        }

        $factura = Facturas::create( $data );
        return new FacturasResource( $factura );
    }

    /**
     * Display the specified resource.
     */
    public function show(Facturas $factura)
    {
        return new FacturasResource( $factura );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facturas $factura)
    {
        // $factura->update( $request->all() );
        // return new FacturasResource( $factura );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facturas $factura)
    {
        $factura->delete();
        return new FacturasResource( $factura );
    }

    public function registrar(Request $request, String $id)
    {
        $factura = Facturas::find( $id );
        $factura->estado = 'C';
        $factura->updated_by = $request->updated_by;
        $factura->save();

        foreach( $factura->detalles as $detalle) {
            $producto = Productos::find( $detalle->productos_id );
            $producto->cantidad -= $detalle->cantidad;
            $producto->save();
        }

        return new FacturasResource( $factura );
    }
}
