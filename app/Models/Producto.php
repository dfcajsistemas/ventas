<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'slug',
        'codigo',
        'descripcion',
        'icbper',
        'p_costo',
        'p_venta1',
        'p_venta2',
        'p_venta3',
        'umedida_id',
        'categoria_id',
        'igvafectacion_id',
        'igvporciento_id',
        'estado',
        'created_by',
        'updated_by'
    ];

    //relación uno a muchos
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    //Relacion uno a muchos inversa
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function umedida()
    {
        return $this->belongsTo(Umedida::class);
    }
    public function igvafectacion()
    {
        return $this->belongsTo(Igvafectacion::class);
    }
    public function igvporciento()
    {
        return $this->belongsTo(Igvporciento::class);
    }

    //relación uno a muchos
    public function dventas()
    {
        return $this->hasMany(Dventa::class);
    }


}
