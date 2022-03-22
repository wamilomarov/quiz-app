<?php

namespace Database\Seeders;

use Database\Factories\QuestionFactory;
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
        QuestionFactory::new()->count(100)->create();
        // \App\Models\User::factory(10)->create();
    }
}
