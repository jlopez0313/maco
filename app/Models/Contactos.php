<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactos extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'contactos';
    protected $guarded = [];
    protected $appends = ['principal_label'];

    public function empresa() {
        return $this->hasOne(Empresas::class, 'id', 'empresas_id');
    }

    public function getPrincipalLabelAttribute() {

        // if ( isset($this->attributes['estado']) && $this->attributes['estado'] ) {
            $lista = config('constants.S_N');
            $origenObj = \Arr::first($lista, function($val, $key) {
                return $val['key'] == $this->principal;
            });
            
            return $origenObj['valor'] ?? 'N/A';
        // }
        
    }
    
}
