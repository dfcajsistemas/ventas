<?php

namespace Database\Seeders;

use App\Models\Igvafectacion;
use App\Models\Igvporciento;
use App\Models\Mpago;
use App\Models\Tmoneda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaestrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Igvafectacion::create(['codigo' => '10', 'descripcion' => 'Gravado - Operación Onerosa', 'cod_tributo' => '1000']);
        Igvafectacion::create(['codigo' => '20', 'descripcion' => 'Exonerado - Operación Onerosa', 'cod_tributo' => '9997']);
        Igvafectacion::create(['codigo' => '30', 'descripcion' => 'Inafecto - Operación Onerosa', 'cod_tributo' => '9998']);

        Igvporciento::create(['porcentaje' => 18]);

        Tmoneda::create(['codigo'=>'PEN', 'descripcion'=>'Sol', 'simbolo'=>'S/']);
        Tmoneda::create(['codigo'=>'USD', 'descripcion'=>'US Dollar', 'simbolo'=>'$', 'estado'=>null]);

        Mpago::create(['nombre'=>'Efectivo']);
        Mpago::create(['nombre'=>'Tarjeta']);
        Mpago::create(['nombre'=>'Transferencia bancaria']);
        Mpago::create(['nombre'=>'Depósito en cuenta']);
        Mpago::create(['nombre'=>'Yape']);
        Mpago::create(['nombre'=>'Plin']);
    }
}
