<?php

namespace App\Services\Course;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Module;
use App\Models\User;
use App\Traits\UploadTrait;

class ModuleService implements ShouldHandleFileUpload
{
    private ModuleInterface $module;
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }

    use UploadTrait;

    public function delete(Module $module): array|bool
    {
        $modules = $this->module->getWhere('step', '>', $module->step);

        $modules->each(function ($mod) {
            $mod->decrement('step');
        });

        $this->module->delete($module->id);

        return true;
    }

}
