<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create "customer" role
        $customerRole = Role::updateOrCreate(['name' => 'customer']);

        // Define permissions
        $customer_permissions = [
            'view',
            'booking',
            'list'
        ];
    

        // Assign permissions to roles
        foreach ($customer_permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
            $customerRole->givePermissionTo($permission);
            
        }
    }
}
