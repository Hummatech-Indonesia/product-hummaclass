<?php

namespace App\Services\Course;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Traits\UploadTrait;

class CourseService implements ShouldHandleFileUpload
{

    use UploadTrait;


    /**
     * store
     *
     * @return array
     */
    public function store(CourseRequest $request): array|bool
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadSlug(UploadDiskEnum::COURSES->value, $request->file('photo'), false);
        }

        return $data;
    }


    /**
     * update
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return array
     */
    public function update(User $user, ProfileRequest $request): array|bool
    {
        $data = $request->validated();
        $photo = $user->photo;

        if ($request->hasFile('photo')) {
            if ($photo) {
                $this->remove($photo);
            }
            $photo = $this->uploadSlug(UploadDiskEnum::COURSES->value, $request->file('photo'), false);
        }

        $data['photo'] = $photo;
        return $data;
    }
}
