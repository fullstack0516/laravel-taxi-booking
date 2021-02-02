<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Ride;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewAcceptedDriver;
use App\Notifications\NewAppliedDriver;
use App\Notifications\RideAccepted;
use App\Notifications\RideCancelled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    /**
     * BidController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => [
                'required',
                'numeric',
                'gte:price_min',
            ],
//            'description' => 'required|min:10',
            'description' => '',
//            'attach_file' => '',
            'ride_id' => 'required',
        ]);
        $data = $validator->validate();
        $ride = Ride::query()->findOrFail($data['ride_id']);
        $bid = new Bid([
            'price' => $data['price'],
            'description' => $data['description'],
//            'attach_file' => $data['attach_file'],
            'driver_id' => $request->user()->id,
        ]);
        $customer = $ride->owner;
        $ride->bids()->save($bid);
        $customer->notify(new NewAppliedDriver($request->user(), $bid));
        return redirect()->route('rides.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }

    public function accept(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bid_id' => 'required'
        ]);
        $validator->validate();
        $bid = Bid::query()->findOrFail($request->input('bid_id'));
        $now = new \DateTime();
        $bid->accepted_at = $now;
        $bid->save();
        $bid->ride->accepted_at = $now;
        $bid->ride->save();
        $bid->ride->driver_id = $bid->driver_id;
        $bid->driver->notify(new RideAccepted($bid->ride));
        $bid->ride->accepted_salary = $bid->price;
        $bid->ride->save();
        return redirect()->route('rides.show', ['ride' => $bid->ride->id]);
    }

    //
    public function acceptFromDriver(Request $request, int $id)
    {
        $ride = Ride::query()->findOrFail($id);
        $bid = new Bid([
            'price' => $ride->price_min,
            'driver_id' => $request->user()->id,
        ]);
        $customer = $ride->owner;
        $ride->bids()->save($bid);

        $now = new \DateTime();
        $bid->accepted_at = $now;
        $bid->save();
        $ride->accepted_at = $now;
        $ride->driver_id = $request->user()->id;
        $ride->save();

        $customer->notify(new NewAcceptedDriver($request->user(), $ride));
        return redirect()->route('rides.show', ['ride' => $ride->id]);
    }

    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bid_id' => 'required'
        ]);
        $validator->validate();
        $bid = Bid::query()->findOrFail($request->input('bid_id'));
        $bid->accepted_at = null;
        $bid->save();
        $bid->driver->notify(new RideCancelled($bid->ride));

        $bid->ride->accepted_at = null;
        $bid->ride->driver_id = null;
        $bid->ride->accepted_salary = 0;
        $bid->ride->save();
        return back()->with('success', 'Canceled');
    }

    public function checkoutPage($id)
    {
        $bid = Bid::query()->findOrFail($id);
        $customer = Auth::user();
        if (!$customer->stripe_id) {
            $customer->createAsStripeCustomer();
        }
        return view('admin.checkout-bid')->with([
            'bid' => $bid,
            'intent' => $customer->createSetupIntent(),
        ]);
    }

    public function checkout(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'nameOnCard' => 'required|string',
        ]);
        $validator->validate();

        $customer = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $customer->addPaymentMethod($paymentMethod);
        $bid = Bid::query()->findOrFail($id);
        $payment = $customer->charge($bid->price * 100, $paymentMethod);
        if ($payment->isSucceeded()) {
            $paymentIntent = $payment->asStripePaymentIntent();
            Transaction::query()->create([
                'sender_id' => $request->user()->id,
                'receiver_id' => $bid->driver->id,
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $paymentIntent->amount,
                'customer_id' => $paymentIntent->customer,
                'payment_method_id' => $paymentIntent->payment_method,
                'currency' => $paymentIntent->currency,
                'description' => $paymentIntent->description
            ]);
            $now = new \DateTime();
            $bid->paid_at = $now;
            $bid->save();
            $bid->ride->completed_at = $now;
            $bid->ride->driver_id = $bid->driver_id;
            $bid->ride->accepted_salary = $bid->price;
            $bid->ride->save();

            // TODO Send Money to driver

            return redirect()->route('rides.index');
        } else {
            return back()->with('error', 'Error');
        }
    }
}
