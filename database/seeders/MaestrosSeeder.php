<?php

namespace Database\Seeders;

use App\Models\Igvafectacion;
use App\Models\Igvporciento;
use App\Models\Mpago;
use App\Models\Tcomprobante;
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

        Tcomprobante::create(['codigo'=>'tk', 'descripcion'=>'Ticket']);
        Tcomprobante::create(['codigo'=>'01', 'descripcion'=>'Factura']);
        Tcomprobante::create(['codigo'=>'03', 'descripcion'=>'Boleta de venta']);
        Tcomprobante::create(['codigo'=>'07', 'descripcion'=>'Nota de crédito', 'estado'=>null]);
        Tcomprobante::create(['codigo'=>'08', 'descripcion'=>'Nota de débito', 'estado'=>null]);
        Tcomprobante::create(['codigo'=>'09', 'descripcion'=>'Guía de remisión remitente', 'estado'=>null]);

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
