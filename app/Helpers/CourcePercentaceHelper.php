<?php

namespace App\Helpers;

class CourcePercentaceHelper
{
    public static function getPercentace($userCource)
    {
        $data = (object) [
            'total_sub_module' => 0,
            'total_quiz' => 0,
            'total_submission_quiz' => 0,
            'sub_module_step' => $userCource->subModule?->step == 1 ? 0 : $userCource->subModule->step,
        ];

        foreach ($userCource->course->modules as $module) {
            $data->total_sub_module += $module->sub_modules_count;
            foreach ($module->quizzes as $quiz) {
                $data->total_quiz += 1;
                if ($quiz->userQuizzes->count() > 0) {
                    $data->total_submission_quiz += 1;
                }
            }
            // dd($module->moduleTasks);
            // foreach ($module->subModules as $subModule) {
            // if($subModule->submissionTask->count() > 0) $data->total_submission_task += 1;
            // }
        }
        // return $data;
        $percentace = ($data->total_submission_quiz + $data->sub_module_step) * 100 / ($data->total_sub_module + $data->total_quiz);
        return $percentace;
    }
}
