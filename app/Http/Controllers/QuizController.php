<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuizRequest;
use App\Http\Requests\SubmitQuizRequest;
use App\Http\Resources\LeaderResource;
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
        $duration = $quiz->created_at->diffAsCarbonInterval();
        $totalScore = 0;

        if (is_null($quiz->submitted_at)) {

            if ($quiz->created_at->diffInMinutes($submittedAt) <= 5) {
                $answers = $request->get('answers', []);
                $quiz->loadMissing(['quizQuestions.question.answers']);

                foreach ($answers as $answer) {
                    /** @var QuizQuestion $quizQuestion */
                    $quizQuestion = $quiz->quizQuestions->firstWhere('question_id', $answer['question_id']);
                    if (!is_null($quizQuestion)) {
                        $correct = $quizQuestion->checkAnswer($answer['answer_id']);
                        if ($correct)
                        {
                            $totalScore++;
                        }
                    }
                }
            }
            $quiz->update([
                'submitted_at' => $submittedAt,
                'duration' => "{$duration->hours}:{$duration->minutes}:{$duration->seconds}",
                'total_score' => $totalScore
            ]);
        }

        return redirect()->route('quizzes.show', ['quiz' => $quiz->uuid]);
    }

    public function leaders()
    {
        $leaders = Quiz::query()
            ->orderByDesc('total_score')
            ->orderByDesc('duration')
            ->paginate();
//        dd($leaders);

        return inertia("Leaders", [
            'leaders' => LeaderResource::collection($leaders)
        ]);
    }
}
