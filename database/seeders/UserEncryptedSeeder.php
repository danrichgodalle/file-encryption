<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Faker\Factory as FakerFactory;

class UserEncryptedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();
        $userRole = 'user';

        for ($i = 0; $i < 10000; $i++) {
            // Create user with unique email using timestamp
            $user = User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->userName() . '_' . time() . '_' . $i . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            // Assign user role
            $user->assignRole($userRole);

            // Create application with encrypted data
            $application = Application::create([
                'name' => Crypt::encrypt($user->name),
                'nick_name' => Crypt::encrypt($faker->userName()),
                'address' => Crypt::encrypt($faker->address()),
                'tel_no' => Crypt::encrypt($faker->phoneNumber()),
                'cell_no' => Crypt::encrypt($faker->phoneNumber()),
                'length_of_stay' => Crypt::encrypt($faker->numberBetween(1, 20) . ' years'),
                'ownership' => Crypt::encrypt($faker->randomElement(['Owned', 'Rented'])),
                'rent_amount' => Crypt::encrypt($faker->randomElement(['Owned', 'Rented']) === 'Rented' ? $faker->numberBetween(5000, 20000) : null),
                'date_of_birth' => Crypt::encrypt($faker->date()),
                'place_of_birth' => Crypt::encrypt($faker->city()),
                'age' => Crypt::encrypt($faker->numberBetween(18, 65)),
                'civil_status' => Crypt::encrypt($faker->randomElement(['Single', 'Married', 'Widowed', 'Separated'])),
                'dependents' => Crypt::encrypt($faker->numberBetween(0, 5)),
                'contact_person' => Crypt::encrypt($faker->name()),
                'employment' => Crypt::encrypt($faker->randomElement(['Employed', 'Self-employed', 'Business'])),
                'position' => Crypt::encrypt($faker->jobTitle()),
                'employer_name' => Crypt::encrypt($faker->company()),
                'employer_address' => Crypt::encrypt($faker->address()),
                'businesses' => Crypt::encrypt(json_encode([
                    [
                        'name' => $faker->company(),
                        'nature' => $faker->companySuffix(),
                        'years' => $faker->numberBetween(1, 20),
                        'address' => $faker->address()
                    ]
                ])),
                'spouse_employment' => Crypt::encrypt($faker->randomElement(['Employed', 'Self-employed', 'Business', 'None'])),
                'spouse_position' => Crypt::encrypt($faker->jobTitle()),
                'spouse_employer_name' => Crypt::encrypt($faker->company()),
                'spouse_employer_address' => Crypt::encrypt($faker->address()),
                'monthly_income' => Crypt::encrypt($faker->numberBetween(15000, 100000)),
                'properties' => Crypt::encrypt(json_encode([
                    [
                        'type' => $faker->randomElement(['House', 'Lot', 'Vehicle']),
                        'value' => $faker->numberBetween(100000, 5000000)
                    ]
                ])),
                'user_id' => $user->id,
                'status' => 'pending',
                'encryption_key' => null
            ]);
        }
    }
}
