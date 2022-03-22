<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuizRequest;
use App\Http\Requests\SubmitQuizRequest;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\RedirectResponse;

class QuizController extends Controller
{
    public function store(CreateQuizRequest $request): RedirectResponse
    {
        /** @var Quiz $quiz */
        $quiz = Quiz::query()
            ->create($request->validated());

        $quiz->setQuestions();

        return redirect()->route('quizzes.show', ['quiz' => $quiz->uuid]);
    }

    public function show(Quiz $quiz)
    {
        $quiz->loadMissing(['questions.answers']);
        return inertia('Quiz', [
            'quiz' => QuizResource::make($quiz)
        ]);
    }

    public function submit(Quiz $quiz, SubmitQuizRequest $request): RedirectResponse
    {
        $submittedAt = now();

        if (is_null($quiz->submitted_at)) {
            if ($quiz->created_at->diffInMinutes($submittedAt) <= 5) {
                $answers = $request->get('answers');
                $quiz->loadMissing(['quizQuestions.question.answers']);

                foreach ($answers as $answer) {
                    /** @var QuizQuestion $quizQuestion */
                    $quizQuestion = $quiz->quizQuestions->firstWhere('question_id', $answer['question_id']);
                    if (!is_null($quizQuestion)) {
                        $quizQuestion->checkAnswer($answer['answer_id']);
                    }
                }
            }
            $quiz->update([
                'submitted_at' => $submittedAt
            ]);
        }

        return redirect()->route('quizzes.show', ['quiz' => $quiz->uuid]);
    }
}
