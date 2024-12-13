<?php

namespace App\Services\Course;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
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
        if ($data['is_premium'] == 0) {
            $data['price'] = 0;
            $data['promotional_price'] = 0;
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
    public function update(Course $course, CourseUpdateRequest $request): array|bool
    {
        $data = $request->validated();
        $photo = $course->photo;

        if ($request->hasFile('photo')) {
            if ($photo) {
                $this->remove($photo);
            }
            $photo = $this->upload(UploadDiskEnum::COURSES->value, $request->file('photo'));
        }

        if ($data['is_premium'] == 0) {
            $data['price'] = 0;
            $data['promotional_price'] = 0;
        }

        $data['photo'] = $photo;
        return $data;
    }

    public function publish(Course $course)
    {
        return [
            'modules' => $course->modules->count(),
            'sub_modules' => $course->modules->sortBy('step')->first()?->subModules->count() ?? 0,
            'test' => $course->courseTest?->courseTestQuestions
        ];
    }

    public function statisticTransaction($transactions)
    {
        // return $transactions->groupBy('created_at');
    }
}
