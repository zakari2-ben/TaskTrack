<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\User;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getProfile($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if (!$user->profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($user->profile, 200);
    }

    public function getAllUsers()
    {

        $users = User::all(); // هادي تجيب جميع users
        return response()->json($users, 200);
    }

    public function updateProfile(UpdateProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $profile = $user->profile;
        $profile->update($request->validated());

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ], 200);
    }
}
