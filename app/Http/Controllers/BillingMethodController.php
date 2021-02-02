<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillingMethodController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }
        $paymentMethods = $user->paymentMethods();
        return view('admin.billing-methods')->with([
            'user' => $user,
            'paymentMethods' => $paymentMethods,
            'intent' => $user->createSetupIntent(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'nameOnCard' => 'required|string',
        ]);
        $validator->validate();

        $user = auth()->user();
        $method_input = $request->input('payment_method');
        $methodObject = $user->addPaymentMethod($method_input);

        return back()->with('success', 'Success');
    }
}
