<?php

namespace App\Services;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\QuizInterface;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Http\Resources\SubModuleResource;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SubModuleService
{
    private SubModuleInterface $subModule;
    private ModuleInterface $module;
    private QuizInterface $quiz;
    public function __construct(SubModuleInterface $subModule, ModuleInterface $module, QuizInterface $quiz)
    {
        $this->subModule = $subModule;
        $this->module = $module;
        $this->quiz = $quiz;
    }

    /**
     * next
     *
     * @param  mixed $subModule
     * @return mixed
     */
    public function next(mixed $subModule): mixed
    {
        $subModuleNext = $this->subModule->nextSubModule($subModule->step + 1, $subModule->module_id);
        $firstModuleNext = $this->module->moduleNextStep($subModule->module->step);
        $subModuleInNextModule = $this->subModule->nextSubModule(1, $firstModuleNext);
        if ($subModuleNext) {
            return SubModuleResource::make($subModuleNext);
        } else if ($subModuleInNextModule) {
            return SubModuleResource::make($subModuleInNextModule);
        } else {
            return false;
        }
    }

    /**
     * prev
     *
     * @param  mixed $subModule
     * @return mixed
     */
    public function prev(mixed $subModule): mixed
    {
        $subModulePrev = $this->subModule->prevSubModule($subModule->step - 1, $subModule->module_id);
        $firstModulePrev = $this->module->modulePrevStep($subModule->module->step);
        $subModuleInPrevModule = $this->subModule->prevSubModule(1, $firstModulePrev);
        if ($subModulePrev) {
            return SubModuleResource::make($subModulePrev);
        } else if ($subModuleInPrevModule) {
            return SubModuleResource::make($subModuleInPrevModule);
        } else {
            return false;
        }
    }
}
