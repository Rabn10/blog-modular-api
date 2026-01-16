<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\user;

class UserController extends Controller
{
    public function UserRegister(Request $request)
    {
       try {
           $user = user::create([
               'name' => $request->name,
               'email' => $request->email,
               'password' => bcrypt($request->password),
           ]);

           return response()->json([
               'message' => 'User registered successfully'
           ], 201);
       } catch (\Exception $e) {
           return response()->json([
               'message' => 'Failed to create post',
               'error' => $e->getMessage()
           ], 500);
       }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = $request->user();
            
            $tokenResult = $user->createToken($user->id);

             return response()->json([
                'status' => 1,
                'message' => 'Login successful',
                'data' => $user,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer'
                //'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}