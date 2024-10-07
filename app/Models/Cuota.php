<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $fillable = ['monto', 'fvence', 'estado', 'venta_id', 'created_by', 'updated_by'];

    //relación uno a muchos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    //relación uno a muchos inversa
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
