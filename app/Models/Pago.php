<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto',
        'observacion',
        'mpago_id',
        'caja_id',
        'venta_id',
        'creted_by'
    ];

    //Relación uno a muchos inversa
    public function mpago()
    {
        return $this->belongsTo(Mpago::class);
    }
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
