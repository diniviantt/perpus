<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission::create(['name' => 'create-data']);
        // Permission::create(['name' => 'read-data']);
        // Permission::create(['name' => 'update-data']);
        // Permission::create(['name' => 'delete-data']);

        $admin = Role::create(['name' => 'admin']);
        // $admin->givePermissionTo('create-data');
        // $admin->givePermissionTo('read-data');
        // $admin->givePermissionTo('update-data');
        // $admin->givePermissionTo('delete-data');

        $user = Role::create(['name' => 'user']);
        // $user->givePermissionTo('read-data');

        $petugas = Role::create(['name' => 'petugas']);
    }
}
