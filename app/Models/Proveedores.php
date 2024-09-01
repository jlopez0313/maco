<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'proveedores';
    protected $guarded = [];

    public function ciudad() {
        return $this->hasOne(Ciudades::class, 'id', 'ciudad_id');
    }

    public function tipo_doc() {
        return $this->hasOne(TiposDocumentos::class, 'id', 'tipo_doc_id');
    }
}
