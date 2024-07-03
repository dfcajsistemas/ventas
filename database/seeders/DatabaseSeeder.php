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


        User::factory()->create([
            'name' => 'Admin',
            'doc_tipo' => '1',
            'doc_numero' => '11111111',
            'email' => 'deargerard@hotmail.com',
            'fec_nac' => '1979-12-07',
            'password' => bcrypt('12345678'),
            'sucursal_id' => 1
        ])->assignRole('accesos admin');

        User::factory(50)->create();
    }
}
