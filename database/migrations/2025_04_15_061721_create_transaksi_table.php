<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_akun');
            $table->unsignedBigInteger('id_bunga');
            $table->integer('jumlah_beli');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();

            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->foreign('id_bunga')->references('id_bunga')->on('barang')->onDelete('cascade');
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
