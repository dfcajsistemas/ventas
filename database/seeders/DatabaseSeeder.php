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

        User::factory()->create([
            'name' => 'Admin',
            'tdocumento_id' => '2',
            'ndocumento' => '44444444',
            'email' => 'admin@gmail.com',
            'fec_nac' => '1990-01-01',
            'password' => bcrypt('12345678'),
            'sucursal_id' => 1
        ])->assignRole('accesos admin', 'mantenimiento admin');

        User::factory(50)->create();
    }
}
