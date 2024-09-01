<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsabilidadesFiscales extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'responsabilidades_fiscales';
    protected $guarded = [];
}
