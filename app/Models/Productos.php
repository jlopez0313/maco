<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'productos';
    protected $guarded = [];

    public function inventario()
    {
        return $this->hasOne(Inventarios::class, 'id', 'inventarios_id');
    }

    public function color()
    {
        return $this->hasOne(Colores::class, 'id', 'colores_id');
    }

    public function medida()
    {
        return $this->hasOne(Medidas::class, 'id', 'medidas_id');
    }

    public function unidad_medida()
    {
        return $this->hasOne(UnidadesMedida::class, 'id', 'unidad_medida_id');
    }

    public function detalles()
    {
        return $this->hasMany(Detalles::class, 'productos_id');
    }

    public function impuestos()
    {
        return $this->hasMany(ProductosImpuestos::class, 'productos_id');
    }
}
