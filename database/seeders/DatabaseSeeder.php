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

        User::factory()->create([
            'name' => 'Gerardo Severino',
            'surname' => 'Intor Osorio',
            'doc_tipo' => '1',
            'doc_numero' => '40450444',
            'sexo' => '1',
            'email' => 'deargerard@hotmail.com',
            'fec_nac' => '1979-12-07',
            'est_civil' => '2',
            'gru_san' => 'O+',
            'cuenta_bn' => '193-200000000-0',
            'password' => bcrypt('12345678'),
            'distrito_id' => '551'
        ])->assignRole('accesos admin');
    }
}
