<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Database\Factories\QuestionFactory;
use Database\Factories\QuizFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Answer::query()->delete();
        Question::query()->delete();
        Quiz::query()->delete();
        QuizFactory::new()->count(30)->create();
        QuestionFactory::new()->count(100)->create();
        // \App\Models\User::factory(10)->create();
    }
}
