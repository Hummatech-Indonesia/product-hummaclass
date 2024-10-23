<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\RewardInterface;
use App\Helpers\ResponseHelper;
use App\Models\Reward;
use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Http\Resources\RewardResource;
use App\Services\RewardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    private RewardInterface $reward;
    private RewardService $service;
    public function __construct(RewardInterface $reward, RewardService $service)
    {
        $this->reward = $reward;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $rewards = $this->reward->customPaginate($request);
        // $data['paginate'] = $this->customPaginate($rewards->currentPage(), $rewards->lastPage());
        $data['data'] = RewardResource::collection($rewards);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRewardRequest $request): JsonResponse
    {
        $this->reward->store($this->service->store($request));
        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): JsonResponse
    {
        $reward = $this->reward->showWithSlug($slug);
        return ResponseHelper::success(RewardResource::make($reward), trans('alert.fetch_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRewardRequest $request, Reward $reward): JsonResponse
    {
        $this->reward->update($reward->id, $this->service->update($reward, $request));
        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward): JsonResponse
    {
        $this->reward->delete($reward->id);
        return ResponseHelper::success(null, trans('alert.delete_success'));
    }
}
