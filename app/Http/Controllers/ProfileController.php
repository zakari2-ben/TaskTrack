<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request){
        $profile = Profile::create($request->validate());
        return response()->json(
            [
                'message' => 'profile created successfully',
                'profile' => $profile,
            ],201
        );
    }
}
