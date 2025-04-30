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
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Gamit ang bcrypt para secure
            'is_admin' => true,
        ]);

        $normalUser = User::create([
            'name' => 'Admin User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'), // Gamit ang bcrypt para secure
            'is_admin' => true,
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminUser->assignRole('admin');
        $normalUser->assignRole('user');
    }
}
