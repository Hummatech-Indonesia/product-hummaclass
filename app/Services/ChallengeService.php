<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Http\Requests\ChallengeRequest;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use App\Models\CourseTest;

class ChallengeService implements ShouldHandleFileUpload
{
    use UploadTrait;

    public function store(ChallengeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    public function update(ChallengeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

}
