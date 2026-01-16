<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',

            'pacientes.ver',
            'pacientes.crear',
            'pacientes.editar',

            'archivos.subir',
            'archivos.ver',
            'archivos.descargar',
            'archivos.eliminar',

            'facturas.generar',
            'facturas.ver',
            'facturas.descargar',

            'pagos.crear',
            'pagos.ver',

            'reportes.ver',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $medico = Role::firstOrCreate([
            'name' => 'medico',
            'guard_name' => 'web',
        ]);

        $paciente = Role::firstOrCreate([
            'name' => 'paciente',
            'guard_name' => 'web',
        ]);

        Permission::all()->each(
            fn($permission) =>
            $permission->assignRole($admin)
        );

        Permission::whereIn('name', [
            'pacientes.ver',
            'pacientes.crear',
            'pacientes.editar',
            'archivos.subir',
            'archivos.ver',
            'archivos.descargar',
            'facturas.generar',
            'facturas.ver',
            'pagos.ver',
            'reportes.ver',
        ])->each(
            fn($permission) =>
            $permission->assignRole($medico)
        );

        Permission::whereIn('name', [
            'archivos.ver',
            'archivos.descargar',
            'facturas.ver',
            'facturas.descargar',
            'pagos.ver',
        ])->each(
            fn($permission) =>
            $permission->assignRole($paciente)
        );
    }
}
