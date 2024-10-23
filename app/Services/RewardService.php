<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RewardInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Reward;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class RewardService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private RewardInterface $reward;
    public function __construct(RewardInterface $reward)
    {
        $this->reward = $reward;
    }
    public function store(StoreRewardRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload(UploadDiskEnum::REWARDS->value, $request->file('image'));
        }
        return $data;
    }
    public function update(Reward $reward, UpdateRewardRequest $request)
    {
        $data = $request->validated();
        $image = $reward->image;
        if ($request->hasFile('image')) {
            if ($image) {
                $this->remove($image);
            }
            $data['image'] = $this->upload(UploadDiskEnum::REWARDS->value, $request->file('image'));
        }
        return $data;
    }
}
