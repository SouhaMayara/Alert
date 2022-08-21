<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        $access_token = $user->createToken('access-token')->accessToken;
        return response()->json(['user' => $user,'token' => $access_token], 200);
    }

    public function login(Request $request)
    {
        $login_credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (auth()->attempt($login_credentials)) {
            $user = auth()->user();
            $access_token = $user->createToken('access-token')->accessToken;
            return response()->json(['user' => $user, 'token' => $access_token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    /** authenticated user details */
    public function currentUser()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['authenticated-user' => null], 400);
        }
        return response()->json(['authenticated-user' => $user], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }

        return response()->json('logged out', 200);
    }
}

