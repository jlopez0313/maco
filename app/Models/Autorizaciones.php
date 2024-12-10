<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autorizaciones extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'autorizaciones';
    protected $guarded = [];
    protected $appends = ['estado_label'];

    public function empresa() {
        return $this->hasOne(Empresas::class, 'id', 'empresas_id');
    }

    public function getEstadoLabelAttribute() {

        $lista = config('constants.facturas.autorizaciones.estados');
        $origenObj = \Arr::first($lista, function($val, $key) {
            return $val['key'] == $this->estado;
        });
        
        return $origenObj['valor'] ?? 'N/A';
    }
    
}
