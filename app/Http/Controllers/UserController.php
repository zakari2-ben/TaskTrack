<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function getProfile($id) {

    //     $profile = User::findOrFail($id)->profile;
    //     return response()->json($profile, 200);
    // }

    public function getProfile($id)
    {
        $user = User::findOrFail($id);

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
}
