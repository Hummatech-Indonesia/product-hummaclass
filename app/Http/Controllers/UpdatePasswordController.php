<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    protected UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function update(UpdatePasswordRequest $request)
    {
        $updated = $this->user->update(auth()->user()->id, ['password' => \Illuminate\Support\Facades\Hash::make($request->new_password)]);
        if($updated) {
            return ResponseHelper::success(null, "Password berhasil diperbarui");
        } else {
            return ResponseHelper::error(null, "Password gagal diperbarui");
        }
    }
}
