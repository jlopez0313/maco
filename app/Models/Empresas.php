<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'empresas';
    protected $guarded = [];

    public function ciudad() {
        return $this->hasOne(Ciudades::class, 'id', 'ciudad_id');
    }
    
    public function tipo() { // Tipo de Persona
        return $this->hasOne(TiposClientes::class, 'id', 'tipo_id');
    }

    public function tipo_doc() { // Tipo de Documento
        return $this->hasOne(TiposDocumentos::class, 'id', 'tipo_doc_id');
    }

    public function responsabilidad() { // Responsabilidad Jurídica
        return $this->hasOne(ResponsabilidadesFiscales::class, 'id', 'responsabilidad_fiscal_id');
    }

    public function contactos() {
        return $this->hasMany(Contactos::class, 'empresas_id');
    }

    public function contacto() {
        return $this->hasOne(Contactos::class, 'empresas_id')->where('principal', 'S');
    }

    public function resoluciones() {
        return $this->hasMany(Resoluciones::class, 'empresas_id');
    }

    public function resolucion() {
        return $this->hasOne(Resoluciones::class, 'empresas_id')->where('estado', 'A');
    }

    public function autorizaciones() {
        return $this->hasMany(Autorizaciones::class, 'empresas_id');
    }

    public function autorizacion() {
        return $this->hasOne(Autorizaciones::class, 'empresas_id')->where('estado', 'A');
    }
}
