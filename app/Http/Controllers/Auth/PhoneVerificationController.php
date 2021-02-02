<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use jeremykenedy\LaravelRoles\Models\Role;
use Twilio\Exceptions\TwilioException;
use Twilio\TwiML\VoiceResponse;

class PhoneVerificationController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
            ? redirect()->route('dashboard')
            : view('auth.verifyphone');
    }

    public function send(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
            ? redirect()->route('dashboard')
            : view('auth.send-sms');
    }

    public function verifyPhone(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'min:7',
                'max:14',
//                Rule::unique('users')->ignore($user->getAuthIdentifier()),
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->phone_number = $request->input('phone_number');
        $user->save();
        try {
            $user->smsToVerify();
        } catch (TwilioException $exception) {
            return back()->withErrors(new MessageBag(['exception' => 'The \'To\' number +6502791243 is not a valid phone number.']))->withInput();
        }
        return redirect()->route('phoneverification.notice');
    }

    public function verify(Request $request)
    {
        if ($request->user()->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }

        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->route('dashboard');
        }

        $request->user()->markPhoneAsVerified();
        $profile = new Profile();
        $request->user()->profile()->save($profile);

        return redirect()->route('dashboard')->with('status', 'Your phone was successfully verified!');
    }

    public function buildTwiML($code)
    {
        $code = $this->formatCode($code);
        $response = new VoiceResponse();
        $response->say("Hi, thanks for Joining. This is your verification code. {$code}. I repeat, {$code}.");
        echo $response;
    }

    public function formatCode($code)
    {
        $collection = collect(str_split($code));
        return $collection->reduce(
            function ($carry, $item) {
                return "{$carry}. {$item}";
            }
        );
    }
}
