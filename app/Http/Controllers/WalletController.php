<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function getSaldo(Request $request)
    {
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if (!$wallet) {
            return response()->json(['saldo' => 0]);
        }
        return response()->json(['saldo' => $wallet->saldo]);
    }
    public function createWallet(int $user_id)
    {
        Wallet::create([
            'user_id' => $user_id,
            'saldo' => 0
        ]);
    }
    public function topUp(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nominal' => 'required|numeric|min:1',
        ]);
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if (!$wallet) {
            return response()->json(['message' => 'Wallet tidak ditemukan'], 404);
        }
        $wallet->saldo += $request->nominal;
        $wallet->save();
        $transaksi=Transaksi::create([
            'user_id' => $request->user_id,
            'tipe' => 'pemasukan',
            'kategori' => 'Top Up',
            'nominal' => $request->nominal,
            'deskripsi' => 'Top Up Saldo',
        ]);
        return response()->json([
            'pesan' => 'Top up berhasil',
            'saldo' => $wallet->saldo,
            'id_transaksi' => $transaksi->id,
        ]);
    }
    public function transfer(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nominal' => 'required|numeric|min:1',
            'nama_penerima' => 'required',
            'bank' => 'required',
            'rekening' => 'required',
            'catatan' => 'nullable',
        ]);
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if (!$wallet) {
            return response()->json(['message' => 'Wallet tidak ditemukan'], 404);
        }
        if ($wallet->saldo < $request->nominal) {
            return response()->json(['message' => 'Saldo tidak cukup'], 400);
        }
        $wallet->saldo -= $request->nominal;
        $wallet->save();
        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'tipe' => 'pengeluaran',
            'kategori' => 'Transfer',
            'nominal' => $request->nominal,
            'deskripsi' => 'Transfer ke ' . $request->nama_penerima . ' - ' . $request->bank,
        ]);
        return response()->json([
            'message' => 'Transfer berhasil',
            'saldo' => $wallet->saldo,
            'id_transaksi' => $transaksi->id,
        ]);
    }
    public function payment(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nominal' => 'required|numeric|min:1',
            'metode' => 'required',
        ]);
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if (!$wallet) {
            return response()->json(['message' => 'Wallet tidak ditemukan'], 404);
        }
        if ($wallet->saldo < $request->nominal) {
            return response()->json(['message' => 'Saldo tidak cukup'], 400);
        }
        $wallet->saldo -= $request->nominal;
        $wallet->save();
        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'tipe' => 'pengeluaran',
            'kategori' => 'Payment',
            'nominal' => $request->nominal,
            'deskripsi' => 'Pembayaran via ' . $request->metode,
        ]);
        return response()->json([
            'message' => 'Pembayaran berhasil',
            'saldo' => $wallet->saldo,
            'id_transaksi' => $transaksi->id,
        ]);
    }
}
