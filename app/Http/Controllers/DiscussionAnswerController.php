<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\DiscussionAnswerInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionAnswerRequest;
use App\Http\Resources\DiscussionAnswerResource;
use App\Models\Discussion;
use App\Models\DiscussionAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscussionAnswerController extends Controller
{
    private DiscussionAnswerInterface $discussionAnswer;
    public function __construct(DiscussionAnswerInterface $discussionAnswer)
    {
        $this->discussionAnswer = $discussionAnswer;
    }
    /**
     * Method index
     *
     * @param Discussion $discussion [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Discussion $discussion): JsonResponse
    {
        $discussionAnswers = $this->discussionAnswer->getWhere($discussion->id);
        return ResponseHelper::success(DiscussionAnswerResource::collection($discussionAnswers), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param DiscussionAnswerRequest $request [explicite description]
     * @param Discussion $discussion [explicite description]
     * @param DiscussionAnswer $discussionAnswer [explicite description]
     *
     * @return JsonResponse
     */
    public function store(DiscussionAnswerRequest $request, Discussion $discussion, DiscussionAnswer $discussionAnswer = null): JsonResponse
    {
        $data = $request->validated();
        $data['discussion_id'] = $discussion->id;
        $data['user_id'] = auth()->user()->id;
        if ($discussionAnswer) {
            $data['discussion_answer_id'] = $discussionAnswer->id;
        }
        $this->discussionAnswer->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method update
     *
     * @param DiscussionAnswerRequest $request [explicite description]
     * @param DiscussionAnswer $discussionAnswer [explicite description]
     *
     * @return JsonResponse
     */
    public function update(DiscussionAnswerRequest $request, DiscussionAnswer $discussionAnswer): JsonResponse
    {
        $this->discussionAnswer->update($discussionAnswer->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param DiscussionAnswer $discussionAnswer [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(DiscussionAnswer $discussionAnswer): JsonResponse
    {
        $this->discussionAnswer->delete($discussionAnswer->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
