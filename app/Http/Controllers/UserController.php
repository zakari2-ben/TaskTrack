<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\User;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Json;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'password' => Hash::make($validateData['password'])
        ]);

        return response()->json([
            'message' => 'User registed successfully',
            'user' => $user
        ], 201);
    }



    public function login(Request $request)
    {
        // validation
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        // get user
        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        // create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);

    }



    public function logout() {

    }






    // get profiles
    public function getProfile($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if (!$user->profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
        return response()->json($user->profile, 200);
    }


    // get users
    public function getAllUsers()
    {

        $users = User::all(); // هادي تجيب جميع users
        return response()->json($users, 200);
    }

    // update profile
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

    // get tasks
    public function getUserTasks($id)
    {
        $tasks = User::with('tasks')->findOrFail($id)->tasks;

        if (!$tasks) {
            return response()->json(['message' => 'tasks not found'], 404);
        }
        return response()->json($tasks, 200);
    }
}
