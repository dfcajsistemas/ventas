<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reposicion extends Model
{
    protected $fillable = [
        'cantidad',
        'lote',
        'observaciones',
        'producto_id',
        'sucursal_id',
        'created_by',
    ];
    use HasFactory;
}
