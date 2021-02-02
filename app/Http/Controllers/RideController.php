<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\RideType;
use App\Models\User;
use App\Notifications\RideAlerts;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller
{

    public function index(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        if (auth()->check()) {
            if (auth()->user()->hasRole('customer')) {
                $customer = auth()->user();
                $rides = $customer->myRides()->orderByDesc('created_at')->paginate(15);
                return view('admin.manage-jobs')->with([
                    'rides' => $rides
                ]);
            } elseif (auth()->user()->hasRole('admin')) {
                $rides = Ride::query()->orderByDesc('created_at')->paginate(5);
                return view('admin.manage-jobs-admin')->with([
                    'rides' => $rides
                ]);
            } elseif (auth()->user()->hasRole('driver')) {
                $user_city = null;
                foreach (auth()->user()->cities as $city) {
                    $user_city = $city;
                }
                if ($user_city) {
                    if ($latitude && $longitude) {
                        $position = new Point($latitude, $longitude);
                        $rides = Ride::distance('location_from', $position, 10)->whereNull('completed_at')->orderByDesc('created_at')->paginate(4);
                        return view('browse-jobs')->with([
                            'rides' => $rides,
                        ]);
                    }
                    $rides = $user_city->rides()->whereNull('completed_at')->orderByDesc('created_at')->paginate(4);
                    return view('browse-jobs')->with([
                        'rides' => $rides,
                    ]);
                }
            }
        } else {
            if ($latitude && $longitude) {
                $position = new Point($latitude, $longitude);
                $rides = Ride::distance('location_from', $position, 10)->orderByDesc('created_at')->paginate(4);
                return view('browse-jobs')->with([
                    'rides' => $rides,
                ]);
            }
            $rides = Ride::query()->orderByDesc('created_at')->paginate(4);
            return view('browse-jobs')->with([
                'rides' => $rides,
            ]);
        }
    }

    public function create()
    {
        $types = RideType::all();
        $user = auth()->user();
        $user_city = null;
        foreach ($user->cities as $city) {
            $user_city = $city;
        }
        if ($user_city == null) {
            return redirect()->route('settings')->withErrors(['Please select your city']);
        }
        if ($user_city->country_code == 'us') {
            $currency = 'USD';
        } elseif($user_city->country_code == 'in') {
            $currency = 'INR';
        } else {
            $currency = 'USD';
        }
        return view('admin.post-job')->with([
            'types' => $types,
            'currency' => $currency,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|min:5',
            'ride_type' => 'required',
            'seats' => 'required|numeric',
            'salary_min' => 'required|numeric',
//            'salary_max' => 'required|numeric|gte:salary_min',
            'address_from' => 'required|string',
            'location_from_lat' => 'required|numeric',
            'location_from_lng' => 'required|numeric',
            'address_to' => 'required|string',
            'location_to_lat' => 'required|numeric',
            'location_to_lng' => 'required|numeric',
            'time_from' => 'required|date',
//            'time_to' => 'required|date|after:time_from',
//            'description' => 'required|min:10',
            'description' => '',
//            'file_path' => ''
        ]);
        $data = $validator->validate();
        $locationFrom = new Point($data['location_from_lat'], $data['location_from_lng']);
        $locationTo = new Point($data['location_to_lat'], $data['location_to_lng']);
        $user_city = null;
        foreach (auth()->user()->cities as $city) {
            $user_city = $city;
        }
        $ride = new Ride([
            'title' => str_random(),
            'ride_type_id' => $data['ride_type'],
            'seats' => $data['seats'],
            'price_min' => $data['salary_min'],
//            'price_max' => $data['salary_max'],
            'address_from' => $data['address_from'],
            'address_to' => $data['address_to'],
            'description' => $data['description'],
            'city_id' => $user_city->id,
//            'file_path' => $data['file_path'],
        ]);
        $ride->location_from = $locationFrom;
        $ride->location_to = $locationTo;
        $ride->time_from = new \DateTime($data['time_from']);
//        $ride->time_to = new \DateTime($data['time_to']);

        auth()->user()->myRides()->save($ride);
        $drivers = User::query()->whereHas('roles', function (Builder $query) {
            $query->where('name', 'driver');
        })->whereHas('currentLocation', function (Builder $query) {
            $lat = request()->input('location_from_lat');
            $lng = request()->input('location_from_lng');
            $locationFrom = new Point($lat, $lng);
            $query->whereRaw("st_distance(`location`, ST_GeomFromText(?)) <= ?", [
                $locationFrom->toWkt(),
                75,
            ]);
        })->get();
        foreach ($drivers as $driver) {
            $driver->notify(new RideAlerts($ride));
        }
        $request->session()->forget('address_from');
        $request->session()->forget('address_to');

        return redirect()->route('rides.index');
    }

    public function show(int $id)
    {
        $ride = Ride::query()->findOrFail($id);
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->id == $ride->owner->id) {
                return view('admin.show-job')->with([
                    'ride' => $ride,
                    'bids' => $ride->bids()->orderBy('accepted_at', 'desc')->get(),
                ]);
            } else {
                if ($user->hasRole('admin')) {
                    return view('admin.show-job-admin')->with([
                        'ride' => $ride,
                        'bids' => $ride->bids()->orderBy('accepted_at', 'desc')->get(),
                    ]);
                } elseif ($user->hasRole('driver')) {
                    $applied = false;
                    if ($ride->bids()->where('driver_id', $user->id)->first()) {
                        $applied = true;
                    }
                    $accepted = false;
                    if ($applied == true) {
                        $bid = $ride->bids()->where('driver_id', $user->id)->first();
                        if ($bid->accepted_at) {
                            $accepted = true;
                        }
                    }

                    if ($accepted) {
                        return redirect()->route('rides.track', ['ride' => $ride->id]);
                    }

                    return view('show-job')->with([
                        'ride' => $ride,
                        'applied' => $applied,
                    ]);
                }
            }
        } else {
            return view('show-job-guest')->with([
                'ride' => $ride,
            ]);
        }
