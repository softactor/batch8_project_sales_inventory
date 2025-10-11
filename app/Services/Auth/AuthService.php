<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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


    public function resetPasswordLink($request) {
        $email = $request->email;

        $user =  User::where('email', $email)->first();

        if(!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ],Response::HTTP_NOT_FOUND);
        }

        // generate random token
        $token = Str::random(60);

        // insert the token into password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $emailData = [
            'user' => $user,
            'token' => $token
        ];

        Mail::send('emails.password_reset', $emailData, function ($message) use($user) {
            $message->to($user->email, $user->name);
            $message->subject('Password Reset Email');
        });


        return response()->json([
                'status' => 'success',
                'message' => 'Password reset link sent to your email.'
            ],Response::HTTP_OK);
    }

    public function resetPassword($request){
        $email = $request->email;
        $password = $request->password;
        $token = $request->token; 

        // check password_reset_tokens data with incoming $token
        $tokenRecord = DB::table('password_reset_tokens')->where('token', $token)->first();

        if(!$tokenRecord || ($token != $tokenRecord->token)){
            return response()->json([
                'status' => 'error',
                'message' => 'Token was invalid'
            ],Response::HTTP_NOT_FOUND);
        }

        //get user data with $email
        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ],Response::HTTP_NOT_FOUND);
        }

        //Check token validation
        if(Carbon::parse($tokenRecord->created_at)->addHour()->isPast()){
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return response()->json([
                'status' => 'error',
                'message' => 'Token/Time expired!'
            ],Response::HTTP_NOT_FOUND);
        }

        //Update Password
        $user->update(['password' => $password]);

        //Delete used token
        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully'
            ],Response::HTTP_OK);
    }
}
