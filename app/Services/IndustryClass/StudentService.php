<?php

namespace App\Services\IndustryClass;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentService 
{
    private ModuleInterface $module;

    public function __construct(ModuleInterface $module)
    {   
        $this->module = $module;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function paginate($query, int $pagination = 10): LengthAwarePaginator
    {
        return $query->fastPaginate($pagination);
    }


    public function studentDashboard(Student $student) 
    {
        $modules = $this->module->whereDivision($student->studentClassrooms()->latest()->first()->classroom->division_id);

        $count_module = 0;
        foreach ($modules as $module) {
            $count_module += $module->moduleTasks()->count();
        }

        $count_module_clear = 0;
        foreach ($modules as $module) {
            $count_module_clear += $module->moduleTasks()->whereHas('submissionTask', function($query) use ($student) {$query->where('user_id', $student->user_id);} )->count();
        }

        $count_module_not_clear = $count_module - $count_module_clear;

        return [
            'module_count' => $modules->count(),
            'module_task' => $count_module,
            'module_task_clear' => $count_module_clear,
            'module_task_not_clear' => $count_module_not_clear,
        ];
    }
}
