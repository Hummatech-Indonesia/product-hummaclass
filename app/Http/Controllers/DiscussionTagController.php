<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\DiscussionTagInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionTagRequest;
use App\Http\Resources\DiscussionTagResource;
use App\Models\DiscussionTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscussionTagController extends Controller
{
    private DiscussionTagInterface $discussionTag;
    public function __construct(DiscussionTagInterface $discussionTag)
    {
        $this->discussionTag = $discussionTag;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $discussionTags = $this->discussionTag->get();
        return ResponseHelper::success(DiscussionTagResource::collection($discussionTags), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param DiscussionTagRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(DiscussionTagRequest $request): JsonResponse
    {
        $this->discussionTag->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param DiscussionTagRequest $request [explicite description]
     * @param DiscussionTag $discussionTag [explicite description]
     *
     * @return JsonResponse
     */
    public function update(DiscussionTagRequest $request, DiscussionTag $discussionTag): JsonResponse
    {
        $this->discussionTag->update($discussionTag->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param DiscussionTag $discussionTag [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(DiscussionTag $discussionTag): JsonResponse
    {
        $this->discussionTag->delete($discussionTag->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
