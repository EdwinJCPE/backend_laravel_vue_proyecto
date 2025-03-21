<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'User created successfully'
        ], 201);
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('Token Auth')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 200);
    }

    public function profile(Request $request) {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }
}
