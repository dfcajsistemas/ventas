<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'monto', 'fvence', 'estado', 'venta_id'];

    //relación uno a muchos inversa
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
