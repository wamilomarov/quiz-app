<?php

namespace App\Http\Resources;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quiz */
class LeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->first_name . " " . $this->last_name,
            'email' => $this->email,
            'total_score' => $this->total_score,
            'unanswered_count' => $this->whenLoaded('questions', function () {
                return $this->questions->whereNull('answered_at')->count();
            }),
            'duration' => $this->duration,
        ];
    }
}
