<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Enums\ChallengeSubmitEnum;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\ChallengeRequest;
use App\Http\Requests\ChallengeSubmitRequest;
use App\Http\Requests\PointChallengeSubmitRequest;
use App\Models\Challenge;
use App\Models\ChallengeSubmit;
use App\Models\Student;
use App\Traits\UploadTrait;

class ChallengeSubmitService implements ShouldHandleFileUpload
{
    use UploadTrait;    
    private StudentInterface $student;

    public function __construct(StudentInterface $student)
    {
        $this->student = $student;
    }

    public function store(ChallengeSubmitRequest $request, Challenge $challenge)
    {
        $data = $request->validated();
        $student = Student::where('user_id', auth()->user()->id)->firstOrFail();

        if ($challenge->image_active == 1 && $request->hasFile('image')) {
            $data['image'] = $this->upload(UploadDiskEnum::IMAGE->value, $request->file('image'));
        }

        if ($challenge->file_active == 1 && $request->hasFile('file')) {
            $data['file'] = $this->upload(UploadDiskEnum::FILE->value, $request->file('file'));
        }

        $data['link'] = $challenge->link_active == 1 ? $data['link'] : null;
        $data['student_id'] = $student->id;
        $data['challenge_id'] = $challenge->id;
        return $data;
    }

    public function update(ChallengeSubmitRequest $request, ChallengeSubmit $challengeSubmit)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->remove($challengeSubmit->image);
            $data['image'] = $this->upload(UploadDiskEnum::IMAGE->value, $request->file('image'));
        } else {
            $data['image'] = $challengeSubmit->image;
        }

        if ($request->hasFile('file')) {
            $this->remove($challengeSubmit->file);
            $data['file'] = $this->upload(UploadDiskEnum::FILE->value, $request->file('file'));
        } else {
            $data['file'] = $challengeSubmit->file;
        }

        if ($data['link'] != null ) {
            $data['link'] = $data['link'];
        }
        
        return $data;
    }

    public function delete(ChallengeSubmit $challengeSubmit)
    {
        $this->remove($challengeSubmit->image);
        $this->remove($challengeSubmit->file);
    }

    public function add_point(PointChallengeSubmitRequest $request)
    {
        $data = $request->validated();
        $data['status'] = ChallengeSubmitEnum::CONFIRMED->value;
        return $data;
    }
}
