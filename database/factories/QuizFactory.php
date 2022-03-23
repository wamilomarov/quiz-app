<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $submittedAt = $this->faker->dateTimeBetween(now(), now()->addMinutes(5));
        return [
            'type' => array_rand(Quiz::TYPES),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'total_score' => $this->faker->numberBetween(0, 10),
            'submitted_at' => $submittedAt,
            'duration' => $submittedAt->diff(now())->format("%H:%I:%S")
        ];
    }

    public function configure(): QuizFactory
    {
        return $this->afterCreating(function (Quiz $quiz) {
            $quiz->setQuestions();
            $quiz->quizQuestions()->inRandomOrder()
                ->limit($quiz->total_score)
                ->update([
                    'is_correct' => true
                ]);
        });
    }
}
