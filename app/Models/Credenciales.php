<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credenciales extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'credenciales';
    protected $guarded = [];

    public function getEstadoLabelAttribute() {

        // if ( isset($this->attributes['estado']) && $this->attributes['estado'] ) {
            $lista = config('constants.estados');
            $origenObj = \Arr::first($lista, function($val, $key) {
                return $val['key'] == $this->estado;
            });
            
            return $origenObj['valor'] ?? 'N/A';
        // }
        
    }
    
}
