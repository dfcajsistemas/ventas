<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;

    //relación uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function tcomprobante()
    {
        return $this->belongsTo(Tcomprobante::class);
    }

    //relación uno a muchos
    public function dventas()
    {
        return $this->hasMany(Dventa::class);
    }
    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    public function eventas()
    {
        return $this->hasMany(Eventa::class);
    }
}
