<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');  // Membuat kolom id_transaksi sebagai primary key dengan tipe BIGINT dan auto-increment
            $table->unsignedBigInteger('id_pembelian');  // Membuat kolom id_pembelian yang menghubungkan ke tabel pembelian
            $table->unsignedBigInteger('id_barang');  // Membuat kolom id_barang yang menghubungkan ke tabel barang
            $table->decimal('harga', 10, 2);  // Membuat kolom harga dengan tipe DECIMAL untuk menyimpan harga barang
            $table->integer('jumlah_beli');  // Membuat kolom jumlah_beli untuk menyimpan jumlah barang yang dibeli
            $table->timestamps();  // Menambahkan kolom created_at dan updated_at secara otomatis

            // Menambahkan foreign key yang menghubungkan id_pembelian dengan id_pembelian pada tabel pembelian
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');

            // Menambahkan foreign key yang menghubungkan id_barang dengan id_barang pada tabel barang
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
