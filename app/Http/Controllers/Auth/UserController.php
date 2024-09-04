<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        $data = $this->user->search($request);
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
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
}
