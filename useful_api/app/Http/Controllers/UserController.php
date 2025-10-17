<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * save a new user to the database.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        
        
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            "id"=>$user->id,
            "name"=>$user->name,
            "email"=>$user->email,
            "created_at"=>$user->created_at
        ], 201);
    }

    /**
     * login user by generate new auth token.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ["required", "email"],
            'password' => ["required"]
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            "token"=>$token,
            'user_id'=>$user->id,
            'user' => $user
        ], 200);
    }

    public function wallet(Request $request){
        $user = $request->user();

        return response()->json([
            "user_id"=>$user->id,
            "balance"=>$user->balance
        ], 200);
    }

    public function index(){
        return response()->json(User::all(), 200);
    }
}