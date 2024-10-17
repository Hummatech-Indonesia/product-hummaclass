<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use PaginationTrait;
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
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
     * Method getByAuth
     *
     * @return JsonResponse
     */
    public function getByAuth(): JsonResponse
    {
        $user = $this->user->show(auth()->user()->id);
        return ResponseHelper::success(UserResource::make($user), trans('alert.fetch_success'));
    }
}
