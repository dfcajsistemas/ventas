<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sucursal::create([
            'nombre' => 'Sucursal principal',
            'direccion' => 'Av. Prueba 123',
            'telefono' => '123456789',
            'cod_sunat' => '0001',
            'empresa_id' => 1,
            'distrito_id' => 561,
        ]);
    }
}
