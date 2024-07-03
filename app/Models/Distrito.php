<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function empresas(){
        return $this->hasMany(Empresa::class);
    }
    public function sucursales(){
        return $this->hasMany(Sucursal::class);
    }

    //Relacion uno a muchos inversa
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }

}
