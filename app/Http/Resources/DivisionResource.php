<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'classroom_count' => $this->classrooms ? $this->classrooms->count() : null,
            'learning_path_count' => $this->learningPaths ? $this->learningPaths->count() : null,
        ];
    }
}
