<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\TiposDocumentosCollection;
use App\Models\TiposDocumentos;
use Inertia\Inertia;

class TiposDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = null;
        if ( isset($_COOKIE['sort']) && isset($_COOKIE['icon']) ) {
            $query = TiposDocumentos::orderBy( $_COOKIE['sort'], $_COOKIE['icon'] )->paginate();
        } else {
            $query = TiposDocumentos::paginate();
        }

        return Inertia::render('Parametros/TiposDocumentos/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new TiposDocumentosCollection(
                $query
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
