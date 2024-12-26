<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{

    public function cekongkos()
    {
        // Lakukan logika Anda di sini dan return tampilan
        return view('user.cekongkos'); // pastikan nama view sesuai
    }
    public function cekongkir()
    {
        return view('admin.cekongkir');
    }

    public function ongkirsimpan(Request $request)
    {
        // Ambil data dari request
        $kota_asal = $request->kota_asal;
        $kota_tujuan = $request->kota_tujuan;
        $berat = $request->berat;
        $kurir = $request->kurir;

        // Inisialisasi cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $kota_asal . "&destination=" . $kota_tujuan . "&weight=" . $berat . "&courier=" . $kurir,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: c336f27d44ecf96bd8d85101cf45f42e"
            ),
        ));

        // Eksekusi cURL
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            // Jika ada error, tampilkan pesan error
            return back()->withErrors(['message' => "CURL Error #: " . $err]);
        } else {
            // Decode hasil respons dari API
            $ongkir = json_decode($response);
        }

        // Inisialisasi variabel untuk data hasil API
        $paket = null;
        $ongkos = null;

        // Ambil data dari respons API
        if (isset($ongkir->rajaongkir->results[0]->costs[0])) {
            $paket = $ongkir->rajaongkir->results[0]->costs[0]->service;
            $ongkos = $ongkir->rajaongkir->results[0]->costs[0]->cost[0]->value;
        }

        // Kembalikan ke view cekongkir dengan data yang diperoleh
        return view('admin.cekongkir', compact('ongkir', 'paket', 'ongkos', 'kota_asal', 'kota_tujuan', 'berat'));
    }
}