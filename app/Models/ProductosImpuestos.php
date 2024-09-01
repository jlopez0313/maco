<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductosImpuestos extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'productos_impuestos';
    protected $guarded = [];

    public function impuesto()
    {
        return $this->hasOne(Impuestos::class, 'id', 'impuestos_id');
    }

    public function producto()
    {
        return $this->hasOne(Productos::class, 'id', 'productos_id');
    }
}
