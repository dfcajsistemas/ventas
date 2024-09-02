<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock',
        'stock_minimo',
        'producto_id',
        'sucursal_id',
        'created_by',
        'updated_by'
    ];

    //relacion uno a muchos inversa
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
