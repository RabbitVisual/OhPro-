<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::post('/login', function (Request ) {
     = ->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
});

Route::middleware('auth:sanctum')->get('/user', function (Request ) {
    return $request->user();
});
