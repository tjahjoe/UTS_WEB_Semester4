<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi';  // Menentukan nama tabel yang digunakan oleh model
    protected $primaryKey = 'id_transaksi';  // Menentukan primary key tabel
    protected $fillable = ['id_pembelian', 'id_barang', 'jumlah_beli', 'tanggal_transaksi', 'status', 'harga'];  // Kolom yang dapat diisi massal

    // Relasi dengan model Barang (Belongs to)
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'id_barang', 'id_barang');  // Relasi many-to-one antara Transaksi dan Barang
    }

    // Relasi dengan model Pembelian (Belongs to)
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(PembelianModel::class, 'id_pembelian', 'id_pembelian');  // Relasi many-to-one antara Transaksi dan Pembelian
    }
}

