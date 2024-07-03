<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    //Relacion de uno a muchos
    public function users(){
        return $this->hasMany(User::class);
    }

    //Relacion uno a muchos inversa
    public function distrito(){
        return $this->belongsTo(Distrito::class);
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
