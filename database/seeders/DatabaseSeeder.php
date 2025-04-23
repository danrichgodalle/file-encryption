<?php
namespace Database\Seeders;

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
        User::create([
            'name' => 'Admin User',
            'email' => 'markdavidjanapin@gmail.com',
            'password' => bcrypt('password'), // Gamit ang bcrypt para secure
            'is_admin' => true,
        ]);
    }
}
