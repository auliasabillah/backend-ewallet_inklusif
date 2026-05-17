<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'notelp' => 'required',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->notelp = $request->notelp;
        $user->save();
        return response()->json([
            'message' => 'Profil berhasil diupdate',
            'user' => $user
        ]);
    }
}
