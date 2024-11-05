<?php

namespace App\Services\Auth;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Traits\UploadTrait;

class ProfileService implements ShouldHandleFileUpload
{

    use UploadTrait;

    public function update(ProfileRequest $request): array|bool
    {
        $data = $request->validated();
        $photo = auth()->user()->photo;
        $banner = auth()->user()->banner;

        if ($request->hasFile('photo')) {
            if ($photo) {
                $this->remove($photo);
            }
            $photo = $this->upload(UploadDiskEnum::USERS->value, $request->file('photo'));
        }

        if ($request->hasFile('photo')) {
            if ($banner) {
                $this->remove($banner);
            }
            $banner = $this->upload(UploadDiskEnum::USERS->value, $request->file('banner'));

        }

        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'photo' => $photo,
            'banner' => $banner,
        ];
    }
}