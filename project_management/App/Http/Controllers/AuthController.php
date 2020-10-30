<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|max:15'
        ]);
        if ($request->email === 'admin@admin.com' && $request->name === 'Admin') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'ADMIN',
                'phone_number' => ' '

            ]);
            return response()->json($user);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'MEMBER',
                'phone_number' => ' '

            ]);
            return response()->json($user);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken($user->email . '-' . now());

            return response()->json([
                'token' => $token->accessToken, 'name' => $user->name, 'email' => $user->email, 'avatar' => $user->avatar, 'userId' => $user->id, 'role' => $user->role
            ]);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }
    }
}
