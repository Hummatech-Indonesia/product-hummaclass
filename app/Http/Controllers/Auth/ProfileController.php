<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Services\Auth\ProfileService;
use Symfony\Component\HttpFoundation\Request;
use App\Contracts\Interfaces\Auth\ProfileInterface;


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
    public function update(ProfileRequest $request): JsonResponse
    {
        $this->profile->update(auth()->user()->id, $this->service->update($request));
        return ResponseHelper::success(null, trans('alert.profile_updated'));
    }
}
