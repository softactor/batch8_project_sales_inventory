<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    
    public function forgetPassword(Request $request) {
        
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


    public function passwordReset(Request $request)
    {
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
