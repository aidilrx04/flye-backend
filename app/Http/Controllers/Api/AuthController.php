<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(StoreUserRequest $request)
    {
        $safe = $request->safe()->all();

        $user = User::create(array_merge($safe, ['password' => Hash::make($safe['password'])]));

        return $user;
    }

    public function signIn(Request $request)
    {
        $validated = $request->validate(['email' => 'required|string|email', 'password' => 'required|string']);

        $user = User::where("email", $validated['email'])->first();

        if (!$user) return response()->json([
            'message' => 'Invalid credentials'
        ], 400);

        // compare password
        if (Hash::check($validated['password'], $user->password) === false) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 400);
        }

        // create token
        $token = $user->createToken('web');


        // return token
        return [
            'token' => $token->plainTextToken,
        ];
    }

    public function verify(Request $request)
    {
        // grab user and send back since this route is protected with sanctum auth guard
        $user = $request->user();

        return $user;
    }
}
