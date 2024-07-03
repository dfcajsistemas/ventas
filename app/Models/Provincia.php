<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function distritos(){
        return $this->hasMany(Distrito::class);
    }
    //Relacion uno a muchos inversa
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
}
