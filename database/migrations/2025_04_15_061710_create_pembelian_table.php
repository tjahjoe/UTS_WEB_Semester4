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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');  // Membuat kolom id_pembelian sebagai primary key dengan tipe BIGINT dan auto-increment
            $table->unsignedBigInteger('id_akun');  // Membuat kolom id_akun yang menghubungkan ke akun yang melakukan pembelian
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'gagal']);  // Membuat kolom status dengan tipe ENUM untuk menyimpan status pembelian
            $table->decimal('total', 10, 2);  // Membuat kolom total dengan tipe DECIMAL yang menyimpan total pembelian
            $table->timestamp('tanggal_pembelian')->useCurrent();  // Membuat kolom tanggal_pembelian dengan default waktu saat ini
            $table->timestamps();  // Menambahkan kolom created_at dan updated_at secara otomatis

            // Menambahkan foreign key yang menghubungkan id_akun dengan id_akun pada tabel akun
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
