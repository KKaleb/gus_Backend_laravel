<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        return 'go back dude';
//        $validated =$this->validate($request, [
//            'pin' => 'required|numeric|digits:4',
//            'phone_number' => 'required|numeric|digits:11',
//        ]);
//
//        try{
//           $checkPin = User::where('pin', $validated['pin'])->first();
//           if(is_null($checkPin)){
//               return response()->json(['error' => true, 'message' => 'pin is incorrect'], 500);
//           }
//           $checkPhone = User::where('phone_number', $validated['phone_number'])->first();
//           if(is_null($checkPhone)){
//               return response()->json(['error' => true, 'message' => 'phone number is incorrect'], 500);
//           }
//           $user = User::where('pin', $validated['pin'])->where('phone_number', $validated['phone_number'])->first();
//
//        }catch (\Exception $exception)
//        {
//            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
//        }
//        $data['user'] =  $user;
//        $data['token'] =  $user->createToken('GUS')->accessToken;
//        return response()->json(['error' => false, 'message' => 'login successful', 'data' => $data], 500);
    }

    public function adminLogin(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try{
            $user = User::where('email', $validated['email'])->where('is_admin', true)->first();
            if(is_null($user)){
                return response()->json(['error' => true, 'message' => 'Credentials not correct'], 400);
            }
            if(!Hash::check($validated['password'], $user->password)){
                return response()->json(['error' => true, 'message' => 'Credentials not correct'], 400);
            }
        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        $data['user'] =  $user;
        $data['token'] =  $user->createToken('GUS')->accessToken;
        return response()->json(['error' => false, 'message' => 'admin login successful', 'data' => $data], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
    }

}
