<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{

    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->realText(),
            'type' => array_rand(Quiz::TYPES)
        ];
    }

    public function configure()
    {
        return $this
            ->afterCreating(function (Question $question) {
                if ($question->type == Quiz::TYPE_BINARY)
                {
                    AnswerFactory::new()
                        ->for($question)
                        ->createMany([
                        [
                            'text' => 'Yes',
                            'is_correct' => false
                        ],
                        [
                            'text' => 'No',
                            'is_correct' => true]
                    ]);
                }
                else
                {
                    AnswerFactory::new()->for($question)->count(3)->create();
                }
            });
    }
}
