<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function detail($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.detail', compact('produk'));
    }

    public function show()
    {
        $produks = Produk::all(); // Ambil semua data produk dari database
        return response()->json($produks, 200); // Kembalikan data dalam bentuk JSON
    }

    // API untuk menampilkan semua produk
    public function apiIndex()
    {
        $produks = Produk::all(); // Mengambil semua produk dari database
        return response()->json($produks, 200); // Mengembalikan data produk dalam format JSON
    }


    // Add this method to your ProdukController
    public function showBook()
    {
        // Retrieve all products or paginate them as needed
        $produks = Produk::all(); // or you can use pagination if preferred

        // Return the view with the products
        return view('produk.book', compact('produks'));
    }

    // API untuk menambahkan produk baru
// ProdukController.php
public function apiStore(Request $request)
{
    // Validasi input dari request
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nama' => 'required|string|max:255',
        'berat' => 'required|integer',
        'stok' => 'required|integer',
        'harga' => 'required|numeric',
        'alamat' => 'required|string',
        'detail' => 'nullable|string',
    ]);

    // Menyimpan data produk
    $requestData = $request->all();

    // Menyimpan file gambar jika ada
    if ($request->hasFile('foto')) {
        // Menghasilkan nama file yang unik
        $fileName = time() . '.' . $request->foto->getClientOriginalExtension();

        // Menyimpan file ke folder 'images' dan menjadikannya akses publik
        $path = $request->file('foto')->storeAs('images', $fileName, 'public');

        // Memasukkan path gambar ke data request
        $requestData['foto'] = '/storage/' . $path;
    }

    // Menyimpan data produk baru ke database
    $produk = Produk::create($requestData);

    // Mengembalikan respon JSON yang menandakan bahwa produk berhasil disimpan
    return response()->json([
        'message' => 'Produk berhasil ditambahkan!',
        'produk' => $produk
    ], 201); // Kode status 201 untuk sukses membuat resource
}


    // API untuk memperbarui produk
    public function apiUpdate(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Validasi data request
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'berat' => 'required|integer',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'alamat' => 'required|string',
            'detail' => 'nullable|string',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            Storage::delete('public/' . $produk->foto);
            $fileName = time() . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('images', $fileName, 'public');
            $produk->foto = '/storage/' . $path;
        }

        // Update data produk
        $produk->update($request->all());

        // Mengembalikan response sukses
        return response()->json(['message' => 'Produk berhasil diperbarui', 'produk' => $produk], 200);
    }

    // API untuk menghapus produk
    public function apiDestroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus foto yang terkait dengan produk
        Storage::delete('public/' . $produk->foto);
        $produk->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }

    // Menampilkan daftar produk dengan pagination
    public function index(Request $request)
    {
        // Get the number of items per page, defaulting to 10 if not set
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', '');

        // Retrieve the paginated products based on the search term
        $produks = Produk::where('nama', 'like', '%' . $search . '%')
            ->paginate($perPage); // Use paginate() for pagination

        return view('admin.dataproduk.index', compact('produks'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('admin.dataproduk.create');
    }

    // Menyimpan data produk baru
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'berat' => 'required|integer',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'alamat' => 'required|string',
            'detail' => 'nullable|string',  // Adding validation for detail field
        ]);

        // Get all request data
        $requestData = $request->all();

        // Handle the file upload
        if ($request->hasFile('foto')) {
            // Generate a unique filename for the image
            $fileName = time() . $request->file('foto')->getClientOriginalName();
            
            // Store the image file in the 'images' directory and make it accessible publicly
            $path = $request->file('foto')->storeAs('images', $fileName, 'public');

            // Update the request data with the image path
            $requestData['foto'] = '/storage/' . $path;
        }

        // Create the new product record
        Produk::create($requestData);

        // Redirect back to the products index with a success message
        return redirect('dataproduk')->with('flash_message', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.dataproduk.edit', compact('produk'));
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'berat' => 'required|integer',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'alamat' => 'required|string',
            'detail' => 'nullable|string', // Validating the detail field
        ]);

        // Jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            Storage::delete('public/' . $produk->foto);
            // Simpan foto baru
            $fileName = time() . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('images', $fileName, 'public');
            $produk->foto = '/storage/' . $path;
        }

        // Update the product data
        $produk->update([
            'nama' => $request->nama,
            'berat' => $request->berat,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'alamat' => $request->alamat,
            'detail' => $request->detail,  // Updating the detail field
        ]);

        return redirect()->route('dataproduk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        Storage::delete('public/' . $produk->foto);
        $produk->delete();

        return redirect()->route('dataproduk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
