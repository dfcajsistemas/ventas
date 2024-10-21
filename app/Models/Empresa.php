<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'domicilio_fiscal',
        'rep_legal',
        'usuario_sol',
        'clave_sol',
        'distrito_id',
        'ubigeo',
        'certificado',
        'pass_certificado',
        'ven_certificado',
        'logo',
        'created_by',
        'updated_by'
    ];

    //relación uno a muchos inversa
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }
}
