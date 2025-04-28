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

        $permissions = [
            'can-create-user',
            'can-read-user',
            'can-update-user',
            'can-delete-user',
        ];

        foreach ($permissions as $permission) {
          Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }


        $admin = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $admin->syncPermissions($permissions);

        Role::firstOrCreate([
            'name' => 'user',
        ]);
    }
}
