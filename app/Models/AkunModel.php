<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AkunModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'akun';  // Menentukan nama tabel yang digunakan oleh model
    protected $primaryKey = 'id_akun';  // Menentukan primary key tabel
    protected $fillable = ['email', 'password', 'status', 'tingkat'];  // Kolom yang dapat diisi massal (mass assignable)

    protected $hidden = ['password'];  // Menyembunyikan kolom password agar tidak tampil dalam array/JSON

    protected $casts = ['password' => 'hashed'];  // Mengatur kolom password agar selalu di-hash

    // Relasi dengan model Biodata (One to One)
    public function biodata(): HasOne
    {
        return $this->hasOne(BiodataModel::class, 'id_akun', 'id_akun');  // Relasi satu ke satu antara Akun dan Biodata
    }

    // Fungsi untuk memeriksa apakah akun memiliki tingkat tertentu
    public function hasTingkat($tingkat): bool
    {
        return $this->tingkat == $tingkat;  // Mengembalikan true jika tingkat akun sama dengan tingkat yang diberikan
    }
}

