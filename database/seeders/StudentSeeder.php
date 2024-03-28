<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $students = [];
        for ($i = 0; $i < 10; $i++) { // Adjust the number of students as needed
            $students[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail, // Unique and safe emails
            ];
        }

        DB::table('students')->insert($students);
    }
}
