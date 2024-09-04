<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginService
{
    /**
     * handleLogin
     *
     * @return mixed
     */
    public function handleLogin(LoginRequest $request): mixed
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $data['token'] =  auth()->user()->createToken('auth_token')->plainTextToken;
            return ResponseHelper::success($data, trans('auth.success'));
        }

        return ResponseHelper::error(null, trans('auth.failed'), Response::HTTP_BAD_REQUEST);
    }
}
