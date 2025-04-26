<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FullName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15|unique:users',
            'gender' => 'required|string',
            'age' => 'required|string',
            'NationalID' => 'required|string|min:6|max:8|unique:users',
            'usertype' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'FullName' => $request->FullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'age' => $request->age,
            'usertype' => $request->usertype,
            'NationalID' => $request->NationalID,
        ]);

        return response()->json(['message' => 'User registered successfully.'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'NationalID' => 'required|string|min:6|max:8',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('NationalID', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = User::where('NationalID', $request->NationalID)->first();

        $token = $user->createToken('my_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->noContent();
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user(),
        ], 200);
    }
}


