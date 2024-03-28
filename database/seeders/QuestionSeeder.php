<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $physicsQuestions = [];
        for ($i = 0; $i < 5; $i++) {
            $physicsQuestions[] = [
                'subject' => 'physics',
                'question' => $faker->realText(50, 2), // Generate realistic question text
                'options' => json_encode([
                    $faker->text(15),
                    $faker->text(15),
                    $faker->text(15),
                    $faker->text(15),
                ]),
                'correct_answer' => rand(1, 4), // Randomly choose correct answer
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $chemistryQuestions = [];
        for ($i = 0; $i < 5; $i++) {
            $chemistryQuestions[] = [
                'subject' => 'chemistry',
                'question' => $faker->realText(50, 2),
                'options' => json_encode([
                    $faker->text(15),
                    $faker->text(15),
                    $faker->text(15),
                    $faker->text(15),
                ]),
                'correct_answer' => rand(1, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('questions')->insert(array_merge($physicsQuestions, $chemistryQuestions));
    }
}
