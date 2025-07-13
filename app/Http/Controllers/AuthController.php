<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login method to authenticate users
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    //penambahan fungsi untuk mekanisme logout
    public function logout(Request $request) {
        //menghapus token yang sedang dipakai untuk request saat ini
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=> 'Berhasil logout']);
    }

    public function register(Request $request)
    {
        // 2. Validasi input dari frontend
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 3. Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // 4. Kirim respons sukses
        return response()->json([
            'message' => 'Registrasi berhasil!',
            'user' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}