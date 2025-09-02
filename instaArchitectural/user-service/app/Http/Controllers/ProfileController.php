<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, $email)
    {
        $profile = \App\Models\Profile::where('email', $email)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($profile);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|string|max:255',
        ]);

        $profile = \App\Models\Profile::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $profile) {
            $profile = new \App\Models\Profile();
            $profile->user_id = $request->user()->id;
        }

        $profile->fill($validated);
        $profile->save();

        return response()->json($profile);
    }
}


