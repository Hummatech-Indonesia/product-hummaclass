<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider);

        // login user
        $auth = auth()->login($authUser, true);
        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        $user = auth()->user();
        $user->assignRole('guest');
        $roles = $user->roles->pluck('name');
        $user->roles = json_encode($roles);


        // dd($token, $user);

        // $response = Http::post(env('FRONTEND_URL') . '/save-token', [
        //     'token' => $token,
        //     'user' => $user
        // ]);

        // // Check the status code and response body
        // $status = $response->status();
        // $body = $response->body();
        // $contentType = $response->header('Content-Type');

        // dd($status, $contentType, $body);

        // if ($response->successful()) {
        //     $data = $response->json();
        

        $data['token'] = $token;
        $data['user'] = $user;
        return redirect(config('app.frontend_url'). "save-token-google/json_endcode($data)"); 

        // $response = Http::post(config('app.frontend_url') . "/save-token-google", [
        //     "token" => $token,
        //     "user" => $user
        // ])->json();

        // dd($response);


        //     //     dd('success', $data);
        // }
        // else {
        //     dd('Failed to get a successful response', $body);
        // }
        // setelah login redirect ke dashboard
        // return response()->json(['auth' => $auth]);

    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // Get Social Account
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        // Jika sudah ada
        if ($socialAccount) {
            // return user
            return $socialAccount->user;

            // Jika belum ada
        } else {

            // User berdasarkan email 
            $user = User::where('email', $socialUser->getEmail())->first();

            // Jika Tidak ada user
            if (!$user) {
                // Create user baru
                $user = User::create([
                    'name'  => $socialUser->getName(),
                    'email' => $socialUser->getEmail()
                ]);
            }

            // Buat Social Account baru
            $user->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            // return user
            return $user;
        }
    }
}
