<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['apertura', 'cierre', 'user_id', 'sucursal_id'];

    //relación uno a muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relación uno a muchos
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
