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
        // Create permissions
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'manage']);

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $consultancyManager = Role::create(['name' => 'consultancy_manager']);
        $testCenterManager = Role::create(['name' => 'test_center_manager']);
        $user = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage', 'view']);
        $consultancyManager->givePermissionTo('view');
        $testCenterManager->givePermissionTo('view');
    }
}
