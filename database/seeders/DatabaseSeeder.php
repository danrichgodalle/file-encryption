<?php
namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Gamit ang bcrypt para secure
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $normalUser = User::create([
            'first_name' => 'Normal',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'), // Gamit ang bcrypt para secure
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminUser->assignRole('admin');
        $normalUser->assignRole('user');
    }
}
