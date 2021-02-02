<?php

namespace App\Http\Controllers;

use App\Models\StripeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{

    /**
     * StripeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $accountObject = null;
        if ($user->stripeAccount) {
            $account_id = $user->stripeAccount->account_id;
            try {
                $accountObject = \Stripe\Account::retrieve($account_id);
                if (!$accountObject->requirements->disabled_reason) {
                    $user->approved_at = Date::now();
                    $user->save();
                } else {
                    $user->approved_at = null;
                    $user->save();
                }
            } catch (ApiErrorException $e) {
            }
        }

        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        return view('admin.payment-verification')->with([
            'user' => $user,
            'accountObject' => $accountObject,
            'intent' => $user->createSetupIntent(),
        ]);
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob_year' => 'required|numeric',
            'dob_month' => 'required|numeric',
            'dob_day' => 'required|numeric',
            'phone_number' => 'required',
            'id_number' => 'required|numeric',
            'card_name' => 'required|string',
            'card_number' => 'required|size:16',
            'card_exp_month' => 'required|size:2',
            'card_exp_year' => 'required|size:4',
            'card_cvc' => 'required|size:3',
            'address_line1' => 'required|string',
            'address_line2' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string'
        ]);

        $data = $validator->validate();
        $user = $request->user();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($user->stripeAccount) {
            $account_id = $user->stripeAccount->account_id;
            try {
                $stripeToken = \Stripe\Token::create([
                    'card' => [
                        'number' => $data['card_number'],
                        'exp_month' => $data['card_exp_month'],
                        'exp_year' => $data['card_exp_year'],
                        'cvc' => $data['card_cvc'],
                        'currency' => 'USD',
                    ],
                ]);
                $accountObject = \Stripe\Account::retrieve($account_id);
                $accountObject = \Stripe\Account::update($account_id, [
                    'type' => 'custom',
                    'country' => 'US',
                    'email' => $data['email'],
                    'business_type' => 'individual',
                    'requested_capabilities' => [
                        'card_payments',
                        'transfers',
                    ],
                    'individual' => [
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'phone' => $data['phone_number'],
                        'email' => $data['email'],
                        'dob' => [
                            'day' => $data['dob_day'],
                            'month' => $data['dob_month'],
                            'year' => $data['dob_year'],
                        ],
                        'id_number' => $data['id_number'],
                        'address' => [
                            'line1' => $data['address_line1'],
                            'line2' => $data['address_line2'],
                            'city' => $data['city'],
                            'state' => $data['state'],
                        ]
                    ],
                    'external_account' => $stripeToken,
                    'tos_acceptance' => [
                        'date' => time(),
                        'ip' => $request->getClientIp(),
                        'user_agent' => $request->userAgent(),
                    ],
                ]);
            } catch (ApiErrorException $e) {
                try {
                    $stripeToken = \Stripe\Token::create([
                        'card' => [
                            'number' => $data['card_number'],
                            'exp_month' => $data['card_exp_month'],
                            'exp_year' => $data['card_exp_year'],
                            'cvc' => $data['card_cvc'],
                            'currency' => 'USD',
                        ],
                    ]);
                    $accountObject = \Stripe\Account::create([
                        'type' => 'custom',
                        'country' => 'US',
                        'email' => $data['email'],
                        'business_type' => 'individual',
                        'requested_capabilities' => [
                            'card_payments',
                            'transfers',
                        ],
                        'individual' => [
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'phone' => $data['phone_number'],
                            'email' => $data['email'],
                            'dob' => [
                                'day' => $data['dob_day'],
                                'month' => $data['dob_month'],
                                'year' => $data['dob_year'],
                            ],
                            'id_number' => $data['id_number'],
                            'address' => [
                                'line1' => $data['address_line1'],
                                'line2' => $data['address_line2'],
                                'city' => $data['city'],
                                'state' => $data['state'],
                            ],
                        ],
                        'external_account' => $stripeToken,
                        'tos_acceptance' => [
                            'date' => time(),
                            'ip' => $request->getClientIp(),
                        ],
                    ]);
                    $user->stripeAccount->account_id = $accountObject->id;
                    $user->stripeAccount->save();
                } catch (ApiErrorException $e) {
                }
            }
        } else {
            $stripeToken = \Stripe\Token::create([
                'card' => [
                    'number' => $data['card_number'],
                    'exp_month' => $data['card_exp_month'],
                    'exp_year' => $data['card_exp_year'],
                    'cvc' => $data['card_cvc'],
                    'currency' => 'USD',
                ],
            ]);
            $accountObject = \Stripe\Account::create([
                'type' => 'custom',
                'country' => 'US',
                'email' => $data['email'],
                'business_type' => 'individual',
                'requested_capabilities' => [
                    'card_payments',
                    'transfers',
                ],
                'individual' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone_number'],
                    'email' => $data['email'],
                    'dob' => [
                        'day' => $data['dob_day'],
                        'month' => $data['dob_month'],
                        'year' => $data['dob_year'],
                    ],
                    'id_number' => $data['id_number'],
                    'address' => [
                        'line1' => $data['address_line1'],
                        'line2' => $data['address_line2'],
                        'city' => $data['city'],
                        'state' => $data['state'],
                    ],
                ],
                'external_account' => $stripeToken,
                'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $request->getClientIp(),
                ],
            ]);
            $stripeAccount = new StripeAccount([
                'account_id' => $accountObject->id,
            ]);
            $user->stripeAccount()->save($stripeAccount);
        }

        return back();
    }
}
