<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\FacturasRequest;
use App\Http\Resources\FacturasResource;
use App\Models\Productos;
use App\Models\Facturas;
use App\Models\Clientes;

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
        $data['forma_pago_id'] = $request->forma_pago_id;
        $data['medio_pago_id'] = $request->medio_pago_id;
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
        \DB::beginTransaction();

        try {

            $factura = Facturas::find( $id );
            $factura->estado = 'C';
            $factura->updated_by = $request->updated_by;
            $factura->save();
    
            foreach( $factura->detalles as $detalle) {
                $producto = Productos::find( $detalle->productos_id );
                $producto->cantidad -= $detalle->cantidad;
                $producto->save();
            }
    
            if( $request->desea == 'S' ) {
                $soap = new SoapController();
                $result = $soap->upload($id);

                if ( isset( $result->errors ) ) {
                    return response([ 'data' => $result, 'errors' => $result->errors ], 500);
                }
            }

            \DB::commit();
            return new FacturasResource( $factura );

        } catch( \Exception $ex ) {
            \DB::rollback();
            return response([ 'errors' => $ex->getMessage() ], 500);
        }

    }

    public function cierre(Request $erquest) {
        $data = Facturas::with('detalles.producto.impuestos.impuesto')
        ->whereDate('created_at', \Carbon\Carbon::today())
        ->get();

        return FacturasResource::collection( $data );
    }
}
