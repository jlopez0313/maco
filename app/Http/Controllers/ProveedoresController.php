<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\ProveedoresCollection;
use App\Http\Resources\DepartamentosCollection;
use App\Models\Proveedores;
use App\Models\Departamentos;
use Inertia\Inertia;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Proveedores/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'departamentos' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),            
            'contacts' => new ProveedoresCollection(
                Proveedores::with(
                    'ciudad',
                    'ciudad.departamento'
                )->paginate()
            ),
            'tipos_doc' => config('constants.tipo_doc')
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
    public function edit(string $id)
    {
        //
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
