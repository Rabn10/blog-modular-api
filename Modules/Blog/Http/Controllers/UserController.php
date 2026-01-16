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
}