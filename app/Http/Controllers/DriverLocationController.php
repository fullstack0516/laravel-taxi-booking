<?php

namespace App\Http\Controllers;

use App\Models\DriverLocation;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class DriverLocationController extends Controller
{
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
        $user = auth()->user();
        if ($user->hasRole('driver')) {
            $location = new Point($request->input('latitude'), $request->input('longitude'));
            if ($user->currentLocation) {
                $user->currentLocation->address = $request->input('address');
                $user->currentLocation->location = $location;

                $user->currentLocation->save();
            } else {
                $currentLocation = new DriverLocation([
                    'address' => $request->input('address'),
                ]);
                $user->currentLocation()->save($currentLocation);
            }
            return response()->json([
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Failed',
            ]);
        }
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
