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
    public function index(): JsonResponse
    {
        $discussionAnswers = $this->discussionAnswer->get();
        return ResponseHelper::success(DiscussionAnswerResource::collection($discussionAnswers), trans('alert.fetch_success'));
    }
    public function store(DiscussionAnswerRequest $request, Discussion $discussion, DiscussionAnswer $discussionAnswer = null): JsonResponse
    {
        $data = $request->validated();
        if ($discussionAnswer) {
            $data['discussion_answer_id'] = $discussionAnswer->id;
            $data['discussion_id'] = $discussion->id;
            $data['user_id'] = auth()->user()->id;
        }
        $this->discussionAnswer->store($data);
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    public function update(DiscussionAnswerRequest $request, DiscussionAnswer $discussionAnswer): JsonResponse
    {
        $this->discussionAnswer->update($discussionAnswer->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    public function destroy(DiscussionAnswer $discussionAnswer): JsonResponse
    {
        $this->discussionAnswer->delete($discussionAnswer->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
