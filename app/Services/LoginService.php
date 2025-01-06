<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginService
{
    public function handleLogin(LoginRequest $request): mixed
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $roles = auth()->user()->roles->pluck('name');
            $data['user'] = auth()->user();
            $data['user']->roles = $roles;
            $data['token'] = auth()->user()->createToken('auth_token')->plainTextToken;

            if ($request->remember) {
                $cookie = cookie('remember_me', true, 525600);
                return ResponseHelper::success($data, trans('auth.success'))->cookie($cookie);
            }

            return ResponseHelper::success($data, trans('auth.success'));
        }

        return ResponseHelper::error(null, trans('auth.failed'), Response::HTTP_BAD_REQUEST);
    }
}
    