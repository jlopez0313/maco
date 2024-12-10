<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gastos extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'gastos';
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i A',
    ];
    
    public function detalles() {
        return $this->hasMany(Detalles::class, 'gastos_id');
    }

    public function proveedor() {
        return $this->hasOne(Proveedores::class, 'id', 'proveedores_id');
    }

    public function forma_pago() {
        return $this->hasOne(FormasPago::class, 'id', 'forma_pago_id');
    }

    public function medio_pago() {
        return $this->hasOne(MediosPago::class, 'id', 'medio_pago_id');
    }

    public function getCreatedAtAttribute( $date ) {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }

    protected function serializeDate($date): string {
        return $date->format('Y-m-d H:i:s');
    }

    public function getEstadoLabelAttribute() {

        // if ( isset($this->attributes['estado']) && $this->attributes['estado'] ) {
            $lista = config('constants.facturas.estados');
            $origenObj = \Arr::first($lista, function($val, $key) {
                return $val['key'] == $this->estado;
            });
            
            return $origenObj['valor'] ?? 'N/A';
        // }
        
    }

}
