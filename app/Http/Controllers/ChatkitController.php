<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\User;
use Chatkit\Chatkit;
use Chatkit\Exceptions\ChatkitException;
use Chatkit\Exceptions\MissingArgumentException;
use Chatkit\Exceptions\TypeMismatchException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatkitController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $chatkit = new Chatkit([
                'instance_locator' => 'v1:us1:13f00f52-4361-4ae0-a27f-be9b03275ac8',
                'key' => 'f4caf568-2587-4fa8-bcee-a19d5d3097e5:dwENLKpze/rw+Apa6T/56TiM6cdW2E9vVvSkhNlwrzE=',
            ]);
            $avatarUrl = config('app.url').'/images/avatar.png';
            if (auth()->user()->profile->avatar) {
                $avatarUrl = auth()->user()->profile->avatar;
            }
            $chatkit->createUser([
                'id' => auth()->user()->name,
                'name' => auth()->user()->first_name.' '.auth()->user()->last_name,
                'avatar_url' => $avatarUrl,
            ]);
            return response()->json([
                'message' => 'Success',
            ]);
        } catch (MissingArgumentException $e) {
            return response()->json([
                'message' => 'Error',
            ], 419);
        } catch (TypeMismatchException $e) {
            return response()->json([
                'message' => 'Error',
            ], 419);
        }
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error','error' => $validator->errors(),
            ]);
        }
        $chatkit = null;
        try {
            $chatkit = new Chatkit([
                'instance_locator' => 'v1:us1:13f00f52-4361-4ae0-a27f-be9b03275ac8',
                'key' => 'f4caf568-2587-4fa8-bcee-a19d5d3097e5:dwENLKpze/rw+Apa6T/56TiM6cdW2E9vVvSkhNlwrzE=',
            ]);
        } catch (MissingArgumentException $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error','error' => $e->getMessage(),
            ]);
        } catch (ChatkitException $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error','error' => $e->getMessage(),
            ]);
        }

        try {
            $sender = $chatkit->getUser(['id' => auth()->user()->name]);
        } catch (ChatkitException $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error','error' => $e->getMessage(),
            ]);
        } catch (MissingArgumentException $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error','error' => $e->getMessage(),
            ]);
        }
        try {
            $driver = User::query()->findOrFail($request->input('driver_id'));
            $receiver = $chatkit->getUser(['id' => $driver->name]);
        } catch (ChatkitException $e) {
            $receiver = $chatkit->createUser([
                'id' => $driver->name,
                'name' => $driver->first_name.' '.$driver->last_name,
                'avatar_url' => $driver->profile->avatar,
            ]);
        } catch (MissingArgumentException $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error','error' => $e->getMessage(),
            ]);
        }
        $chatRoomRecord = ChatRoom::query()->where('customer_name', auth()->user()->name)->where('driver_name', $driver->name)->first();
        if ($chatRoomRecord == null) {
            try {
                $chatRoom = $chatkit->createRoom([
                    'creator_id' => $sender['body']['id'],
                    'name' => str_random(),
                    'user_ids' => [$receiver['body']['id']],
                    'private' => true,
                ]);
                $chatRoomRecord = ChatRoom::query()->create([
                    'room_id' => $chatRoom['body']['id'],
                    'customer_name' => $chatRoom['body']['created_by_id'],
                    'driver_name' => $receiver['body']['id'],
                    'name' => $chatRoom['body']['name'],
                    'private_flag' => $chatRoom['body']['private'],
                ]);
            } catch (MissingArgumentException $e) {
                return response()->json([
                    'status' => 'error','error' => $e->getMessage(),
                ]);
            }
        } else {
            try {
                $chatRoom = $chatkit->getRoom(['id' => $chatRoomRecord->room_id]);
            } catch (MissingArgumentException $e) {
                return response()->json([
                    'status' => 'error','error' => $e->getMessage(),
                ]);
            }
        }

        $result = $chatkit->sendSimpleMessage([
            'sender_id' => auth()->user()->name,
            'room_id' => $chatRoom['body']['id'],
            'text' => $request->input('message'),
        ]);
        return response()->json(
            $result['body'],
            $result['status'],
            $result['headers']
        );
    }

    public function showInbox() {
        return view('admin.messages');
    }

}
