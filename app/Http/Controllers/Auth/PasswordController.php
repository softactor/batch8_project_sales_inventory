<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    public function __construct(private AuthService $authService){}
    
    public function forgetPassword(ForgetPasswordRequest $request) {
        
        return $this->authService->resetPasswordLink($request);

    }


    public function passwordReset(ResetPasswordRequest $request)
    {
        return $this->authService->resetPassword($request);

    }

}
