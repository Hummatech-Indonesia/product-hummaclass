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
        try {
            $lastReward = $user->userRewards()->where([
                'reward_id' => $reward->id
            ])->latest()->firstOrFail();
            if ($lastReward->status == RewardStatusEnum::PENDING->value) {
                return 'failed request anda masih pending';
            }
        } catch (\Throwable $e) {
            if (auth()->user()->point < $reward->points_required || $reward->stock < 1) {
                return 'failed point kurang atau stock tidak tercukupi';
            }
            $this->reward->update($reward->id, ['stock' => $reward->stock - 1]);
            $this->userReward->store($data);
            $user = User::findOrFail(auth()->user()->id);
            $user->update(['point' => auth()->user()->point - $reward->points_required]);
            return 'success';
        }
    }
    public function change(UserRewardRequest $request, UserReward $userReward)
    {
        $data = $request->validated();

        $reward = Reward::findOrFail($userReward->reward_id);
        $user = User::findOrFail(auth()->user()->id);

        if ($request->status == RewardStatusEnum::REJECTED->value) {
            $reward->update(['stock' => $reward->stock + 1]);
            $user->update(['point' => $user->point + $reward->points_required]);
        }

        $this->userReward->update($userReward->id, $data);
    }
}
