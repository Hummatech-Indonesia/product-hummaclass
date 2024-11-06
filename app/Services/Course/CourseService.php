<?php

namespace App\Services\Course;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\StoreCourseRequest;
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
    public function store(StoreCourseRequest $request): array|bool
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['photo'] = $this->upload(UploadDiskEnum::COURSES->value, $request->file('photo'));
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
            $photo = $this->upload(UploadDiskEnum::COURSES->value, $request->file('photo'));
        }

        $data['photo'] = $photo;
        return $data;
    }
}
