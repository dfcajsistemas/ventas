<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igvafectacion extends Model
{
    use HasFactory;

    //relaciones uno a muchos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
