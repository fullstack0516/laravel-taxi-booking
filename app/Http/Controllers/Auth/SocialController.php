<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Social;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function getSocialRedirect($provider)
    {
        $providerKey = Config::get('services.'.$provider);

        if (empty($providerKey)) {
            return view('pages.status')
                ->with('error', trans('socials.noProvider'));
        }

        return Socialite::with($provider)->redirect();
    }

    public function getSocialHandle(Request $request, $provider)
    {
        if ($request->query('denied') != '') {
            return redirect()->to('login')
                ->with('status', 'danger')
                ->with('message', trans('socials.denied'));
        }

        $socialUserObject = Socialite::driver($provider)->user();

        $socialUser = null;

        // Check if email is already registered
        $userCheck = User::where('email', '=', $socialUserObject->email)->first();

        $email = $socialUserObject->email;

        if (!$socialUserObject->email) {
            $email = 'missing'.str_random(10).'@'.str_random(10).'.example.org';
        }

        if (empty($userCheck)) {
            $sameSocialId = Social::where('social_id', '=', $socialUserObject->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($sameSocialId)) {
                $socialData = new Social();
                $profile = new Profile();
                $unverifiedRole = Role::where('slug', '=', 'unverified')->first();
                $fullname = explode(' ', $socialUserObject->name);
                if (count($fullname) == 1) {
                    $fullname[1] = '';
                }
                $username = $socialUserObject->nickname;

                if ($username == null) {
                    foreach ($fullname as $name) {
                        $username .= $name;
                    }
                }

                // Check to make sure username does not already exist in DB before recording
                $username = $this->checkUserName($username, $email);

                $user = User::query()->create([
                    'name'                 => $username,
                    'first_name'           => $fullname[0],
                    'last_name'            => $fullname[1],
                    'email'                => $email,
                    'password'             => bcrypt(str_random(40)),
                    'token'                => str_random(64),
                    'signup_ip_address' => $request->getClientIp(),
                    'signup_confirmation_ip_address' => $request->getClientIp(),
                ]);

                $user->markEmailAsVerified();

                $socialData->social_id = $socialUserObject->id;
                $socialData->provider = $provider;
                $user->social()->save($socialData);
                $user->attachRole($unverifiedRole);

                $user->profile()->save($profile);
                $user->save();

                if ($socialData->provider == 'google') {
                    $user->profile->google_username = $socialUserObject->name;
                }

                if ($socialData->provider == 'facebook') {
                    $user->profile->facebook_username = $socialUserObject->nickname;
                }

                if ($socialUserObject->getAvatar()) {
                    $user->profile->avatar = $socialUserObject->getAvatar();
                }

                $user->profile->save();

                $socialUser = $user;
            } else {
                $socialUser = $sameSocialId->user;
            }

            auth()->login($socialUser, true);

            return redirect()->route('settings')->with('success', trans('socials.registerSuccess'));
        }

        $socialUser = $userCheck;

        auth()->login($socialUser, true);

        return redirect()->route('dashboard');
    }

    /**
     * Check if username against database and return valid username.
     * If username is not in the DB return the username
     * else generate, check, and return the username.
     *
     * @param string $username
     * @param string $email
     *
     * @return string
     */
    public function checkUserName($username, $email)
    {
        $userNameCheck = User::where('name', '=', $username)->first();

        if ($userNameCheck) {
            $i = 1;
            do {
                $username = $this->generateUserName($username);
                $newCheck = User::where('name', '=', $username)->first();

                if ($newCheck == null) {
                    $newCheck = 0;
                } else {
                    $newCheck = count($newCheck);
                }
            } while ($newCheck != 0);
        }

        return $username;
    }

    /**
     * Generate Username.
     *
     * @param string $username
     *
     * @return string
     */
    public function generateUserName($username)
    {
        return $username.'_'.str_random(10);
    }
}
