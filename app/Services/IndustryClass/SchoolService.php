<?php

namespace App\Services\IndustryClass;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\IndustryClass\SchoolRequest;
use App\Models\Blog;
use App\Models\School;
use App\Traits\UploadTrait;

class SchoolService implements ShouldHandleFileUpload
{
    use UploadTrait;


    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(SchoolRequest $request): array|bool
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->upload(UploadDiskEnum::SCHOOL->value, $request->file('photo'));
        }
        return $data;
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $school
     * @return array
     */
    public function update(SchoolRequest $request, School $school): array|bool
    {
        $data = $request->validated();
        $photo = $school->photo;
        if ($request->hasFile('photo')) {
            if ($photo) {
                $this->remove($photo);
            }
            $data['photo'] = $this->upload(UploadDiskEnum::SCHOOL->value, $request->file('photo'));
        }
        return $data;
    }
}