//        if (auth()->check()) {
//            if (auth()->user()->getAuthIdentifier() == $ride->owner->id) {
//                return view('admin.show-job')->with([
//                    'ride' => $ride,
//                    'bids' => $ride->bids()->orderBy('accepted_at', 'desc')->get(),
//                ]);
//            } elseif (auth()->user()->hasRole('admin')) {
//                return view('admin.show-job')->with([
//                    'ride' => $ride,
//                    'bids' => $ride->bids()->orderBy('accepted_at', 'desc')->get(),
//                ]);
//            }
//        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ride  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $ride = Ride::query()->findOrFail($id);
        $types = RideType::all();
        return view('admin.edit-job')->with([
            'ride' => $ride,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ride  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|min:5',
            'ride_type' => 'required',
            'seats' => 'required|numeric',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric|gte:salary_min',
            'address_from' => 'required|string',
            'location_from_lat' => 'required|numeric',
            'location_from_lng' => 'required|numeric',
            'address_to' => 'required|string',
            'location_to_lat' => 'required|numeric',
            'location_to_lng' => 'required|numeric',
            'time_from' => 'required|date',
//            'time_to' => 'required|date|after:time_from',
//            'description' => 'required|min:10',
            'description' => '',
//            'file_path' => ''
        ]);

        $data = $validator->validate();

        $locationFrom = new Point($data['location_from_lat'], $data['location_from_lng']);
        $locationTo = new Point($data['location_to_lat'], $data['location_to_lng']);
        $ride = Ride::query()->findOrFail($id);

//        $ride->title = $data['title'];
        $ride->ride_type_id = $data['ride_type'];
        $ride->seats = $data['seats'];
        $ride->price_min = $data['salary_min'];
        $ride->price_max = $data['salary_max'];
        $ride->address_from = $data['address_from'];
        $ride->address_to = $data['address_to'];
        $ride->description = $data['description'];
        $ride->location_from = $locationFrom;
        $ride->location_to = $locationTo;
        $ride->time_from = new \DateTime($data['time_from']);
//        $ride->time_to = new \DateTime($data['time_to']);

        auth()->user()->myRides()->save($ride);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $ride = Ride::query()->findOrFail($id);
        try {
            $ride->delete();
        } catch (\Exception $e) {
        }
        return back();
    }

    public function track(int $id)
    {
        $ride = Ride::query()->findOrFail($id);
        $user = auth()->user();
        if ($user->hasRole('driver')) {
            return view('admin.track-ride')->with([
                'ride' => $ride,
            ]);
        } elseif ($user->hasRole('customer')) {
            return view('admin.track-driver')->with([
                'ride' => $ride,
            ]);
        } else {
            return view('admin.track-driver-customer');
        }
    }

}
