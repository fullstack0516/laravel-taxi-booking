<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name'            => '',
            'last_name'             => '',
//                'phone_number' => 'required|min:7|max:14|unique:users',
            'phone_number' => 'required|min:7|max:14',
        ]);
        $data = $validator->validate();

        $role = Role::query()->where('slug', '=', 'unverified')->first();
        $ipAddress = $request->getClientIp();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'signup_ip_address' => $ipAddress,
        ]);
        $accessToken = $user->createToken('authToken')->accessToken;
        $user->roles()->attach($role);

        $user->sendApiEmailVerificationNotification();

        return response([
            'message' => 'Please confirm yourself by clicking on verify user button sent to you on your email',
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $data = $validator->validate();
        if (!auth()->attempt($data)) {
            return response([
                'message' => 'Invalid credentials'
            ]);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout()
    {
        $user = auth()->user()->token();
        $user->revoke();
        return response([
            'message' => 'Logged out'
        ]);
    }
}
