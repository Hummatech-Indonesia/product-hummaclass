<?php

namespace App\Services;

use App\Contracts\Interfaces\RegisterInterface;
use App\Helpers\ResponseHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Response;

class RegisterService
{

    private RegisterInterface $register;
    /**
     * Method __construct
     *
     * @param RegisterInterface $register [explicite description]
     *
     * @return void
     */
    public function __construct(RegisterInterface $register)
    {
        $this->register = $register;
    }

    /**
     * Method handleRegister
     *
     * @param RegisterRequest $request [explicite description]
     *
     * @return void
     */
    public function handleRegister(RegisterRequest $request): mixed
    {
        $data = $request->validated();
        $password = bcrypt($data['password']);
        $user = $this->register->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
        ]);
        auth()->attempt(['email' => $user['email'], 'password' => $data['password']]);

        $data['token'] =  auth()->user()->createToken('auth_token')->plainTextToken;
        return ResponseHelper::success($data, trans('auth.success'));
    }
}
