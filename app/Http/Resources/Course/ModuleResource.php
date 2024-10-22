<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\ModuleTaskResource;
use App\Http\Resources\QuizResource;
use App\Http\Resources\SubModuleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'title' => $this->title,
            'step' => $this->step,
            'slug' => $this->slug,
            'sub_title' => $this->sub_title,
            'course' => $this->course,
            'quizzes' => QuizResource::collection($this->quizzes),
            'quizz_count' => $this->quizzes->count(),
            'sub_modules' => SubModuleResource::collection($this->subModules),
            'sub_module_count' => $this->subModules->count(),
            // 'module_tasks' => ModuleTaskResource::collection($this->moduleTasks),
            'module_task_count' => $this->moduleTasks->count(),
        ];
    }
}
