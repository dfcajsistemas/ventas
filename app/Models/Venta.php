<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;

    //relación uno a muchos
    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('cantidad','precio','igv','icbper', 'descuento', 'total');
    }
}
