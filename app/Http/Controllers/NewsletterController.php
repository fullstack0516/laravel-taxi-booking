<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:emails'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $email = $request->input('email');
        DB::table('emails')->insert([
            'email' => $email
        ]);
        // TODO Send Registration Mail to $email
        return back();
    }
}
