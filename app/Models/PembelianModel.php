<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian';  // Menentukan nama tabel yang digunakan oleh model
    protected $primaryKey = 'id_pembelian';  // Menentukan primary key tabel
    protected $fillable = ['id_akun', 'status', 'total'];  // Kolom yang dapat diisi massal (mass assignable)

    // Relasi dengan model Akun (Belongs to)
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunModel::class, 'id_akun', 'id_akun');  // Relasi many-to-one antara Pembelian dan Akun
    }

    // Relasi dengan model Transaksi (Has Many)
    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiModel::class, 'id_pembelian', 'id_pembelian');  // Relasi one-to-many antara Pembelian dan Transaksi
    }
}
