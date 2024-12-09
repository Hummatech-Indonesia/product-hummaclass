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

        $student_list = $this->course
            ->whereHas('courseLearningPaths.learningPath.division.classrooms.studentClassrooms')->get()
            ->pluck('courseLearningPaths.*.learningPath.division.classrooms.*.studentClassrooms')->flatten();
        
        $student_count = $student_list->count();

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

        $the_highest_score = $this->userCourseTests()->orderBy('score', 'desc')->first();
        $the_lowest_score = $this->userCourseTests()->orderBy('score', 'asc')->first();

        return [
            'count_student' => $student_count,
            'the_highest_score' => $the_highest_score->score,
            'the_lowest_score' => $the_lowest_score->score,
            'classroom' => $filtered_classrooms, 
        ];
    }
}
