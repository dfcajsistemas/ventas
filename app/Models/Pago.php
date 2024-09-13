<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    //Relación uno a muchos inversa
    public function mpago()
    {
        return $this->belongsTo(Mpago::class);
    }
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
