<?php

namespace App\Helpers;

use App\Models\Module;
use App\Models\SubModule;
use App\Models\UserCourse;

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
        $userCourse = self::getUserCourse($subModule->module->course_id);

        return self::isSubModuleAccessible($subModule, $userCourse);
    }

    /**
     * Get the user's course.
     *
     * @param int $courseId
     * @return UserCourse
     */
    private static function getUserCourse(mixed $courseId): UserCourse
    {
        return UserCourse::where('user_id', auth()->user()->id)
            ->where('course_id', $courseId)
            ->firstOrFail();
    }

    /**
     * Check if the sub-module is accessible based on the user's current module step.
     *
     * @param SubModule $subModule
     * @param UserCourse $userCourse
     * @return bool
     */
    private static function isSubModuleAccessible(SubModule $subModule, UserCourse $userCourse): bool
    {
        if ($userCourse->subModule->module->step == 1) {
            return self::checkSubModuleInStep($subModule, $userCourse->subModule->step + 1, $userCourse->subModule->module_id);
        } else {
            return self::checkSubModuleInSteps($subModule, $userCourse->subModule->module->step, $userCourse->subModule->step + 1);
        }
    }

    /**
     * Check if the sub-module exists in the given step for the module.
     *
     * @param SubModule $subModule
     * @param mixed $stepLimit
     * @param mixed $moduleId
     * @return bool
     */
    private static function checkSubModuleInStep(SubModule $subModule, mixed $stepLimit, mixed $moduleId): bool
    {
        return SubModule::where('step', '<=', $stepLimit)
            ->where('module_id', $moduleId)
            ->get()
            ->contains('slug', $subModule->slug);
    }

    /**
     * Check if the sub-module exists across multiple steps.
     *
     * @param SubModule $subModule
     * @param mixed $currentStep
     * @param mixed $stepLimit
     * @return bool
     */
    private static function checkSubModuleInSteps(SubModule $subModule, mixed $currentStep, mixed $stepLimit): bool
    {
        for ($i = $currentStep; $i >= 1; $i--) {
            $module = Module::where('step', $i)->first();
            if (self::checkSubModuleInStep($subModule, $stepLimit, $module->id)) {
                return true;
            }
        }
        return false;
    }
}
