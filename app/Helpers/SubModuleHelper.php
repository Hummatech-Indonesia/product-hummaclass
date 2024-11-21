<?php

namespace App\Helpers;

use App\Models\Module;
use App\Models\Quiz;
use App\Models\SubModule;
use App\Models\UserCourse;
use App\Models\UserQuiz;

class SubModuleHelper
{
    /**
     * Check if the user can access the specified sub-module.
     *
     * @param string $slug
     * @return bool
     */
    public static function sub_module(string $slug): bool
    {
        $subModule = SubModule::where('slug', $slug)->firstOrFail();

        $userCourse = UserCourse::where('user_id', auth()->user()->id)
            ->where('course_id', $subModule->module->course_id)
            ->firstOrFail();

        if ($subModule->step == 1 && $subModule->module->step != 1) {
            $module = Module::query()->where('step', $subModule->module->step - 1)->where('course_id', $subModule->module->course_id)->first();
            $quiz = Quiz::query()->where('module_id', $module->id)->first();
            if ($quiz == null) {
                return false;
            }
            $userQuiz = UserQuiz::query()->where('user_id', auth()->user()->id)->where('quiz_id', $quiz->id)->get()->contains('score', '>=', $quiz->minimum_score);

            if ($userQuiz) {
                return true;
            }
        }

        $currentStep = $userCourse->subModule->module->step;
        $nextStep = $userCourse->subModule->step + 1;

        if ($currentStep == 1) {
            return SubModule::where('step', '<=', $nextStep)
                ->where('module_id', $userCourse->subModule->module_id)
                ->get()
                ->contains('slug', $subModule->slug);
        } else {
            for ($i = $currentStep; $i >= 1; $i--) {
                $module = Module::where('step', $i)->where('course_id', $subModule->module->course_id)->first();
                if (SubModule::where('step', '<=', $nextStep)
                    ->where('module_id', $module->id)
                    ->get()
                    ->contains('slug', $subModule->slug)
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
