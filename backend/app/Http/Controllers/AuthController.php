<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The provided credentials are incorrect.', 'success' => false], 401);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Please verify your email address first.', 'success' => false], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.', 'success' => false], 401);
        }

        try {
            $token = $user->createToken('haj')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'message' => 'Log In successfully.',
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'is_admin' => $user->is_admin,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'success' => false,
            ], 500);
        }
    }



    public function userProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user,
            'isAdmin' => $user->is_admin,
        ]);
    }



    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. No token provided or invalid token.',
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ], 200);
    }

  
}
