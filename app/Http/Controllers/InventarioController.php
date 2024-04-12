<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\InventariosCollection;
use App\Http\Resources\ProductosCollection;
use App\Http\Resources\MedidasCollection;
use App\Http\Resources\ColoresCollection;
use App\Models\Inventarios;
use App\Models\Productos;
use App\Models\Colores;
use App\Models\Medidas;
use Inertia\Inertia;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventarios::orderBy('articulo');

        if( $request->q ) {
            $query->where('articulo', 'LIKE', '%' . $request->q . '%')
            ;
        }
        
        return Inertia::render('Inventario/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new InventariosCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'origenes' => config('constants.origenes')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $query = Productos::with('inventario', 'color', 'medida')
        ->where('inventarios_id', $id);
        
        if( $request->q ) {
            $query->where('referencia', 'LIKE', '%' . $request->q . '%')
            ->orWhereHas('color', function($q) use ($request) {
                $q->where('color', 'LIKE', '%' . $request->q . '%');
            })
            ;
        }

        return Inertia::render('Inventario/Edit', [
            'inventario' => Inventarios::find( $id ),
            'contacts' => new ProductosCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'colores' => new ColoresCollection(
                Colores::orderBy('color')
                ->get()
            ),
            'medidas' => new MedidasCollection(
                Medidas::orderBy('medida')
                ->get()
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
}
