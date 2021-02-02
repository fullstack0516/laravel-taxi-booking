<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Notifications\DriverApproved;
use App\Notifications\DriverUnapproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::all();
        if (request()->query('role')) {
            if (request()->query('role') == 'trashed') {
                $users = User::onlyTrashed()->paginate(15);
            } else {
                $users = User::query()->whereHas('roles', function (Builder $query) {
                    $query->where('name', request()->query('role'));
                })->paginate(15);
            }
        } else {
            $users = User::query()->paginate(15);
        }
        return view('admin.users')->with([
            'users' => $users,
            'roles' => $roles,
            'query_role' => request()->query('role'),
        ]);
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
        //
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

    public function edit($id)
    {
        $user = User::query()->findOrFail($id);
        if ($user->id == auth()->user()->getAuthIdentifier()) {
            return redirect()->route('settings');
        }
        $user_city = null;
        foreach ($user->cities as $city) {
            $user_city = $city;
        }
        $roles = Role::all();
        $currentRoles = $user->roles;
        $cities = City::all();
        return view('admin.edit-user')->with([
            'user' => $user,
            'roles' => $roles,
            'cities' => $cities,
            'user_city' => $user_city,
            'currentRoles' => $currentRoles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);
        $now = new \DateTime();
        if ($user->approved_at) {
            $user->approved_at = null;
            $user->notify(new DriverUnapproved());
        } else {
            $user->approved_at = $now;
            $user->notify(new DriverApproved());
        }
        $user->save();
        return back()->with([
            'message' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return back()->with([
            'success' => 'Success',
        ]);
    }
}
