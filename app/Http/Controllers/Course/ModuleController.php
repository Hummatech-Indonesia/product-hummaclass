<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Interfaces\Course\ModuleInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleInterface $module;
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }
    public function index(): JsonResponse
    {
        $data = $this->module->get();
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    public function store(ModuleRequest $request):JsonResponse{
        $this->module->store($request->validated());
        return ResponseHelper::success()
    }
}
