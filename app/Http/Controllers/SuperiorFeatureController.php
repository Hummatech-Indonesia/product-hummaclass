<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SuperiorFeatureInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\SuperiorFeatureRequest;
use App\Http\Resources\SuperiorFeatureResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuperiorFeatureController extends Controller
{
    private SuperiorFeatureInterface $superFeature;

    public function __construct(SuperiorFeatureInterface $superFeature)
    {
        $this->superFeature = $superFeature;
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $superFeature = $this->superFeature->get();
        return ResponseHelper::success(SuperiorFeatureResource::make($superFeature));
    }

    public function store(SuperiorFeatureRequest $request): JsonResponse
    {
        $this->superFeature->store($request->validated());
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
}
