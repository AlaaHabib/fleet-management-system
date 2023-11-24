<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Create a user and assign the "customer" role
        $user = User::updateOrCreate(
            ['email' => 'alaahabib364@gmail.com'],
            [
                'name' => 'Alaa Habib',
                'email' => 'alaahabib364@gmail.com',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('customer');
    }
}
