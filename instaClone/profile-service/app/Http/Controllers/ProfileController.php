<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // GET /api/profiles/{username}
    public function show(string $username)
    {
        $profile = Profile::where('username', $username)->first();
        if (! $profile) {
            return response()->json([
                'ok' => false,
                'error' => 'Profile not found',
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'profile' => $profile,
        ]);
    }

    // POST /api/profiles (temporary: X-User-Id header to identify user)
    public function upsert(Request $request)
    {
        $externalUserId = $request->header('X-User-Id');
        if (! $externalUserId) {
            return response()->json([
                'ok' => false,
                'error' => 'Unauthorized: missing X-User-Id',
            ], 401);
        }

        $data = $request->validate([
            'username' => [
                'required', 'string', 'alpha_dash', 'max:50',
                Rule::unique('profiles', 'username')->ignore(
                    Profile::where('external_user_id', $externalUserId)->value('id')
                ),
            ],
            'display_name' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $profile = Profile::firstOrNew(['external_user_id' => $externalUserId]);
        $profile->fill($data);
        $profile->save();

        return response()->json([
            'ok' => true,
            'profile' => $profile,
        ], 201);
    }
}
