<?php

namespace Database\Seeders;

use App\Models\Igvafectacion;
use App\Models\Igvporciento;
use App\Models\Umedida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Umedida::create(['descripcion' => 'BOBINAS', 'codigo' => '4A']);
        Umedida::create(['descripcion' => 'BALDE', 'codigo' => 'BJ']);
        Umedida::create(['descripcion' => 'BARRILES', 'codigo' => 'BLL']);
        Umedida::create(['descripcion' => 'BOLSA', 'codigo' => 'BG']);
        Umedida::create(['descripcion' => 'BOTELLAS', 'codigo' => 'BO']);
        Umedida::create(['descripcion' => 'CAJA', 'codigo' => 'BX']);
        Umedida::create(['descripcion' => 'CARTONES', 'codigo' => 'CT']);
        Umedida::create(['descripcion' => 'CENTIMETRO CUADRADO', 'codigo' => 'CMK']);
        Umedida::create(['descripcion' => 'CENTIMETRO CUBICO', 'codigo' => 'CMQ']);
        Umedida::create(['descripcion' => 'CENTIMETRO LINEAL', 'codigo' => 'CMT']);
        Umedida::create(['descripcion' => 'CIENTO DE UNIDADES', 'codigo' => 'CEN']);
        Umedida::create(['descripcion' => 'CILINDRO', 'codigo' => 'CY']);
        Umedida::create(['descripcion' => 'CONOS', 'codigo' => 'CJ']);
        Umedida::create(['descripcion' => 'DOCENA', 'codigo' => 'DZN']);
        Umedida::create(['descripcion' => 'DOCENA POR 10**6', 'codigo' => 'DZP']);
        Umedida::create(['descripcion' => 'FARDO', 'codigo' => 'BE']);
        Umedida::create(['descripcion' => 'GALON INGLES (4,545956L)', 'codigo' => 'GLI']);
        Umedida::create(['descripcion' => 'GRAMO', 'codigo' => 'GRM']);
        Umedida::create(['descripcion' => 'GRUESA', 'codigo' => 'GRO']);
        Umedida::create(['descripcion' => 'HECTOLITRO', 'codigo' => 'HLT']);
        Umedida::create(['descripcion' => 'HOJA', 'codigo' => 'LEF']);
        Umedida::create(['descripcion' => 'JUEGO', 'codigo' => 'SET']);
        Umedida::create(['descripcion' => 'KILOGRAMO', 'codigo' => 'KGM']);
        Umedida::create(['descripcion' => 'KILOMETRO', 'codigo' => 'KTM']);
        Umedida::create(['descripcion' => 'KILOVATIO HORA', 'codigo' => 'KWH']);
        Umedida::create(['descripcion' => 'KIT', 'codigo' => 'KT']);
        Umedida::create(['descripcion' => 'LATAS', 'codigo' => 'CA']);
        Umedida::create(['descripcion' => 'LIBRAS', 'codigo' => 'LBR']);
        Umedida::create(['descripcion' => 'LITRO', 'codigo' => 'LTR']);
        Umedida::create(['descripcion' => 'MEGAWATT HORA', 'codigo' => 'MWH']);
        Umedida::create(['descripcion' => 'METRO', 'codigo' => 'MTR']);
        Umedida::create(['descripcion' => 'METRO CUADRADO', 'codigo' => 'MTK']);
        Umedida::create(['descripcion' => 'METRO CUBICO', 'codigo' => 'MTQ']);
        Umedida::create(['descripcion' => 'MILIGRAMOS', 'codigo' => 'MGM']);
        Umedida::create(['descripcion' => 'MILILITRO', 'codigo' => 'MLT']);
        Umedida::create(['descripcion' => 'MILIMETRO', 'codigo' => 'MMT']);
        Umedida::create(['descripcion' => 'MILIMETRO CUADRADO', 'codigo' => 'MMK']);
        Umedida::create(['descripcion' => 'MILIMETRO CUBICO', 'codigo' => 'MMQ']);
        Umedida::create(['descripcion' => 'MILLARES', 'codigo' => 'MIL']);
        Umedida::create(['descripcion' => 'MILLON DE UNIDADES', 'codigo' => 'UM']);
        Umedida::create(['descripcion' => 'ONZAS', 'codigo' => 'ONZ']);
        Umedida::create(['descripcion' => 'PALETAS', 'codigo' => 'PF']);
        Umedida::create(['descripcion' => 'PAQUETE', 'codigo' => 'PK']);
        Umedida::create(['descripcion' => 'PAR', 'codigo' => 'PR']);
        Umedida::create(['descripcion' => 'PIES', 'codigo' => 'FOT']);
        Umedida::create(['descripcion' => 'PIES CUADRADOS', 'codigo' => 'FTK']);
        Umedida::create(['descripcion' => 'PIES CUBICOS', 'codigo' => 'FTQ']);
        Umedida::create(['descripcion' => 'PIEZAS', 'codigo' => 'C62']);
        Umedida::create(['descripcion' => 'PLACAS', 'codigo' => 'PG']);
        Umedida::create(['descripcion' => 'PLIEGO', 'codigo' => 'ST']);
        Umedida::create(['descripcion' => 'PULGADAS', 'codigo' => 'INH']);
        Umedida::create(['descripcion' => 'RESMA', 'codigo' => 'RM']);
        Umedida::create(['descripcion' => 'TAMBOR', 'codigo' => 'DR']);
        Umedida::create(['descripcion' => 'TONELADA CORTA', 'codigo' => 'STN']);
        Umedida::create(['descripcion' => 'TONELADA LARGA', 'codigo' => 'LTN']);
        Umedida::create(['descripcion' => 'TONELADAS', 'codigo' => 'TNE']);
        Umedida::create(['descripcion' => 'TUBOS', 'codigo' => 'TU']);
        Umedida::create(['descripcion' => 'UNIDAD (BIENES)', 'codigo' => 'NIU']);
        Umedida::create(['descripcion' => 'UNIDAD (SERVICIOS)', 'codigo' => 'ZZ']);
        Umedida::create(['descripcion' => 'US GALON (3,7843 L)', 'codigo' => 'GLL']);
        Umedida::create(['descripcion' => 'YARDA', 'codigo' => 'YRD']);
        Umedida::create(['descripcion' => 'YARDA CUADRADA', 'codigo' => 'YDK']);

       }
}
