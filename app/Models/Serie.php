<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'tcomprobante_id', 'sucursal_id', 'estado', 'created_by', 'updated_by'];

    //Relación uno a muchos inversa
    public function tcomprobante()
    {
        return $this->belongsTo(Tcomprobante::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
