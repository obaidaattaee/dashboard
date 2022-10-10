<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'show general settings', 'guard_name' => 'web', 'group_name' => 'settings'],
            ['name' => 'edit general settings', 'guard_name' => 'web', 'group_name' => 'settings'],
            ['name' => 'show roles list', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'add role', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'edit role', 'guard_name' => 'web', 'group_name' => 'roles'],
        ];

        $roles = [
            ['name' => 'super_admin', 'guard_name' => 'web'],
        ];

        Schema::disableForeignKeyConstraints();

        Permission::truncate();
        Permission::insert($permissions);

        Role::truncate();

        $permissionIds = Permission::pluck('id')->toArray();

        foreach ($roles as $role) {
            $role = Role::create($role);

            $role->givePermissionTo($permissionIds);
        }

        Schema::enableForeignKeyConstraints();

    }
}
