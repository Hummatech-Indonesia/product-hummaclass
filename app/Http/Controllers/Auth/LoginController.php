<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private LoginService $service;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function showLoginForm(LoginRequest $request): JsonResponse
    {
        return $this->service->handleLogin($request);
    }
}
