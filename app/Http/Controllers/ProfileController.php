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

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'required',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $filename = time() . '.' . $request->photo->extension();

        $request->photo->storeAs('photos', $filename, 'public');

        $user->photo = $filename;
        $user->save();

        return response()->json([
            'message' => 'Foto berhasil upload',
            'user' => $user
        ]);
    }
}