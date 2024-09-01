<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadesMedida extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'unidades_medidas';
    protected $guarded = [];
}
