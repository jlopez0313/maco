<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\GastosRequest;
use App\Http\Resources\GastosResource;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\Gastos;
use Inertia\Inertia;


class GastosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['updated_by'] = $request->updated_by;
        $data['proveedores_id'] = $request->proveedores_id;
        $data['forma_pago_id'] = $request->forma_pago_id;
        $data['medio_pago_id'] = $request->medio_pago_id;
        $data['valor'] = 0;
        $data['estado'] = 'A';

        if ( $request->correo ) {
            $proveedor = Proveedores::find( $request->proveedores_id );
            $proveedor->correo = $request->correo;
            $proveedor->save();
        }

        $gasto = Gastos::create( $data );
        return new GastosResource( $gasto );
    }

    /**
     * Display the specified resource.
     */
    public function show(Gastos $gasto)
    {
        return new GastosResource( $gasto );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gastos $gasto)
    {
        $gasto->update( $request->all() );
        return new GastosResource( $gasto );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gastos $gasto)
    {
        $gasto->delete();
        return new GastosResource( $gasto );
    }

    public function registrar(Request $request, String $id)
    {
        \DB::beginTransaction();

        try {

            $factura = Gastos::find( $id );
            $factura->estado = 'C';
            $factura->updated_by = $request->updated_by;
            $factura->save();
    
            foreach( $factura->detalles as $detalle) {
                $producto = Productos::find( $detalle->productos_id );
                $producto->cantidad += $detalle->cantidad;
                $producto->save();
            }
    
            if( $request->desea == 'S' ) {
                $soap = new DocumentoSoporteController();
                $result = $soap->upload($id);

                if ( isset( $result->errors ) ) {
                    return response([ 'data' => $result, 'errors' => $result->errors ], 500);
                }
            }

            \DB::commit();
            return new GastosResource( $factura );

        } catch( \Exception $ex ) {
            \DB::rollback();
            return response([ 'errors' => $ex->getMessage() ], 500);
        }

    }

    public function cierre(Request $erquest) {
        $data = Gastos::with('detalles.producto.impuestos.impuesto')
        ->whereDate('created_at', \Carbon\Carbon::today())
        ->where('forma_pago_id', 1)
        ->get();

        return GastosResource::collection( $data );
    }
}
