<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImpuestosCollection;
use App\Models\Impuestos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Peticion;
use Inertia\Inertia;

class ImpuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = null;
        if ( isset($_COOKIE['sort']) && isset($_COOKIE['icon']) ) {
            $query = Impuestos::orderBy( $_COOKIE['sort'], $_COOKIE['icon'] )->paginate();
        } else {
            $query = Impuestos::paginate();
        }

        return Inertia::render('Parametros/Impuestos/Index', [
            'filters' => Peticion::all('search', 'trashed'),
            'contacts' => new ImpuestosCollection(
                $query
            ),
            'impuestos_tarifas' => config('constants.impuestos.tarifas'),
            'impuestos_tipos' => config('constants.impuestos.tipos'),
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
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
