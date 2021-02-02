<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function show(Request $request)
    {
    }

    public function verify(Request $request)
    {
        $userID = $request['id'];
        $user = User::query()->findOrFail($userID);
        $date = date("Y-m-d g:i:s");
        $user->email_verified_at = $date;
        $user->save();
        return response([
            'message' => 'Email verified',
        ]);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
        }
        $request->user()->sendApiEmailVerificationNotification();
        return response([
            'message' => 'The notification has been resubmitted',
        ]);
    }
}
