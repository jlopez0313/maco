<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ConsecutivosRequest;
use App\Http\Resources\ConsecutivosResource;
use App\Models\Consecutivos;
use Inertia\Inertia;


class ConsecutivosController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $consecutivo = Consecutivos::create( $data );
        return new ConsecutivosResource( $consecutivo );
    }

    /**
     * Display the specified resource.
     */
    public function show(Consecutivos $consecutivo)
    {
        return new ConsecutivosResource( $consecutivo );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consecutivos $consecutivo)
    {
        $consecutivo->update( $request->all() );
        return new ConsecutivosResource( $consecutivo );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consecutivos $consecutivo)
    {
        $consecutivo->delete();
        return new ConsecutivosResource( $consecutivo );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function first($from)
    {
        return new ConsecutivosResource( Consecutivos::where('from', $from)->first() );
    }
}
