<?php

namespace App\Http\Resources;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quiz */
class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'total_score' => $this->whenLoaded('questions', function () {
                return $this->questions->where('is_correct', true)->count();
            }),
            'unanswered_count' => $this->whenLoaded('questions', function () {
                return $this->questions->whereNull('answered_at')->count();
            }),
            'submitted_at' => $this->when(!is_null($this->submitted_at), function () {
                return $this->submitted_at->format("Y-m-d H:i:s");
            }),
            'created_at' => $this->created_at->format("Y-m-d H:i:s"),
            'duration' => $this->when(!is_null($this->submitted_at), function () {
                return $this->submitted_at->shortAbsoluteDiffForHumans($this->created_at);
            }),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
