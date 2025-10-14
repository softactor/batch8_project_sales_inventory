<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserManageController extends Controller
{
    
    public function createUser(UserCreateRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        //     'phone' => 'required',
        //     'roles' => 'required|array',
        //     'roles.*' => 'exists:roles,id'
        // ]);

        // if($validator->fails())
        // {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors(),
        //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
        ]);

        $user->roles()->sync($request->roles);


        return response()->json([
                'status' => 'success',
                'message' => 'User has created successfully',
                'data' => [
                    'users' => $user->load('roles.permissions')
                ],
            ], Response::HTTP_OK);
    }

}
