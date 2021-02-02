<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use Chatkit\Chatkit;
use Chatkit\Exceptions\MissingArgumentException;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;

class SettingsController extends Controller
{

    /**
     * SettingsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('settings.show-info');
        }
        return view('admin.settings-role');
    }

    public function storeRole(Request $request)
    {
        $user = auth()->user();
        $role = $request->input('role');
        $user->roles()->detach();
        $role = Role::query()->where('slug', $role)->first();
        $user->roles()->attach($role);
        return redirect()->route('settings.show-info');
    }

    public function showInfo()
    {
        $user = auth()->user();
        return view('admin.settings-info')->with([
            'user' => $user,
        ]);
    }

    public function storeInfo(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
//            'name' => [
//                Rule::unique('users')->ignore($user->id),
//                'required',
//                'min:5',
//                'string'
//            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'avatar' => 'required',
        ]);
        $data = $validator->validate();

        try {
            $chatkit = new Chatkit([
                'instance_locator' => 'v1:us1:13f00f52-4361-4ae0-a27f-be9b03275ac8',
                'key' => 'f4caf568-2587-4fa8-bcee-a19d5d3097e5:dwENLKpze/rw+Apa6T/56TiM6cdW2E9vVvSkhNlwrzE=',
            ]);
            $chatkit->updateUser([
                'id' => auth()->user()->name,
                'name' => $data['first_name'].' '.$data['last_name'],
                'avatar_url' => $data['avatar'],
            ]);

        } catch (MissingArgumentException $e) {
        }
//        $user->name = $data['name'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->save();

        $user->profile->avatar = $data['avatar'];
        $user->profile->save();

        return redirect()->route('settings.show-address');
    }

    public function showAddress()
    {
        $user = auth()->user();
        $cities = City::all();
        $user_city = null;
        foreach ($user->cities as $city) {
            $user_city = $city;
        }
        if (!$user->profile->location) {
            $user->profile->location = new Point(0, 0);
            $user->profile->save();
        }
        return view('admin.settings-address')->with([
            'user' => $user,
            'cities' => $cities,
            'user_city' => $user_city
        ]);
    }

    public function storeAddress(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required'
        ]);
        $data = $validator->validate();
        $user->profile->address = $data['address'];
        $user->profile->location = new Point($data['latitude'], $data['longitude']);
        $user->profile->save();

        $user->cities()->detach();
        $user->cities()->attach($data['city']);
        if ($user->hasRole('driver')) {
            return redirect()->route('settings.show-license');
        }
        $now = new \DateTime();
        $user->settings_completed_at = $now;
        $user->updated_ip_address = $request->getClientIp();
        $user->save();

        // TODO: Notify CustomerSettingsUpdated

        return redirect()->route('dashboard')->with('success', 'Settings Updated');
    }

    public function showLicense()
    {
        $user = auth()->user();
        return view('admin.settings-license')->with([
            'user' => $user,
        ]);
    }

    public function storeLicense(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'license_number' => 'required',
            'car_name' => 'required',
            'year_of_model' => 'required',
            'license_image' => 'required',
            'car_number_plate' => 'required',
            'bio' => 'required|min:30',
        ]);
        $data = $validator->validate();
        if ($user->car) {
            $user->car->license_number = $data['license_number'];
            $user->car->name = $data['car_name'];
            $user->car->year_of_model = $data['year_of_model'];
            $user->car->license_image = $data['license_image'];
            $user->car->car_number_plate = $data['car_number_plate'];
            $user->car->save();
        } else {
            $car = new Car([
                'license_number' => $data['license_number'],
                'name' => $data['car_name'],
                'year_of_model' => $data['year_of_model'],
                'license_image' => $data['license_image'],
                'car_number_plate' => $data['car_number_plate'],
            ]);
            $user->car()->save($car);
        }
        $user->updated_ip_address = $request->getClientIp();
        $now = new \DateTime();
        $user->settings_completed_at = $now;

        $user->profile->bio = $data['bio'];
        $user->profile->save();

        $user->save();

        // TODO: Notify DriverSettingsUpdated

        return redirect()->route('dashboard')->with('success', 'Settings Updated');
    }

    public function showPasswordForm()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
//            'old_password' => [
//                'required',
//                function ($attribute, $value, $fail) {
//                    if (!Hash::check($value, auth()->user()->getAuthPassword())) {
//                        $fail('Old password didn\'t match.');
//                    }
//                }
//            ],
            'password' => 'required|min:8|confirmed',
        ]);
        $data = $validator->validate();
        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'Success');
    }
}
