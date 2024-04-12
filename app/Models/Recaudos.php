<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recaudos extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'recaudos';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i A',
    ];

    public function factura() {
        return $this->hasOne(Facturas::class, 'id', 'facturas_id');
    }

    public function getCreatedAtAttribute( $date ) {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }

    protected function serializeDate($date): string {
        return $date->format('Y-m-d H:i:s');
    }
    
}
