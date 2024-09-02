<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Services\Auth\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private ProfileInterface $profile;
    private ProfileService $service;
    /**
     * Method __construct
     *
     * @param ProfileInterface $profile [explicite description]
     *
     * @return void
     */
    public function __construct(ProfileInterface $profile, ProfileService $service)
    {
        $this->profile = $profile;
        $this->service = $service;
    }
    /**
     * Method update
     *
     * @param ProfileRequest $request [explicite description]
     * @param User $user [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ProfileRequest $request, User $user): JsonResponse
    {

        $this->profile->update($user->id, $this->service->update($user, $request));
        return ResponseHelper::success(trans('alert.profile_updated'));
    }
}
