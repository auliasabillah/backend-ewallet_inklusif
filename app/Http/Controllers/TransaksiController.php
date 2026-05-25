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

    public function getPengeluaranHariIni(Request $request)
    {
        $query = Transaksi::where('user_id', $request->user_id)
            ->where('jenis', 'pengeluaran');

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->tanggal) {
            $query->whereDay('created_at', $request->tanggal);
        }

        $transaksi = $query->get();

        $grouped = [];

        foreach ($transaksi as $tx) {
            $metode = $tx->deskripsi;

            if (!isset($grouped[$metode])) {
                $grouped[$metode] = 0;
            }

            $grouped[$metode] += $tx->nominal;
        }

        return response()->json($grouped);
    }
}