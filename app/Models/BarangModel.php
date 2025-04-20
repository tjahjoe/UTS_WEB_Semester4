<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';  // Menentukan nama tabel yang digunakan oleh model
    protected $primaryKey = 'id_barang';  // Menentukan primary key tabel
    protected $fillable = ['nama', 'harga', 'stok', 'deskripsi'];  // Kolom yang dapat diisi massal (mass assignable)

    // Relasi dengan model Transaksi (One to Many)
    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiModel::class, 'id_barang', 'id_barang');  // Relasi satu ke banyak antara Barang dan Transaksi
    }
}
