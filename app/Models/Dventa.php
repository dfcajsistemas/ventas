<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dventa extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //relación uno a muchos inversa
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

}
