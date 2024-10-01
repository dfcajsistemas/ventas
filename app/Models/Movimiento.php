<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'concepto', 'monto', 'caja_id'];

    //relación uno a muchos inversa
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
