<?php

namespace App\Services;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SubModuleService
{
    private SubModuleInterface $subModule;
    private ModuleInterface $module;
    public function __construct(SubModuleInterface $subModule, ModuleInterface $module)
    {
        $this->subModule = $subModule;
        $this->module = $module;
    }

    public function next(mixed $subModule): mixed
    {
        $subModuleNext = $this->subModule->nextSubModule($subModule->step, $subModule->module_id);
        $firstModuleNext = $this->module->moduleNextStep($subModule->module->step);
        $subModuleInNextModule = $this->subModule->nextSubModule(1, $firstModuleNext);
        if ($subModuleNext) {
            return $subModuleNext;
        } else if ($subModuleInNextModule) {
            return $subModuleInNextModule;
        } else {
            return false;
        }
    }
    public function prev(mixed $subModule): mixed
    {
        $subModulePrev = $this->subModule->prevSubModule($subModule->step, $subModule->module_id);
        $firstModulePrev = $this->module->modulePrevStep($subModule->module->step);
        $subModuleInPrevModule = $this->subModule->prevSubModule(1, $firstModulePrev);
        if ($subModulePrev) {
            return $subModulePrev;
        } else if ($subModuleInPrevModule) {
            return $subModuleInPrevModule;
        } else {
            return false;
        }
    }
}
