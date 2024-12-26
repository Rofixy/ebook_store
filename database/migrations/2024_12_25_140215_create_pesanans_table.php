<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade'); // Assuming 'produks' table exists
            $table->string('produk');
            $table->decimal('harga', 15, 2);
            $table->integer('berat');
            $table->string('asal');
            $table->string('tujuan');
            $table->date('tanggal_pesanan');
            $table->integer('jumlah_pesanan');
            $table->decimal('jumlah_harga', 15, 2);
            $table->string('pemesan'); // To store the name of the logged-in user
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}
