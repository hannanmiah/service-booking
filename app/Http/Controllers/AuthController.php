<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // create token
        $token = $user->createToken('auth_token')->plainTextToken;
        // return token
        return response()->json(['token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // check credentials
        $user = User::where('email', $request->email)->first();
        // check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        // create token
        $token = $user->createToken('auth_token')->plainTextToken;
        // return token
        return response()->json(['token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request)
    {
        // delete token
        $request->user()->tokens()->delete();
        // return response
        return response()->noContent();
    }
}