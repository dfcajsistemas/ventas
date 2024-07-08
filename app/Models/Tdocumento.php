<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdocumento extends Model
{
    use HasFactory;

    //Relación uno a muchos
    public function users(){
        return $this->hasMany(User::class);
    }
}
