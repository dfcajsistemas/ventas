<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        $this->call(UbigeoSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(TdocumentoSeeder::class);
        $this->call(UmedidaSeeder::class);
        $this->call(MaestrosSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(ClientesSeeder::class);

        User::factory()->create([
            'name' => 'Admin',
            'tdocumento_id' => '2',
            'ndocumento' => '44444444',
            'email' => 'admin@gmail.com',
            'fec_nac' => '1990-01-01',
            'password' => bcrypt('12345678'),
            'sucursal_id' => 1
        ])->assignRole('Accesos admin', 'Mantenimiento admin', 'Abastecimiento admin', 'Despacho admin', 'Caja admin', 'Delivery admin', 'Reportes admin');
        User::factory()->create([
            'name' => 'Maquena Zambrano',
            'tdocumento_id' => '2',
            'ndocumento' => '26702433',
            'email' => 'maquena@gmail.com',
            'fec_nac' => '1990-01-01',
            'password' => bcrypt('060203Maryfe'),
            'sucursal_id' => 1
        ])->assignRole('Accesos admin', 'Mantenimiento admin', 'Abastecimiento admin', 'Despacho admin', 'Caja admin', 'Delivery admin', 'Reportes admin');
        User::factory()->create([
            'name' => 'María José',
            'tdocumento_id' => '2',
            'ndocumento' => '70724487',
            'email' => 'mariajose@gmail.com',
            'fec_nac' => '2000-01-01',
            'password' => bcrypt('Moni362427'),
            'sucursal_id' => 2
        ])->assignRole('Accesos admin', 'Mantenimiento admin', 'Abastecimiento admin', 'Despacho admin', 'Caja admin', 'Delivery admin', 'Reportes admin');
        User::factory()->create([
            'name' => 'Angélica Elena Narváez del Rio',
            'tdocumento_id' => '2',
            'ndocumento' => '41893544',
            'email' => 'elena@gmail.com',
            'fec_nac' => '1990-01-01',
            'password' => bcrypt('Granja2024'),
            'sucursal_id' => 1
        ])->assignRole('Accesos admin', 'Mantenimiento admin', 'Abastecimiento admin', 'Despacho admin', 'Caja admin', 'Delivery admin', 'Reportes admin');
    }
}
