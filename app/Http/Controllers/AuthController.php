<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController
{

    public function create(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ] );

        if ($validator->fails()) { 
            $response = $validator->errors();
            return response()->json(['error' =>$response], 400);   
        }   

        $user = User::create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'success' => [
                'name' => $user->name,
                'last' => $user->last_name,
                'email' => $user->email,
                'token' =>$token
            ]
        ], 201);

    }


    public function login(Request $request)
    {
    // Valider input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        ]);

        // Forsøg at finde brugeren baseret på email
        $user = User::where('email', $request->email)->first();

        // Tjek om bruger findes, og om password matcher
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Opret et nyt token til brugeren
        $token = $user->createToken('API Token')->plainTextToken;

        // Returner tokenet som en JSON response
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout successful',
            ]);
        } catch (Throwable $e ){
                return response()->json([
                'message' => "Didn't Logout correctly",
                'error' => $e
            ],400);
        }


    }


    public function logout_all(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout successful',
            ]);
        } catch (Throwable $e ){
                return response()->json([
                'message' => "Didn't Logout correctly",
                'error' => $e
            ],400);
        }
    }
}
