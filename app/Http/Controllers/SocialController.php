<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Social;
use App\Models\UserInfo;
use App\Enums\ConfigEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)
            ->with([
                'route_prefix' =>  current_subdomain(),
                'enforce_domain' =>  request()->getHttpHost(),
            ])
            ->redirect();
    }

    public function callback(string $provider)
    {
        $enforce_domain = request()->input('enforce_domain');

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Throwable $th) {
            return redirect(route('login'));
        }

        // check if already exists
        $authUser = User::where('email', $socialUser->getEmail())->first();

        $first_name = $socialUser->user['given_name'] ?? null;
        $last_name = $socialUser->user['family_name'] ?? null;
        $name = $socialUser->getNickname() ?? $socialUser->getName();

        //if doesn's exist
        if (!$authUser) {
            // create user
            $authUser = User::create([
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(16)),
                'email_verified_at' => now(),
            ]);

            UserInfo::updateOrCreate(
                ['user_id' => $authUser->id,],
                [
                    'nom' => $first_name ?? $name,
                    'prenom' => $last_name,
                ]
            );

            // create socials for user
            $authUser->createSocial($socialUser, $provider);
        }

        // if user does exist
        $socials = Social::where('provider', $provider)
            ->where('user_id', $authUser->id)->first();

        //check if user doesn't have socials and create one
        if (!$socials) {
            $authUser->createSocial($socialUser, $provider);
        }

        // login user
        Auth::login($authUser, true);

        return redirect()->intended('/');
    }
}
