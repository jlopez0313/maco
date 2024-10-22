<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CredencialesRequest;
use App\Http\Resources\CredencialesResource;
use App\Models\Credenciales;
use Inertia\Inertia;


class CredencialesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index(Request $request)
    {
        return CredencialesResource::collection(
            Credenciales::all()
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->estado == 'A') {
            Credenciales::query()->update(['estado' => 'I']);
        }

        $data = $request->all();
        $credenciale = Credenciales::create( $data );
        return new CredencialesResource( $credenciale );
    }

    /**
     * Display the specified resource.
     */
    public function show(Credenciales $credenciale)
    {
        return new CredencialesResource( $credenciale );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credenciales $credenciale)
    {
        if ($request->estado == 'A') {
            Credenciales::where('id', '!=', $request->id)->update(['estado' => 'I']);
        }

        $credenciale->update( $request->all() );
        return new CredencialesResource( $credenciale );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credenciales $credenciale)
    {
        $credenciale->delete();
        return new CredencialesResource( $credenciale );
    }
}
