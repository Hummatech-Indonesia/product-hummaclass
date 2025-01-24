<?php

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (auth()->check()) {
            $auth = $this->userQuizzes->where('user_id', auth()->user()->id)->first();
        } else {
            $auth = null;
        }
        $submodulenext = Module::where('step', $this->module->step + 1)->where('course_id', $this->module->course_id)->first()->subModules->first()->slug;
        return [
            'id' => $this->id,
            'module_id' => $this->module_id,
            'sub_module_slug_prev' => $this->module->subModules->where('step', $this->module->subModules->count())->first()->slug,
            'sub_module_slug_next' => $submodulenext,
            'course_slug' => $this->module->course->slug,
            'course_title' => $this->module->course->title,
            'module_title' => $this->module->title,
            'rules' => $this->rules,
            'module_slug' => $this->module->slug,
            'total_question' => $this->total_question,
            'minimum_score' => $this->minimum_score,
            'duration' => $this->duration,
            'retry_delay' => $this->retry_delay,
            'user_quiz_me' => $auth,
            'user_quizzes' => $this->userQuizzes->sortByDesc('created_at')->first(),
            'is_submited' => $this->is_submited,
            'created_at' => $this->created_at
        ];
    }
}
