<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'razon_social',
        'ndocumento',
        'correo',
        'telefono',
        'direccion',
        'referencia',
        'ubigeo',
        'estado',
        'tdocumento_id',
        'created_by',
        'updated_by',
    ];

    // Relación uno a muchos inversa
    public function tdocumento()
    {
        return $this->belongsTo(Tdocumento::class);
    }

    // Relación uno a muchos
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
