<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Event;
use App\Models\User;
use App\Traits\UploadTrait;

class EventService implements ShouldHandleFileUpload
{

    use UploadTrait;

    public function store(EventRequest $request): array|bool
    {
        $data = $request->validated();
        $event = Event::create([
            'image'=>$data[''],
            'title'=>$data[''],
            'description'=>$data[''],
            'location'=>$data[''],
            'capacity'=>$data[''],
            'price'=>$data[''],
            'start_date'=>$data[''],
            'has_certificate'=>$data[''],
            'is_online'=>$data[''],
        ]);
    }
}
