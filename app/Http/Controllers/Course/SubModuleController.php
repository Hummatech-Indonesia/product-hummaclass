<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\SubModuleInterface;
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
    public function __construct(SubModuleInterface $subModule, SubModuleService $service)
    {
        $this->subModule = $subModule;
        $this->service = $service;
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
        $service = $this->service->next($subModule);
        if ($service) {
            return ResponseHelper::success($service, trans('alert.fetch_success'));
        } else {
            return ResponseHelper::error(null, 'Anda sudah pada halaman terakhir');
        }
    }

    public function prev(string $slug): JsonResponse
    {
        $subModule = $this->subModule->showWithSlug($slug);
        $service = $this->service->prev($subModule);
        if ($service) {
            return ResponseHelper::success($service, trans('alert.fetch_success'));
        } else {
            return ResponseHelper::error(null, 'Anda sudah pada halaman pertama');
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
        return ResponseHelper::success(null, trans('alert.update_success'));
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

            return response()->json(['success' => 1, 'file' => ['url' =>  url('storage/' . $url)]]);
        }

        return response()->json(['success' => 0, 'message' => 'File upload failed.']);
    }
}
