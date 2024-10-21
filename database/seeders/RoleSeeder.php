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
        $accesos = Role::create(['name' => 'Accesos admin']);
        $mantenimiento = Role::create(['name' => 'Mantenimiento admin']);
        $abastecimiento = Role::create(['name' => 'Abastecimiento admin']);
        $despacho = Role::create(['name' => 'Despacho admin']);
        $caja = Role::create(['name' => 'Caja admin']);
        $delivery = Role::create(['name' => 'Delivery admin']);
        $reportes = Role::create(['name' => 'Reportes admin']);

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
        Permission::create(['name' => 'mantenimiento.empresas.editarlogo'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.empresas.editarsunat'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.empresas.editarcertificado'])->syncRoles($mantenimiento);

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

        Permission::create(['name' => 'mantenimiento.mpagos'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.mpagos.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.mpagos.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.mpagos.estado'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.mpagos.eliminar'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.clientes'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.clientes.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.clientes.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.clientes.estado'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'mantenimiento.series'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.series.agregar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.series.editar'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.series.estado'])->syncRoles($mantenimiento);
        Permission::create(['name' => 'mantenimiento.series.eliminar'])->syncRoles($mantenimiento);

        Permission::create(['name' => 'abastecimiento'])->syncRoles($abastecimiento);
        Permission::create(['name' => 'abastecimiento.productos'])->syncRoles($abastecimiento);
        Permission::create(['name' => 'abastecimiento.productos.stock'])->syncRoles($abastecimiento);
        Permission::create(['name' => 'abastecimiento.productos.reposiciones'])->syncRoles($abastecimiento);
        Permission::create(['name' => 'abastecimiento.productos.reposiciones.agregar'])->syncRoles($abastecimiento);
        Permission::create(['name' => 'abastecimiento.productos.reposiciones.eliminar'])->syncRoles($abastecimiento);

        Permission::create(['name' => 'despacho'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.canasta'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.distribuir'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.eliminar'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.canasta.agregar'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.canasta.cantidad'])->syncRoles($despacho);
        Permission::create(['name' => 'despacho.pedidos.canasta.eliminar'])->syncRoles($despacho);

        Permission::create(['name' => 'caja'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.agregar'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.eliminar'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.movimiento'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.cerrar'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.cobrar'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.cobrar.pago'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.cobrar.precio'])->assignRole($caja);
        Permission::create(['name' => 'caja.cajas.ver.cobrar.credito'])->assignRole($caja);

        Permission::create(['name' => 'delivery'])->assignRole($delivery);
        Permission::create(['name' => 'delivery.pedidos'])->assignRole($delivery);
        Permission::create(['name' => 'delivery.pedidos.entregar'])->assignRole($delivery);
        Permission::create(['name' => 'delivery.misentregas'])->assignRole($delivery);

        Permission::create(['name' => 'reportes'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.ventas'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.cuentascobrar'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.inventario'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.ventascliente'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.flujocajas'])->assignRole($reportes);
        Permission::create(['name' => 'reportes.ventaproductos'])->assignRole($reportes);
    }
}
