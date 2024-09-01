<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColoresCollection;
use App\Http\Resources\ImpuestosCollection;
use App\Http\Resources\InventariosCollection;
use App\Http\Resources\MedidasCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\UnidadesMedidaCollection;
use App\Models\UnidadesMedida;
use App\Models\Colores;
use App\Models\Impuestos;
use App\Models\Inventarios;
use App\Models\Medidas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use Inertia\Inertia;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventarios::orderBy('articulo');

        if ($request->q) {
            $query->where('articulo', 'LIKE', '%'.$request->q.'%')
            ;
        }

        return Inertia::render('Inventario/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new InventariosCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'origenes' => config('constants.origenes'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $query = Productos::with('inventario', 'color', 'medida', 'impuestos.impuesto')
        ->where('inventarios_id', $id);

        if ($request->q) {
            $query->where('referencia', 'LIKE', '%'.$request->q.'%')
            ->orWhereHas('color', function ($q) use ($request) {
                $q->where('color', 'LIKE', '%'.$request->q.'%');
            })
            ;
        }

        return Inertia::render('Inventario/Productos/Index', [
            'inventario' => Inventarios::find($id),
            'contacts' => new ProductosCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'colores' => new ColoresCollection(
                Colores::orderBy('color')
                ->get()
            ),
            'unidades_medida' => new UnidadesMedidaCollection(
                UnidadesMedida::orderBy('descripcion')
                ->get()
            ),
            'medidas' => new MedidasCollection(
                Medidas::orderBy('medida')
                ->get()
            ),
            'impuestos' => new ImpuestosCollection(
                Impuestos::where('tipo_impuesto', 'I')
                ->orderBy('concepto')
                ->get()
            ),
            'retenciones' => new ImpuestosCollection(
                Impuestos::where('tipo_impuesto', 'R')
                ->orderBy('concepto')
                ->get()
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
