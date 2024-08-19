<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpago extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estado', 'created_by', 'updated_by'];

    // Relación uno a muchos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
