<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\WalletController;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'notelp' => 'required|string',
            'password' => 'required|min:5',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'password' => bcrypt($request->password)
        ]);
        $walletController = new WalletController();
        $walletController->createWallet($user->id);
        return response()->json([
            'message' => 'Register berhasil',
            'user' => $user
        ]);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user
        ]);
    }
}
