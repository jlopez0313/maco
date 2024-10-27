<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\TiposClientesCollection;
use App\Http\Resources\EmpresasResource;
use App\Http\Resources\TiposDocumentosCollection;
use App\Http\Resources\DepartamentosCollection;
use App\Http\Resources\ResponsabilidadesFiscalesCollection;
use App\Models\ResponsabilidadesFiscales;
use App\Models\Resoluciones;
use App\Models\Departamentos;
use App\Models\TiposDocumentos;
use App\Models\TiposClientes;
use App\Models\Empresas;
use Inertia\Inertia;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Empresas/Index', [
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
            'estados_resoluciones' => config('constants.facturas.resoluciones.estados'),
            'S_N' => config('constants.S_N'),
            'estados' => config('constants.estados'),
            'tenant_id' => tenant()->id
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
