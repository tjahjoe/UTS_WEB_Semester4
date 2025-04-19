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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->unsignedBigInteger('id_akun');
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'gagal']);
            $table->decimal('total', 10, 2);
            $table->timestamp('tanggal_pembelian')->useCurrent();
            $table->timestamps();

            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
