<?php

namespace App\Http\Controllers;

use App\Models\City;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::query()->paginate(15);
        return view('admin.cities')->with([
            'cities' => $cities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.register-city');
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
            'postal_code' => '',
            'name' => 'required|string|unique:cities',
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'country_code' => 'required',
            'background_image' => 'required',
        ]);

        $data = $validator->validate();

        $city = City::query()->create([
            'name' => $data['name'],
            'address' => $data['address'],
            'zip_code' => $data['postal_code'],
            'country_code' => $data['country_code'],
            'background_image' => $data['background_image'],
        ]);
        $location = new Point($data['latitude'], $data['longitude']);
        $city->location = $location;
        $city->save();
        return redirect()->route('cities.index');
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
        $city = City::query()->findOrFail($id);
        return view('admin.edit-city')->with([
            'city' => $city
        ]);
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
        $city = City::query()->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'postal_code' => '',
            'name' => [
                'required',
                'string',
                Rule::unique('cities')->ignore($id),
            ],
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'background_image' => 'required',
            'country_code' => 'required'
        ]);

        $data = $validator->validate();
        $city->name = $data['name'];
        $city->address = $data['address'];
        $city->zip_code = $data['postal_code'];
        $city->background_image = $data['background_image'];
        $city->country_code = $data['country_code'];
        $location = new Point($data['latitude'], $data['longitude']);
        $city->location = $location;
        $city->save();

        return back();
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
