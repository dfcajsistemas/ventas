<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'imagen', 'estado', 'created_by', 'updated_by'];

    //Relacion uno a muchos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
