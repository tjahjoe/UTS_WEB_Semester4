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
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun');  // Membuat kolom id_akun dengan tipe data BIGINT dan menjadi primary key
            $table->string('email', 100)->unique();  // Membuat kolom email yang bersifat unik, dengan panjang maksimal 100 karakter
            $table->string('password', 255);  // Membuat kolom password yang dapat menampung string hingga 255 karakter
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');  // Membuat kolom status dengan dua pilihan 'aktif' atau 'nonaktif', default 'aktif'
            $table->enum('tingkat', ['admin', 'user'])->default('user');  // Membuat kolom tingkat dengan dua pilihan 'admin' atau 'user', default 'user'
            $table->timestamps();  // Menambahkan kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
