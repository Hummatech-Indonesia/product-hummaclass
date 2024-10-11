<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\DiscussionInterface;
use App\Contracts\Interfaces\DiscussionTagInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\DiscussionRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Blog;
use App\Models\Discussion;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class DiscussionService
{
    private DiscussionTagInterface $discussionTag;
    private DiscussionInterface $discussion;
    public function __construct(DiscussionTagInterface $discussionTag, DiscussionInterface $discussion)
    {
        $this->discussionTag = $discussionTag;
        $this->discussion = $discussion;
    }
    public function store(DiscussionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $discussion = $this->discussion->store($data);
        
        foreach ($data['tag_id'] as $index => $tag_id) {
            $data['tag_id'] = $tag_id;
            $data['discussion_id'] = $discussion->id;
            $this->discussionTag->store($data);
        }
        
    }
}
