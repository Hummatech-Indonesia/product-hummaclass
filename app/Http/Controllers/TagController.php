<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\TagInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagInterface $tag;
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tags = $this->tag->get();
        return ResponseHelper::success(TagResource::collection($tags), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param TagRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(TagRequest $request): JsonResponse
    {
        $this->tag->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param Tag $tag [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        $tag = $this->tag->show($tag->id);
        return ResponseHelper::success(TagResource::make($tag), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param Tag $tag [explicite description]
     * @param TagRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function update(Tag $tag, TagRequest $request): JsonResponse
    {
        $this->tag->update($tag->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Tag $tag [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $this->tag->delete($tag->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
