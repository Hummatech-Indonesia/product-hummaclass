<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\DiscussionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionRequest;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    private DiscussionInterface $discussion;
    public function __construct(DiscussionInterface $discussion)
    {
        $this->discussion = $discussion;
    }    
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
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
        $this->discussion->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
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
