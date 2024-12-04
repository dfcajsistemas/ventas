<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventa extends Model
{
    use HasFactory;

    protected $fillable = [
        'est_venta',
        'est_anterior',
        'venta_id',
        'user_id',
    ];

    //relacion uno a muchos inversa
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
