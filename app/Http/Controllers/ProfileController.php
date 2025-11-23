<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show ($id){
        $profile = Profile::where('user_id',$id)->firstOrFail();
        return response()->json($profile, 200);
    }

    public function store(StoreProfileRequest $request){
        
        $profile = Profile::create($request->validated());
        return response()->json(
            [
                'message' => 'profile created successfully',
                'profile' => $profile,
            ],201
        );
    }
    
}
