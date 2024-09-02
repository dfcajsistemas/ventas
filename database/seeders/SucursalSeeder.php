<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\Sucursal;
use App\Models\Tcomprobante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursal=Sucursal::create([
            'nombre' => 'Principal',
            'direccion' => 'Av. Prueba 123',
            'telefono' => '123456789',
            'cod_sunat' => '0001',
            'p_venta' => 1,
            'empresa_id' => 1,
            'distrito_id' => 561,
        ]);

    }
}
