<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\LearningPathInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LearningPathRequest;
use App\Http\Resources\LearningPathResource;
use App\Models\LearningPath;
use App\Services\IndustryClass\LearningPathService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    private LearningPathInterface $learningPath;
    private LearningPathService $service;
    public function __construct(LearningPathInterface $learningPath, LearningPathService $service)
    {
        $this->learningPath = $learningPath;
        $this->service = $service;
    }
    public function index(): JsonResponse
    {
        $learningPaths = $this->learningPath->get();
        return ResponseHelper::success(LearningPathResource::collection($learningPaths), trans('alert.fetch_success'));
    }
    public function store(LearningPathRequest $request): JsonResponse
    {
        $this->service->store($request);
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
    public function show(LearningPath $learningPath): JsonResponse
    {
        $this->learningPath->show($learningPath->id);
        return ResponseHelper::success(LearningPathResource::make($learningPath), trans('alert.fetch_success'));
    }
    public function update(LearningPathRequest $request, LearningPath $learningPath): JsonResponse
    {
        $this->service->update($request, $learningPath);
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
    public function destroy(LearningPath $learningPath): JsonResponse
    {
        try {
            $this->learningPath->delete($learningPath->id);
        } catch (\Throwable $e) {
            return ResponseHelper::error(null, trans('alert.delete_constrained'));
        }
        return ResponseHelper::success(null, trans('alert.delete_failed'));
    }
}
