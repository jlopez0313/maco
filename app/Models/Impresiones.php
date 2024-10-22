<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impresiones extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'impresiones';
    protected $guarded = [];

    public function getFormaLabelAttribute() {

        // if ( isset($this->attributes['estado']) && $this->attributes['estado'] ) {
            $lista = config('constants.impresiones');
            $origenObj = \Arr::first($lista, function($val, $key) {
                return $val['key'] == $this->forma;
            });
            
            return $origenObj['valor'] ?? 'N/A';
        // }
        
    }
}
