<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout; // Pastikan model Checkout diimpor
use App\Models\Produk;   // Untuk memvalidasi produk

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'jumlah_pesanan' => 'required|integer|min:1',
        ]);

        // Ambil data produk berdasarkan ID
        $produk = Produk::findOrFail($validated['produk_id']);

        // Periksa apakah stok mencukupi
        if ($validated['jumlah_pesanan'] > $produk->stok) {
            return redirect()->back()->withErrors(['jumlah_pesanan' => 'Jumlah pesanan melebihi stok tersedia.']);
        }

        // Hitung total harga
        $validated['jumlah_harga'] = $produk->harga * $validated['jumlah_pesanan'];

        // Simpan data checkout ke database
        Checkout::create($validated);

        // Kurangi stok produk
        $produk->stok -= $validated['jumlah_pesanan'];
        $produk->save();

        // Redirect dengan pesan sukses
        return redirect()->route('produk.book')->with('success', 'Pesanan berhasil dibuat.');
    }
}
