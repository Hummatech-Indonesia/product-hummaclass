<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseTestDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $list_classrooms = $this->course
            ->whereHas('courseLearningPaths.learningPath.division.classrooms')
            ->get()
            ->pluck('courseLearningPaths.*.learningPath.division.classrooms')
            ->flatten();

        $filtered_classrooms = $list_classrooms->filter(function ($classroom) use ($request) {
            $match = true;
        
            if ($request->name) {
                $match = $match && str_contains(strtolower($classroom['name']), strtolower($request->name));
            }

            if ($request->level) {
                $match = $match && str_contains(strtolower($classroom['class_level']), strtolower($request->level));
            }
        
            return $match;
        });

        return [
            'classroom' => $filtered_classrooms, 
        ];
    }
}
