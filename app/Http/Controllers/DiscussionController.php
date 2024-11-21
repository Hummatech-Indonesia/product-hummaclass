<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\DiscussionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionRequest;
use App\Http\Resources\DiscussionResource;
use App\Models\Course;
use App\Models\Discussion;
use App\Services\DiscussionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    private DiscussionInterface $discussion;
    private DiscussionService $service;
    private CourseInterface $course;
    public function __construct(DiscussionInterface $discussion, DiscussionService $service, CourseInterface $course)
    {
        $this->discussion = $discussion;
        $this->course = $course;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Request $request, string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($request, $slug);
        // dd($course);
        $discussions = $this->discussion->getWhere($request, ['course_id' => $course->id]);
        // dd($discussions);
        return ResponseHelper::success(DiscussionResource::collection($discussions), trans('alert.fetch_success'));
    }

    /**
     * Method store
     *
     * @param DiscussionRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(DiscussionRequest $request, string $slug): JsonResponse
    {
        $course = $this->course->showWithSlug($slug);

        $this->service->store($request, $course);
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
