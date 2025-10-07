<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Response;

class AuthService
{
    
    public function created($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);


        $token = auth()->login($user);


        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data'   => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }


    public function loginProcess($request)
    {
        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt($credentials))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Credentials was invalid',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User Login Successfull',
            'data'   => [
                'user' => auth()->user(),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
