<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Application;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20,000 users with applications (10,000 approved + 10,000 declined)
        $faker = FakerFactory::create();
        $userRole = 'user'; // Assuming 'user' is the role you want to assign

        for ($i = 0; $i < 20000; $i++) {
            // Create user
            $user = User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->userName() . '_' . time() . '_' . $i . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            // Assign user role
            $user->assignRole($userRole);

            // Create application
            $application = Application::create([
                'name' => $user->name,
                'nick_name' => $faker->userName(),
                'address' => $faker->address(),
                'tel_no' => $faker->phoneNumber(),
                'cell_no' => $faker->phoneNumber(),
                'length_of_stay' => $faker->numberBetween(1, 20) . ' years',
                'ownership' => $faker->randomElement(['Owned', 'Rented']),
                'rent_amount' => $faker->randomElement(['Owned', 'Rented']) === 'Rented' ? $faker->numberBetween(5000, 20000) : null,
                'date_of_birth' => $faker->date(),
                'place_of_birth' => $faker->city(),
                'age' => $faker->numberBetween(18, 65),
                'civil_status' => $faker->randomElement(['Single', 'Married', 'Widowed', 'Separated']),
                'dependents' => $faker->numberBetween(0, 5),
                'contact_person' => $faker->name(),
                'employment' => $faker->randomElement(['Employed', 'Self-employed', 'Business']),
                'position' => $faker->jobTitle(),
                'employer_name' => $faker->company(),
                'employer_address' => $faker->address(),
                'businesses' => json_encode([
                    [
                        'name' => $faker->company(),
                        'nature' => $faker->companySuffix(),
                        'years' => $faker->numberBetween(1, 20),
                        'address' => $faker->address()
                    ]
                ]),
                'spouse_employment' => $faker->randomElement(['Employed', 'Self-employed', 'Business', 'None']),
                'spouse_position' => $faker->jobTitle(),
                'spouse_employer_name' => $faker->company(),
                'spouse_employer_address' => $faker->address(),
                'monthly_income' => $faker->numberBetween(15000, 100000),
                'properties' => json_encode([
                    [
                        'type' => $faker->randomElement(['House', 'Lot', 'Vehicle']),
                        'value' => $faker->numberBetween(100000, 5000000)
                    ]
                ]),
                'user_id' => $user->id,
                'status' => $i < 10000 ? 'approved' : 'declined',
                'decline_reason' => $i >= 10000 ? $faker->randomElement([
                    'Insufficient income',
                    'Poor credit history',
                    'Incomplete documentation',
                    'High debt-to-income ratio',
                    'Unstable employment'
                ]) : null,
                'encryption_key' => $faker->uuid()
            ]);
        }
    }
}
