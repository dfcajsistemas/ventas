<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'direccion', 'telefono', 'cod_sunat', 'p_venta', 'estado', 'created_by', 'updated_by', 'distrito_id', 'empresa_id'];

    //Relacion de uno a muchos
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function series()
    {
        return $this->hasMany(Serie::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function cajas()
    {
        return $this->hasMany(Caja::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    //Relacion uno a muchos inversa
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
