<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function show(Request $request)
    {
        $email = $request->user()->email;
        return Profile::where('email',$email)->first();

    }
}
