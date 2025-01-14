<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ChallengeRequest;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use App\Models\CourseTest;
use ZipArchive;

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

    public function download_zip($folderPath, $zipFilePath)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($folderPath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
    
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
    
            $zip->close();
            
            return $zipFilePath;
        }
    }

}
