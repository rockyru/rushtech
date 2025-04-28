<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Create a user with the role of 'admin'
        $admin = User::factory()->create([
            'first_name' => 'Ruther',
            'last_name' => 'Bergonia',
            'username' => 'admin_user',
            'phone' => '09234569871',
            'address' => 'Taguig, NCR',
            'postal_code' => '1678',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');
        $admin->createToken('admin-token')->plainTextToken;

        // Create normal user
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'normal_user',
            'phone' => '09134509123',
            'address' => 'Ermita, Manila',
            'postal_code' => '1000',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
        $user->createToken('user-token')->plainTextToken;
       
        // Generate 5 random users
        User::factory(5)->create()->each(function($user) {
            $user->assignRole('user');
            $user->createToken('user-token')->plainTextToken;
        });
    }
}
