<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::create([
            'ruc' => '20202020202',
            'razon_social' => 'Empresa SAC',
            'nom_comercial' => 'Empresa',
            'dom_fiscal' => 'Av. Perú 123',
            'rep_legal' => 'Juan Perez',
            'usuario_sol' => 'mbdata',
            'clave_sol' => 'mbdata',
            'distrito_id' => 551,
        ]);
    }
}
