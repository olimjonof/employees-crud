<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $faker = Faker::create();

        foreach (range(1, 25) as $i) {
            Employee::create([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'position' => $faker->jobTitle,
                'salary' => $faker->randomFloat(2, 1000, 8000),
                'hired_at' => $faker->date(),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }

}
