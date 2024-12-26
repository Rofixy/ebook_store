<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For getting the logged-in user

class PesananController extends Controller
{

    public function checkout($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.checkout', compact('produk'));
    }

    public function __construct()
    {
        $this->middleware('auth'); // Ensure that the user is logged in
    }

    // Display the list of orders with pagination
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', '');

        // Get the list of orders with optional search filter
        $pesanans = Pesanan::where('produk', 'like', '%' . $search . '%')
            ->paginate($perPage);

        return view('admin.datapesanan.index', compact('pesanans'));
    }

    // Display the form for creating a new order
    public function create()
    {
        $produks = Produk::all(); // Get all products to display in the dropdown
        return view('admin.datapesanan.create', compact('produks'));
    }

    // Store the newly created order
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'berat' => 'required|integer',
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_pesanan' => 'required|date',
            'jumlah_pesanan' => 'required|integer',
            'jumlah_harga' => 'required|numeric',
        ]);

        // Get the logged-in user's data
        $user = Auth::user();

        Pesanan::create([
            'produk_id' => $request->produk_id,
            'produk' => $request->produk,
            'harga' => $request->harga,
            'berat' => $request->berat,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'jumlah_harga' => $request->jumlah_harga,
            'pemesan' => $user->name, // Use the name of the logged-in user
        ]);

        return redirect()->route('produk.checkout', ['id' => $request->produk_id])->with('success', 'Pesanan berhasil ditambahkan.');
    }

    // Delete an order
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('datapesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
