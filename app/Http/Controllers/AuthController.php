<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nim' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp
        ]);

        return response()->json(['message' => 'Registration successful'], 201);
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Data tidak valid'],
                ]);
            }
            $token = $user->createToken('chairish')->plainTextToken;
            return response()->json(['message' => 'Login berhasil', 'token' => $token,'success' => true],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Login gagal', 'success' => false]);
        }

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Anda berhasil logout']);
    }

    public function me() {
        return response()->json(Auth::user());
    }
}