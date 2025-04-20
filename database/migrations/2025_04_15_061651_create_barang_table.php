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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');  // Membuat kolom id_barang sebagai primary key dengan tipe BIGINT dan auto-increment
            $table->string('nama', 100)->unique();  // Membuat kolom nama dengan tipe string yang dapat menampung maksimal 100 karakter dan harus unik
            $table->decimal('harga', 10, 2);  // Membuat kolom harga dengan tipe decimal yang dapat menampung angka dengan 10 digit, 2 di antaranya untuk desimal
            $table->integer('stok');  // Membuat kolom stok dengan tipe integer untuk menyimpan jumlah stok barang
            $table->text('deskripsi')->nullable();  // Membuat kolom deskripsi dengan tipe text, yang bersifat nullable (boleh kosong)
            $table->timestamps();  // Menambahkan kolom created_at dan updated_at secara otomatis
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
