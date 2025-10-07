<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}
    
    public function register(RegistrationRequest $request)
    {

        return $this->authService->created($request);

    }
    
    public function login(LoginRequest $request)
    {
        return $this->authService->loginProcess($request);

    }

}
