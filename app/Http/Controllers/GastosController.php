<?php

namespace App\Http\Controllers;



use App\Http\Resources\DepartamentosCollection;
use App\Http\Resources\GastosCollection;
use App\Http\Resources\FormasPagoCollection;
use App\Http\Resources\MediosPagoCollection;
use App\Http\Resources\ProveedoresCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\TiposClientesCollection;
use App\Http\Resources\TiposDocumentosCollection;
use App\Http\Resources\ResponsabilidadesFiscalesCollection;
use App\Http\Resources\EmpresasResource;

use App\Models\ResponsabilidadesFiscales;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\MediosPago;
use App\Models\Departamentos;
use App\Models\Gastos;
use App\Models\FormasPago;
use App\Models\Impresiones;
use App\Models\Autorizaciones;
use App\Models\Empresas;

use App\Models\TiposDocumentos;
use App\Models\TiposClientes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use Inertia\Inertia;

use App\Http\Controllers\Api\v1\DocumentoSoporteController;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resolucion = Autorizaciones::where('estado', 'A')->first();
        $empresa = Empresas::with('contacto')->first();

        if ( !$resolucion ) {
            return Inertia::render('Errors/Index', [
                'error' => 'Resolucion/Empty'
            ]);
        } else if ( !$empresa->contacto ) {
            return Inertia::render('Errors/Index', [
                'error' => 'Contactos/Empty'
            ]);
        }

        $query = Gastos::with(
            'proveedor', 'forma_pago', 'medio_pago', 'detalles.producto.impuestos.impuesto'
        );

        if ($request->q) {
            $query->where('id', 'LIKE', '%'.$request->q.'%')
            ->orWhere('created_at', 'LIKE', '%'.$request->q.'%')
            ->orWhereHas('proveedor', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%'.$request->q.'%')
                ->orWhere('direccion', 'LIKE', '%'.$request->q.'%')
                ->orWhere('celular', 'LIKE', '%'.$request->q.'%')
                ;
            });
        }

        if ( isset($_COOKIE['sort']) && isset($_COOKIE['icon']) ) {
            $query->orderBy( $_COOKIE['sort'], $_COOKIE['icon'] );
        }

        return Inertia::render('Gastos/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new GastosCollection(
                $query->whereDate('created_at', \Carbon\Carbon::today())
                ->paginate()
                ->appends(request()->query())
            ),
            'proveedores' => new ProveedoresCollection(
                Proveedores::orderBy('documento')->get()
            ),
            'q' => $request->q ?? '',
            'medios_pago' => new MediosPagoCollection(
                MediosPago::orderBy('descripcion')->get()
            ),
            'payments' => new FormasPagoCollection(
                FormasPago::orderBy('descripcion')->get()
            ),
            'departments' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Gastos/Detalle/Index', [
            'factura' => Gastos::with(
                'detalles.producto.impuestos.impuesto',
                'detalles.producto.inventario',
                'detalles.producto.color',
                'detalles.producto.medida',
                'proveedor'
            )
                ->find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Gastos/Edit', [
            'factura' => Gastos::with(
                'detalles.producto.impuestos.impuesto',
                'detalles.producto.inventario',
                'detalles.producto.color',
                'detalles.producto.medida',
                'detalles.producto.unidad_medida',
                'proveedor'
            )
            ->find($id),
            'referencias' => new ProductosCollection(
                Productos::orderBy('referencia')->get()
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pdf(string $id)
    {
        $gasto = Gastos::find($id);

        $data = [
            'empresa' => Empresas::with('contacto', 'tipo_doc', 'tipo', 'ciudad.departamento')->first(),
            'gasto' => $gasto,
        ];

        $impresion = Impresiones::first();

        if ( !$impresion || $impresion->forma == 'CAR') {
            $pdf = view('gasto', $data);
        } else if ( $impresion->forma == 'P80' ) {
            $pdf = view('gasto_pos_80', $data);
        }

        return $pdf;

        /*
        if ( !$impresion || $impresion->forma == 'CAR') {
            $pdf = \PDF::loadView('factura', $data);
        } else if ( $impresion->forma == 'P80' ) {
            $pdf = \PDF::loadView('factura_pos_80', $data);
        }

        return $pdf->download($factura->id.'.pdf');
        */
    }

    public function qr(string $id)
    {
        $factura = Gastos::find($id);

        if ( !$factura->transaccionID ) { 
            echo \QrCode::size(700)->generate(url('/gastos/pdf/'.$id));
        } else {
            $soap = new DocumentoSoporteController();
            $resource = $soap->qr( $id );

            echo \QrCode::size(700)->generate($resource->resourceData);

        }
    }

    
    public function configuracion() {
        $empresa = Empresas::first();

        if ( !$empresa->id ) {
            return Inertia::render('Errors/Index', [
                'error' => 'Empresa/Empty'
            ]);
        }

        return Inertia::render('Gastos/Configuracion/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contact' => new EmpresasResource(
                Empresas::with('tipo_doc', 'tipo', 'ciudad.departamento')->first()
            ),
            'tipoEmpresas' => new TiposClientesCollection(
                TiposClientes::orderBy('tipo')->get()
            ),
            'tipoDocumentos' => new TiposDocumentosCollection(
                TiposDocumentos::orderBy('tipo')->get()
            ),
            'departamentos' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),
            'responsabilidades' => new ResponsabilidadesFiscalesCollection(
                ResponsabilidadesFiscales::orderBy('descripcion')->get()
            ),
            'estados_autorizaciones' => config('constants.facturas.autorizaciones.estados'),
            'S_N' => config('constants.S_N'),
            'estados' => config('constants.estados'),
            'tenant_id' => 'tenant_' . tenant()->id
        ]);
    }
}
