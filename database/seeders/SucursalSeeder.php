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
        $sucursal = Sucursal::create([
            'nombre' => 'Tienda Cajamarca',
            'direccion' => 'Fundo Argentina',
            'telefono' => '911111111',
            'cod_sunat' => '0001',
            'p_venta' => 1,
            'empresa_id' => 1,
            'distrito_id' => 551,
        ]);

        Sucursal::create([
            'nombre' => 'Tienda Lima 1',
            'direccion' => 'Av. Lima 123',
            'telefono' => '911111112',
            'cod_sunat' => '0002',
            'p_venta' => 2,
            'empresa_id' => 1,
            'distrito_id' => 1249,
        ]);
    }
}
