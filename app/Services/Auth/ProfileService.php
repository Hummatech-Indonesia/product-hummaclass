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

    public function update(User $user, ProfileRequest $request): array|bool
    {
        $data = $request->validated();
        $photo = $user->photo;

        if ($request->hasFile('photo')) {
            if ($photo) {
                $this->remove($photo);
            }
            $photo = $this->upload(UploadDiskEnum::USERS->value, $request->file('photo'), "users-" . now());
        }

        return [
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'address' => $data['address'],
            'photo' => $photo,
        ];
    }
}