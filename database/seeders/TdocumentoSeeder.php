<?php

namespace Database\Seeders;

use App\Models\Tdocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TdocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tdocumento::create(['codigo'=>'0','descripcion'=>'DOC.TRIB.NO.DOM.SIN.RUC','abreviatura'=>'SIN DOC','estado'=>0]);
        Tdocumento::create(['codigo'=>'1','descripcion'=>'Documento Nacional de Identidad','abreviatura'=>'DNI','estado'=>1]);
        Tdocumento::create(['codigo'=>'4','descripcion'=>'Carnet de extranjería','abreviatura'=>'CARNET EXT.','estado'=>1]);
        Tdocumento::create(['codigo'=>'6','descripcion'=>'Registro Unico de Contributentes','abreviatura'=>'RUC','estado'=>1]);
        Tdocumento::create(['codigo'=>'7','descripcion'=>'Pasaporte','abreviatura'=>'PASAPORTE','estado'=>1]);
        Tdocumento::create(['codigo'=>'A','descripcion'=>'Cédula Diplomática de identidad','abreviatura'=>'CÉDULA DIP.','estado'=>0]);
        Tdocumento::create(['codigo'=>'B','descripcion'=>'DOC.IDENT.PAIS.RESIDENCIA-NO.D','abreviatura'=>'DOC.IDENT.PAIS.RESIDENCIA-NO.D','estado'=>0]);
        Tdocumento::create(['codigo'=>'C','descripcion'=>'Tax Identification Number - TIN – Doc Trib PP.NN','abreviatura'=>'TIN – Doc Trib PP.NN','estado'=>0]);
        Tdocumento::create(['codigo'=>'D','descripcion'=>'Identification Number - IN – Doc Trib PP. JJ','abreviatura'=>'IN – Doc Trib PP. JJ','estado'=>0]);
        Tdocumento::create(['codigo'=>'E','descripcion'=>'TAM- Tarjeta Andina de Migración','abreviatura'=>'TAM','estado'=>0]);

    }
}
