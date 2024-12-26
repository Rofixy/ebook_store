@extends('layouts.app')
@section('content')
<?php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 120,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key: c336f27d44ecf96bd8d85101cf45f42e"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "CURL Error #: " . $err;
} else {
    $data = json_decode($response);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cek Ongkos Kirim') }}</div>
                <div class="card-body">
                    <form action="{{ url('/ongkir-simpan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_debug_route" value="cekongkir">
                        <div class="mb-3">
                            <label for="kota_asal" class="form-label">Kota Asal:</label>
                            <select name="kota_asal" class="form-control">
                                <option>- Pilih Kota -</option>
                                <?php
                                if (isset($data->rajaongkir->results)) {
                                    foreach ($data->rajaongkir->results as $kota) {
                                        echo "<option value=\"$kota->city_id\">$kota->city_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kota_tujuan" class="form-label">Kota Tujuan:</label>
                            <select name="kota_tujuan" class="form-control">
                                <option>- Pilih Kota -</option>
                                <?php
                                if (isset($data->rajaongkir->results)) {
                                    foreach ($data->rajaongkir->results as $kota) {
                                        echo "<option value=\"$kota->city_id\">$kota->city_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="berat" class="form-label">Berat:</label>
                            <input type="number" placeholder="Satuan Gram" name="berat" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="kurir" class="form-label">Kurir:</label>
                            <select name="kurir" class="form-control">
                                <option>- Pilih Kurir -</option>
                                <option>jne</option>
                                <option>pos</option>
                                <option>tiki</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </form>
                @if(empty($ongkir->rajaongkir->results))

                @else
                <?php
                foreach ($ongkir->rajaongkir->results[0]->costs as $ongkos) {
                    $paket = $ongkos->service;
                    $ongkos = $ongkos->cost[0]->value;

                    echo "<div class='alert alert-info'>";
                    echo "Kota Asal: ".$kota_asal;
                    echo "<br>";
                    echo "Kota Tujuan : ".$kota_tujuan;
                    echo "<br>";
                    echo "Berat: ".$berat;
                    echo "<br>";
                    echo "Paket : ".$paket;
                    echo "<br>";
                    echo "Ongkos Kirim: Rp ".number_format($ongkos,0); 
                    echo "<br>";
                    echo "<div>";
                }
                ?>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
