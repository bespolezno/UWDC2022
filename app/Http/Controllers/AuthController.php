<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function user()
    {
        $user = \auth()->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return response()->json(['token' => Auth::user()->generateToken()]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::user()->clearToken();

        return response()->noContent();
    }
}
