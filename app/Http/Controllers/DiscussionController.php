<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\DiscussionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionRequest;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use App\Services\DiscussionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    private DiscussionInterface $discussion;
    private DiscussionService $service;
    public function __construct(DiscussionInterface $discussion, DiscussionService $service)
    {
        $this->discussion = $discussion;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(string $slug): JsonResponse
    {
        $discussions = $this->discussion->get();
        return ResponseHelper::success(DiscussionResource::collection($discussions), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param DiscussionRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(DiscussionRequest $request): JsonResponse
    {
        $this->service->store($request);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    public function show(Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussion->show($discussion->id);
        return ResponseHelper::success(DiscussionResource::make($discussion), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param DiscussionRequest $request [explicite description]
     * @param Discussion $discussion [explicite description]
     *
     * @return JsonResponse
     */
    public function update(DiscussionRequest $request, Discussion $discussion): JsonResponse
    {
        $this->discussion->update($discussion->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Discussion $discussion [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Discussion $discussion): JsonResponse
    {
        $this->discussion->delete($discussion->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }

}
