<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impuestos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'impuestos';
    protected $guarded = [];
    protected $appends = ['tipo_tarifa_label', 'tipo_impuesto_label'];

    public function getTipoTarifaLabelAttribute()
    {
        $lista = config('constants.impuestos.tarifas');
        $origenObj = \Arr::first($lista, function ($val, $key) {
            return $val['key'] == $this->tipo_tarifa;
        });

        return $origenObj['valor'] ?? 'N/A';
    }

    public function getTipoImpuestoLabelAttribute()
    {
        $lista = config('constants.impuestos.tipos');
        $origenObj = \Arr::first($lista, function ($val, $key) {
            return $val['key'] == $this->tipo_impuesto;
        });

        return $origenObj['valor'] ?? 'N/A';
    }
}
