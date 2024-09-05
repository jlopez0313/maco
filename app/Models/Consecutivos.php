<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consecutivos extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'consecutivos';
    protected $guarded = [];
    
}
