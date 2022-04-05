<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function register(Request $request, CreateNewUser $newUser)
    {
        // register user
        if ($user = $newUser->create($request->all())) {
            // login user
            if (Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['auth' => new AuthUserResource(auth()->user())], 201);
            }
        }
        return response()->json(['error' => 'sommeting wrong']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            return response()->json(['auth' => new AuthUserResource(auth()->user())]);
        }
        return response()->json([
            "errors" => ['email' => 'The provided credentials do not match our records.']
        ], 422);
    }
    public function logout(Request $request)
    {
        collect(Cookie::get())->map(function ($cookie, $key) {
            Cookie::forget($key);
        });
        if ($request->session()->invalidate()) {
            return response(['message' => 'success'], 200);
        }
        return response(['message' => 'error'], 401);
    }
}
