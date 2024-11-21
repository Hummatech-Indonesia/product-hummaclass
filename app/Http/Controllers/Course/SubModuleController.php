<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Contracts\Interfaces\Course\SubModuleInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Contracts\Interfaces\UserQuizInterface;
use App\Enums\UploadDiskEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubModuleRequest;
use App\Http\Resources\SubModuleResource;
use App\Models\Module;
use App\Models\SubModule;
use App\Services\SubModuleService;
use App\Traits\UploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubModuleController extends Controller
{
    use UploadTrait;
    private SubModuleInterface $subModule;
    private SubModuleService $service;
    private ModuleInterface $module;
    private UserCourseInterface $userCourse;
    public function __construct(SubModuleInterface $subModule, SubModuleService $service, UserCourseInterface $userCourse, ModuleInterface $module)
    {
        $this->subModule = $subModule;
        $this->service = $service;
        $this->userCourse = $userCourse;
        $this->module = $module;
    }

    /**
     * Method store
     *
     * @param SubModuleRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(SubModuleRequest $request, Module $module): JsonResponse
    {
        $data = $request->validated();
        $data['module_id'] = $module->id;
        $subModule = $this->subModule->getOneByModul($module->id);
        if ($subModule != null) {
            $data['step'] = $subModule->step + 1;
        } else {
            $data['step'] = 1;
        }
        $subModule = $this->subModule->store($data);
        return ResponseHelper::success(SubModuleResource::make($subModule), trans('alert.add_success'));
    }

    /**
     * next
     *
     * @param  mixed $slug
     * @return void
     */
    public function next(string $slug)
    {
        $subModule = $this->subModule->showWithSlug($slug);
        $service = null;
        if ($subModule) {
            $service = $this->service->next($subModule);
        } else {
            $module = $this->module->showWithSlug($slug);
            $firstModuleNext = $this->module->moduleNextStep($module->step);
            $subModuleInNextModule = $this->subModule->nextSubModule(1, $firstModuleNext->id);
        }
        if ($service) {
            return ResponseHelper::success($service, trans('alert.fetch_success'));
        } else if ($service == false && $subModule) {
            return ResponseHelper::error($subModule->module->slug, 'Anda sudah pada halaman terakhir');
        } else {
            return ResponseHelper::success(SubModuleResource::make($subModuleInNextModule));
        }
    }

    /**
     * prev
     *
     * @param  mixed $slug
     * @return JsonResponse
     */
    public function prev(string $slug): JsonResponse
    {
        $subModule = $this->subModule->showWithSlug($slug);
        $service = null;
        if ($subModule) {
            $service = $this->service->prev($subModule);
        } else {
            $module = $this->module->showWithSlug($slug);
            $subModuleInPrevModule = $this->subModule->getOneByModul($module->id);
        }

        if ($service) {
            return ResponseHelper::success($service, trans('alert.fetch_success'));
        } else if ($service == false && $subModule) {
            $module = $this->module->modulePrevStep($subModule->module->step);
            return ResponseHelper::error($module->slug, 'Anda sudah pada halaman terakhir');
        } else {
            return ResponseHelper::success(SubModuleResource::make($subModuleInPrevModule));
        }
    }

    /**
     * Method show
     *
     * @param string $slug [explicite description]
     *
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $subModule = $this->subModule->showWithSlug($slug);
        return ResponseHelper::success(SubModuleResource::make($subModule), trans('alert.fetch_success'));
    }

    /**
     * showAdmin
     *
     * @param  mixed $slug
     * @return JsonResponse
     */
    public function showAdmin(string $slug): JsonResponse
    {
        $subModule = $this->subModule->showWithSlug($slug);
        return ResponseHelper::success(SubModuleResource::make($subModule), trans('alert.fetch_success'));
    }

    public function edit(SubModule $subModule): JsonResponse
    {
        return ResponseHelper::success(SubModuleResource::make($subModule));
    }
    /**
     * Method update
     *
     * @param SubModuleRequest $request [explicite description]
     * @param SubModule $subModule [explicite description]
     *
     * @return JsonResponse
     */
    public function update(SubModuleRequest $request, SubModule $subModule): JsonResponse
    {
        $this->subModule->update($subModule->id, $request->validated());
        return ResponseHelper::success(SubModuleResource::make($subModule), trans('alert.update_success'));
    }

    /**
     * Method destroy
     *
     * @param SubModule $subModule [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(SubModule $subModule): JsonResponse
    {
        try {
            $this->subModule->delete($subModule->id);
            return ResponseHelper::success(true, trans('alert.delete_success'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(false, trans('alert.delete_constrained'));
        }
    }

    /**
     * uploadImage
     *
     * @param  mixed $request
     * @return void
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('image')) {
            $url = $this->upload(UploadDiskEnum::IMAGE->value, $request->file('image'));

            return response()->json(['success' => 1, 'file' => ['url' => url('storage/' . $url)]]);
        }

        return response()->json(['success' => 0, 'message' => 'File upload failed.']);
    }

    /**
     * checkPrevSubModule
     *
     * @return JsonResponse
     */
    public function checkPrevSubModule(string $slug): JsonResponse
    {
        $subModule = $this->subModule->showWithSlug($slug);
        $userCourse = $this->userCourse->showByCourse($subModule->module->course->id);
        $this->subModule->getAllPrevSubModule($userCourse->subModule->id, $userCourse->subModule->module->id);
        return ResponseHelper::success();
    }
}
