<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'panelist', 'secretary', 'student'];

        foreach ($roles as $r) {
            $role = Role::create(['name' => $r]);
            $createPermission = Permission::create(['name' => $r .  '.create']);
            $readPermission = Permission::create(['name' => $r .  '.read']);
            $updatePermission = Permission::create(['name' => $r .  '.update']);
            $deletePermission = Permission::create(['name' => $r .  '.delete']);

            $role->givePermissionTo($createPermission);
            $role->givePermissionTo($readPermission);
            $role->givePermissionTo($updatePermission);
            $role->givePermissionTo($deletePermission);
        }
    }
}
