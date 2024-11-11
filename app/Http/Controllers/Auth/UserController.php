<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\Course\UserCourseInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\CustomUserEventResource;
use App\Http\Resources\UserCourseActivityResource;
use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserEventResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\User;
use App\Services\UserService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use PaginationTrait;
    private UserInterface $user;
    private UserService $service;
    private UserCourseInterface $userCourse;
    public function __construct(UserInterface $user, UserCourseInterface $userCourse, UserService $service)
    {
        $this->user = $user;
        $this->service = $service;
        $this->userCourse = $userCourse;
    }
    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->user->customPaginate($request);
        $data['paginate'] = $this->customPaginate($users->currentPage(), $users->lastPage());
        $data['data'] = UserResource::collection($users);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
    /**
     * Method show
     *
     * @param User $user [explicite description]
     *
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $data = $this->user->show($user->id);
        return ResponseHelper::success(new UserResource($data), trans('alert.fetch_success'));
    }
    /**
     * Method customUpdate
     *
     * @param UserRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function customUpdate(UserRequest $request): JsonResponse
    {
        $this->user->customUpdate(auth()->user()->id, $this->service->handleUpdateBanner($request));
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
    public function courseActivity(): JsonResponse
    {
        $user = $this->user->show(auth()->user()->id);
        return ResponseHelper::success(UserCourseResource::collection($user->userCourses), trans('alert.fetch_success'));
    }
    /**
     * Method aventActivity
     *
     * @return JsonResponse
     */
    public function eventActivity(): JsonResponse
    {
        $user = $this->user->show(auth()->user()->id);
        return ResponseHelper::success(CustomUserEventResource::collection($user->userEvents), trans('alert.fetch_success'));
    }
    /**
     * Method getByAuth
     *
     * @return JsonResponse
     */
    public function getByAuth(): JsonResponse
    {
        $user = $this->user->show(auth()->user()->id);
        return ResponseHelper::success(UserResource::make($user), trans('alert.fetch_success'));
    }
    public function newestCount(): JsonResponse
    {
        $users = $this->user->countUsersbyMonth();
        return ResponseHelper::success($users, trans('alert.fetch_success'));
    }
}
