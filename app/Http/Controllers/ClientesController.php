<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\ClientesCollection;
use App\Http\Resources\ClientesResource;
use App\Http\Resources\TiposClientesCollection;
use App\Http\Resources\DepartamentosCollection;
use App\Http\Resources\TiposDocumentosCollection;
use App\Http\Resources\ResponsabilidadesFiscalesCollection;
use App\Models\ResponsabilidadesFiscales;
use App\Models\TiposDocumentos;
use App\Models\Clientes;
use App\Models\TiposClientes;
use App\Models\Departamentos;
use Inertia\Inertia;


class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Clientes::with(
            'tipo', 
            'tipo_doc', 
            'ciudad',
            'ciudad.departamento'
        );
        
        if( $request->q ) {
            $query->where('documento', 'LIKE', '%' . $request->q . '%')
            ->orWhere('nombre', 'LIKE', '%' . $request->q . '%')
            ->orWhere('direccion', 'LIKE', '%' . $request->q . '%')
            ->orWhere('celular', 'LIKE', '%' . $request->q . '%')
            ;
        }

        return Inertia::render('Clientes/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new ClientesCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clientes/Form', [
            'departamentos' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),
            'responsabilidades' => new ResponsabilidadesFiscalesCollection(
                ResponsabilidadesFiscales::orderBy('descripcion')->get()
            ),
            'tipoClientes' => new TiposClientesCollection(
                TiposClientes::orderBy('tipo')->get()
            ),
            'tipoDocumentos' => new TiposDocumentosCollection(
                TiposDocumentos::orderBy('tipo')->get()
            ),
            'S_N' => config('constants.S_N'),
        ]);
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
        return Inertia::render('Clientes/Form', [
            'departamentos' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),
            'responsabilidades' => new ResponsabilidadesFiscalesCollection(
                ResponsabilidadesFiscales::orderBy('descripcion')->get()
            ),
            'tipoClientes' => new TiposClientesCollection(
                TiposClientes::orderBy('tipo')->get()
            ),
            'tipoDocumentos' => new TiposDocumentosCollection(
                TiposDocumentos::orderBy('tipo')->get()
            ),
            'contact' => new ClientesResource(
                Clientes::with('contactos')
                ->find( $id )
            ),
            'S_N' => config('constants.S_N'),
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
