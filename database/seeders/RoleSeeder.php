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
        $accesos = Role::create(['name' => 'accesos admin']);
        $mantenimiento = Role::create(['name' => 'mantenimiento admin']);

        Permission::create(['name' => 'accesos'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.agregar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.editar'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.estado'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.password'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.roles'])->assignRole($accesos);
        Permission::create(['name' => 'accesos.users.roles.asignar'])->assignRole($accesos);
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

        Permission::create(['name' => 'mantenimiento'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.empresas'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.empresas.editardatos'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.empresas.editarsunat'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.sucursals'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.sucursals.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.sucursals.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.sucursals.estado'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.categorias'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.categorias.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.categorias.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.categorias.estado'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.categorias.eliminar'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.productos'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.productos.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.productos.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.productos.estado'])->syncRoles($mantenimiento);




    }
}
