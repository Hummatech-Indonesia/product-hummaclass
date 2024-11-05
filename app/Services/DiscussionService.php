<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\Course\ModuleInterface;
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
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Module;
use App\Models\Tag;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class DiscussionService
{
    private DiscussionTagInterface $discussionTag;
    private DiscussionInterface $discussion;
    private ModuleInterface $module;
    public function __construct(DiscussionTagInterface $discussionTag, DiscussionInterface $discussion, ModuleInterface $module)
    {
        $this->discussionTag = $discussionTag;
        $this->discussion = $discussion;
        $this->module = $module;
    }
    public function store(DiscussionRequest $request, Course $course)
    {
        $data = $request->validated();
        $module = $this->module->show($data['module_id']);
        $data['course_id'] = $course->id;
        $data['user_id'] = auth()->user()->id;
        $discussion = $this->discussion->store($data);

        foreach ($data['tag'] as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $discussionTagData = [
                'discussion_id' => $discussion->id,
                'tag_id' => $tag->id,
            ];
            $this->discussionTag->store($discussionTagData);
        }
    }
}
