<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class BlogService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private BlogViewInterface $blogView;
    public function __construct(BlogViewInterface $blogView)
    {
        $this->blogView = $blogView;
    }

    /**
     * Method store
     *
     * @param BlogRequest $request [explicite description]
     *
     * @return array
     */
    public function store(BlogRequest $request): array|bool
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->upload(UploadDiskEnum::BLOGS->value, $request->file('thumbnail'));
        }
        return $data;
    }
    /**
     * Method update
     *
     * @param BlogRequest $request [explicite description]
     * @param Blog $blog [explicite description]
     *
     * @return array
     */
    public function update(BlogRequest $request, Blog $blog): array|bool
    {
        $data = $request->validated();
        $thumbnail = $blog->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($thumbnail) {
                $this->remove($thumbnail);
            }
            $data['thumbnail'] = $this->upload(UploadDiskEnum::BLOGS->value, $request->file('thumbnail'));
        }
        return $data;
    }
    /**
     * Method delete
     *
     * @param Blog $blog [explicite description]
     *
     * @return string
     */
    public function delete(Blog $blog): string
    {
        if ($blog->thumbnail) {
            $this->remove($blog->thumbnail);
        }

        return $blog->id;
    }
    public function handleCreateBlogView(Request $request, Blog $blog): bool
    {
        $ipAddress = $request->ip();
        $this->blogView->store(['blog_id' => $blog->id, "ip_address" => $ipAddress]);
        return true;
    }
}
