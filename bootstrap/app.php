<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->renderable(function(AuthenticationException $e, $request){
            if($request->is('api/*' && !Auth::check())){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorize Action',
                ],200);
            }
        });
        
        $exceptions->renderable(function(JWTException $e, $request){
            if($request->is('api/*' && !Auth::check())){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorize Action',
                ],200);
            }
        });
        $exceptions->renderable(function(TokenExpiredException $e, $request){
            if($request->is('api/*' && !Auth::check())){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorize Action',
                ],200);
            }
        });

        $exceptions->renderable(function(UserNotDefinedException $e, $request){
            if($request->is('api/*' && !Auth::check())){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorize Action',
                ],200);
            }
        });
        
        $exceptions->renderable(function(TokenInvalidException $e, $request){
            if($request->is('api/*' && !Auth::check())){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorize Action',
                ],200);
            }
        });

        
    })->create();
