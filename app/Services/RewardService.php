<?php

namespace App\Services;

use App\Base\Interfaces\uploads\ShouldHandleFileUpload;
use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\BlogViewInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RewardInterface;
use App\Contracts\Interfaces\UserRewardInterface;
use App\Enums\RewardStatusEnum;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Http\Requests\UserRewardRequest;
use App\Models\Blog;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserReward;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class RewardService implements ShouldHandleFileUpload
{

    use UploadTrait;
    private RewardInterface $reward;
    private UserRewardInterface $userReward;
    private UserInterface $user;
    public function __construct(RewardInterface $reward, UserRewardInterface $userReward, UserInterface $user)
    {
        $this->reward = $reward;
        $this->user = $user;
        $this->userReward = $userReward;
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
    public function claim(Reward $reward)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'reward_id' => $reward->id,
            'status' => RewardStatusEnum::PENDING->value,
        ];
        $user = User::findOrFail(auth()->user()->id);
        $lastReward = $user->userRewards()->where([
            'reward_id' => $reward->id
        ])->latest()->firstOrFail();
        if (auth()->user()->point < $reward->points_required || $lastReward->status == RewardStatusEnum::PENDING->value) {
            return 'failed';
        }
        $this->userReward->store($data);
        return 'success';
    }
    public function change(UserRewardRequest $request, UserReward $userReward)
    {
        $data = $request->validated();
        $currentPoint = $userReward->user->point - $userReward->reward->points_required;
        if ($data['status'] == RewardStatusEnum::SUCCESS->value) {
            $this->user->customUpdate($userReward->user->id, [
                'point' => $currentPoint
            ]);
        }
        $this->userReward->update($userReward->id, $data);
    }
}
