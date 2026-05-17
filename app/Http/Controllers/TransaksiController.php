<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function getRiwayat(Request $request)
    {
        $transaksi = Transaksi::where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($transaksi);
    }
}
