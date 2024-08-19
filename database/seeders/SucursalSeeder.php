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
            'empresa_id' => 1,
            'distrito_id' => 561,
        ]);

        $t=Tcomprobante::create(['codigo'=>'tk', 'descripcion'=>'Ticket']);
        $f=Tcomprobante::create(['codigo'=>'01', 'descripcion'=>'Factura']);
        $b=Tcomprobante::create(['codigo'=>'03', 'descripcion'=>'Boleta de venta']);
        $nc=Tcomprobante::create(['codigo'=>'07', 'descripcion'=>'Nota de crédito', 'estado'=>null]);
        $nd=Tcomprobante::create(['codigo'=>'08', 'descripcion'=>'Nota de débito', 'estado'=>null]);
        $gr=Tcomprobante::create(['codigo'=>'09', 'descripcion'=>'Guía de remisión remitente', 'estado'=>null]);

        Serie::create(['serie' => 'TP01', 'correlativo' => 0, 'tcomprobante_id' => $t->id, 'sucursal_id' => $sucursal->id]);
        Serie::create(['serie' => 'FP01', 'correlativo' => 0, 'tcomprobante_id' => $f->id, 'sucursal_id' => $sucursal->id]);
        Serie::create(['serie' => 'BP01', 'correlativo' => 0, 'tcomprobante_id' => $b->id, 'sucursal_id' => $sucursal->id]);
        Serie::create(['serie' => 'NC01', 'correlativo' => 0, 'tcomprobante_id' => $nc->id, 'sucursal_id' => $sucursal->id, 'estado' => null]);
        Serie::create(['serie' => 'ND01', 'correlativo' => 0, 'tcomprobante_id' => $nd->id, 'sucursal_id' => $sucursal->id, 'estado' => null]);
        Serie::create(['serie' => 'GR01', 'correlativo' => 0, 'tcomprobante_id' => $gr->id, 'sucursal_id' => $sucursal->id, 'estado' => null]);
    }
}
