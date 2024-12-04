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
            'ruc' => '20570886569',
            'razon_social' => 'GRANJA ORGANICA EL PARAISO E.I.R.L',
            'nom_comercial' => '-',
            'dom_fiscal' => 'NRO. SN FND. LA ARGENTINA (CD 8 DEL INCA INGRE 600 MT VOLT IZ 200MT) CAJAMARCA - CAJAMARCA - CAJAMARCA',
            'rep_legal' => 'ZAMBRANO GUERRERO MARIA EUGENIA',
            'usuario_sol' => 'mbdata',
            'clave_sol' => 'mbdata',
            'distrito_id' => 551,
        ]);
    }
}
