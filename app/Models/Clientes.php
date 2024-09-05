<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'clientes';
    protected $guarded = [];

    public function ciudad() {
        return $this->hasOne(Ciudades::class, 'id', 'ciudad_id');
    }
    
    public function tipo() {
        return $this->hasOne(TiposClientes::class, 'id', 'tipo_id');
    }

    public function tipo_doc() {
        return $this->hasOne(TiposDocumentos::class, 'id', 'tipo_doc_id');
    }

    public function responsabilidad() {
        return $this->hasOne(ResponsabilidadesFiscales::class, 'id', 'responsabilidad_fiscal_id');
    }

    public function contactos() {
        return $this->hasMany(Contactos::class, 'clientes_id');
    }

    public function contacto() {
        return $this->hasOne(Contactos::class, 'clientes_id')->where('principal', 'S');
    }
}
