<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accesos=Role::create(['name' => 'accesos admin']);

        Permission::create(['name' => 'accesos'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.user'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.user.password'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.user.roles'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.user.roles.asignar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles.agregar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles.editar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles.eliminar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles.permisos'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.roles.permisos.asignar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.permisos'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.permisos.agregar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.permisos.editar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.permisos.eliminar'])->assignRole($accesos);

    }
}
