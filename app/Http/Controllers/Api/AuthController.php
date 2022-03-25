<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request, CreateNewUser $newUser)
    {
        if ($user = $newUser->create($request->all())) {
            // login
            Auth::attempt($request->only('email', 'password'));
            // create token
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'userData' => $user,
                'accessToken' => $token
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'errors' => ['email' => 'These credentials do not match our records.']
            ], 422);
        }

        $user = $request->user();
        // create token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'userData' => $user,
            'accessToken' => $token,
            'refreshToken' => $token,
        ], 201);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $cookie = cookie()->forget('token');

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
