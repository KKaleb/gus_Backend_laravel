<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateToken(Request $request)
    {
        return new UserResource($request->user());
    }

    public function updateInformation(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'gender' => 'required|string',
            'bio' => 'required|string',
            'dob' => 'required|string'
        ]);

        try{
            $user = new UserResource($request->user());
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->save();
        }catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['status' => true, 'message' => 'User profile updated', 'data' => $user], 200);
    }
}
