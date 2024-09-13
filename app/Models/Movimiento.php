<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    //relación uno a muchos inversa
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
