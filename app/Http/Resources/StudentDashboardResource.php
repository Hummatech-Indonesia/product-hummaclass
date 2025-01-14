<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->studentClassrooms()->latest()->first()->student->id,
            'name' => $this->studentClassrooms()->latest()->first()->student->user->name,
            'nisn' => $this->studentClassrooms()->latest()->first()->student->nisn,
            'school' => $this->studentClassrooms()->latest()->first()->student->school->name,
            'point' => $this->studentClassrooms()->latest()->first()->student->user->point,
            'classroom' => $this->studentClassrooms()->latest()->first()->classroom,
            'teacher' => $this->studentClassrooms()->latest()->first()->classroom->teacher,
            'user' => $this->studentClassrooms()->latest()->first()->classroom->user,   
            'count_event' => $this->studentClassrooms()->latest()->first()->student->user->userEvents()->count(),
            'count_challenge' => $this->studentClassrooms()->latest()->first()->classroom->challenges()->count(),
            'challenge_clear' => $this->studentClassrooms()->latest()->first()->classroom->challenges()->whereHas('challengeSubmits', function ($query) { $query->where('student_id', $this->id); })->count(),
            'challenge_not_clear' =>  $this->studentClassrooms()->latest()->first()->classroom->challenges()->count() - $this->studentClassrooms()->latest()->first()->classroom->challenges()->whereHas('challengeSubmits', function ($query) { $query->where('student_id', $this->id); })->count(),
        ];
    }
}
