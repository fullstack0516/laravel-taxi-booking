<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * ReviewController constructor.
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
        return view('admin.reviews');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bid_id' => 'required',
            'on_time' => 'required',
            'on_budget' => 'required',
            'comments' => 'required|string|min:10',
            'rating' => 'required'
        ]);
        $validator->validate();
        $bid = Bid::query()->findOrFail($request->input('bid_id'));

        $user = Auth::user();
        $review = new Review([
            'customer_id' => $bid->ride->owner_id,
            'driver_id' => $bid->driver_id,
            'ride_id' => $bid->ride_id,
            'bid_id' => $bid->id,
            'comments' => $request->input('comments'),
            'on_time' => $request->input('on_time'),
            'on_budget' => $request->input('on_budget'),
            'rating' => $request->input('rating'),
        ]);
        $user->reviews()->save($review);
        return back()->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
