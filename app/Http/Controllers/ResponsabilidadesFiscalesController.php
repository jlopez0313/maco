<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use App\Http\Resources\ResponsabilidadesFiscalesCollection;
use App\Models\ResponsabilidadesFiscales;
use Inertia\Inertia;

class ResponsabilidadesFiscalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = null;
        if ( isset($_COOKIE['sort']) && isset($_COOKIE['icon']) ) {
            $query = ResponsabilidadesFiscales::orderBy( $_COOKIE['sort'], $_COOKIE['icon'] )->paginate();
        } else {
            $query = ResponsabilidadesFiscales::paginate();
        }

        return Inertia::render('Parametros/ResponsabilidadesFiscales/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new ResponsabilidadesFiscalesCollection(
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
