<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetPasswordRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    public function sendEmail(SendResetPasswordRequest $request)
    {
        $data = $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? ResponseHelper::success(null, "Link reset sudah dikirim, mohon cek email anda")
            : ResponseHelper::error(null, "Terjadi kesalahan");
    }


    // return token untuk reset
    public function resetToken(Request $request)
    {
        return ResponseHelper::success(['token' => $request->token]);
    }

    // reset password
    public function reset(Request $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();


                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? ResponseHelper::success(null, "Berhasil reset password")
            : ResponseHelper::error(null, "Reset password gagal");
    }
}
