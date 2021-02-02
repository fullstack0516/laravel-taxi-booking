<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    /**
     * CheckoutController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customer = Auth::user();
        if (!$customer->stripe_id) {
            $customer->createAsStripeCustomer();
        }
        return view('checkout')->with([
            'amount' => '',
            'intent' => $customer->createSetupIntent(),
        ]);
    }
}
