<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadTrait
{
    /**
     * delete specified file in storage
     * @param string $file
     * @return void
     */

    public function remove(string $file): void
    {
        if ($this->exist($file)) Storage::delete($file);
    }

    /**
     * check specified file in storage
     * @param string $file
     * @return bool
     */

    public function exist(string $file): bool
    {
        return Storage::exists($file);
    }

    /**
     * Handle upload file to storage
     * @param string $disk
     * @param UploadedFile $file
     * @param bool $originalName
     * @return string
     */

    public function upload(string $disk, UploadedFile $file, bool $originalName = false): string
    {
        $this->makeDirectory($disk);

        if ($originalName) {
            return $file->storeAs('/public/' . $disk, $file->getClientOriginalName());
        }

        return Storage::put('/public/' . $disk, $file);
    }
    /**
     * uploadSlug
     *
     * @param  mixed $disk
     * @param  mixed $file
     * @param  mixed $slug
     * @param  mixed $originalName
     * @return string
     */
    public function uploadSlug(string $disk, UploadedFile $file, string $slug, bool $originalName = false): string
    {
        if (!Storage::exists($disk)) {
            Storage::makeDirectory($disk);
        }

        $slug = str_replace(' ', '-', $slug);
        $slug = str_replace(':', '-', $slug);

        $fileName = $originalName
            ? $file->getClientOriginalName()
            : Str::random(10) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($disk, $fileName);
    }

    /**
     * Handle Make Directory if the folder doesn't exist
     * @param string $disk
     * @return void
     */

    public function makeDirectory(string $disk): void
    {
        if (!$this->exist($disk)) Storage::makeDirectory($disk);
    }
}
