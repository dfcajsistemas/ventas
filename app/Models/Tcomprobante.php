<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tcomprobante extends Model
{
    use HasFactory;

    //Relación uno a muchos
    public function series()
    {
        return $this->hasMany(Serie::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
