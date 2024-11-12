<?php

namespace App\Http\Resources;

use App\Helpers\CourcePercentaceHelper;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Hitung total langkah dari semua submodule dalam modul
        $total_steps = 0;
        foreach ($this->course->modules as $module) {
            $total_steps += $module->subModules->count();
        }

        // Dapatkan step untuk sub_module_id saat ini
        $current_step = $this->course->modules()
            ->whereHas('subModules', function ($query) {
                $query->where('id', $this->sub_module_id);
            })
            ->with([
                'subModules' => function ($query) {
                    $query->where('id', $this->sub_module_id);
                }
            ])
            ->first();

        // Check if current_step was found and get the step number
        $current_step = $current_step?->subModules->first()?->step ?? 0;

        // Kalkulasi persentase pengerjaan
        $percentage = $total_steps > 0 ? ($current_step / $total_steps) * 100 : 0;

        return [
            'user' => $this->user,
            'course' => CustomCourseResource::make($this->course),
            'total_module' => $this->course->modules->count(),
            'total_user' => $this->course->userCourses->count(),
            'study_time' => $this->created_at
                ? now()->diffInHours($this->created_at) . ' jam ' . now()->diffInMinutes($this->created_at) % 60 . ' menit'
                : 'Belum ada waktu belajar',
            'study_percentage' => round($percentage),
            'sub_module' => $this->subModule,
            'has_post_test' => $this->has_post_test,
            'has_pre_test' => $this->has_pre_test,
            'sub_module_slug' => $this->subModule->slug,
        ];
    }
}
