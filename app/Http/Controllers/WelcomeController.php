<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WelcomeController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('welcome')->with([
            'cities' => $cities,
        ]);
    }

    public function postRide(Request $request)
    {
        if (auth()->check() && auth()->user()->hasRole('driver')) {
            return back();
        }
        $validator = Validator::make($request->all(), [
            'address_from' => 'required',
            'address_to' => 'required'
        ]);
        $validator->validate();
        $request->session()->put('address_from', $request->input('address_from'));
        $request->session()->put('address_to', $request->input('address_to'));

        return redirect()->route('rides.create');
    }
}
