<?php
namespace App\Services;

use App\Http\Requests\SubmissionTaskRequest;
use App\Traits\UploadTrait;

class SubmissionTaskService
{
    use UploadTrait;
    public function handleStoreFile(SubmissionTaskRequest $request)
    {
        return $this->upload('submissionTask', $request->file);
    }

    public function handleRemoveFile(string $file)
    {
        return $this->remove($file);
    }
}
