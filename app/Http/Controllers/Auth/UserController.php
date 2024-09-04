<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
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
}
