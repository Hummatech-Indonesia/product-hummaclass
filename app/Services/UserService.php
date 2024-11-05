<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class UserService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
    public function handleUpdateBanner(UserRequest $request)
    {
        $data = $request->validated();
        $user = $this->user->show(auth()->user()->id);
        $banner = $user->banner;

        if ($request->hasFile('banner')) {
            if ($banner) {
                $this->remove($banner);
            }
            $banner = $this->upload(UploadDiskEnum::USERS->value, $request->file('banner'));
        }
        $data['banner'] = $banner;
        return $data;
    }
}
