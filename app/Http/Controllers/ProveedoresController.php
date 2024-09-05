<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\ProveedoresResource;
use App\Http\Resources\ProveedoresCollection;
use App\Http\Resources\DepartamentosCollection;
use App\Http\Resources\TiposClientesCollection;
use App\Http\Resources\TiposDocumentosCollection;
use App\Http\Resources\ResponsabilidadesFiscalesCollection;
use App\Models\ResponsabilidadesFiscales;
use App\Models\TiposDocumentos;
use App\Models\Proveedores;
use App\Models\TiposClientes;
use App\Models\Departamentos;
use Inertia\Inertia;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Proveedores::with(
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

        return Inertia::render('Proveedores/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'departamentos' => new DepartamentosCollection(
                Departamentos::orderBy('departamento')->get()
            ),            
            'contacts' => new ProveedoresCollection(
                $query->paginate()->appends(request()->query())
            ),
            'q' => $request->q ?? '',
            'tipos_doc' => config('constants.tipo_doc')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Proveedores/Form', [
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
        return Inertia::render('Proveedores/Form', [
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
            'contact' => new ProveedoresResource(
                Proveedores::with('contactos')
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
