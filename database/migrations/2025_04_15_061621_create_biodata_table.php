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
        Schema::create('biodata', function (Blueprint $table) {
            $table->id('id_biodata');  // Membuat kolom id_biodata sebagai primary key dengan tipe BIGINT
            $table->unsignedBigInteger('id_akun')->unique();  // Membuat kolom id_akun sebagai foreign key yang mengarah ke id_akun pada tabel akun
            $table->string('nama', 100);  // Membuat kolom nama dengan tipe string yang dapat menampung maksimal 100 karakter
            $table->integer('umur');  // Membuat kolom umur dengan tipe integer
            $table->text('alamat');  // Membuat kolom alamat dengan tipe text
            $table->enum('gender', ['L', 'P']);  // Membuat kolom gender dengan dua pilihan: 'L' (Laki-laki) atau 'P' (Perempuan)
            $table->timestamps();  // Menambahkan kolom created_at dan updated_at secara otomatis

            // Menambahkan foreign key yang menghubungkan id_akun pada tabel akun
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
