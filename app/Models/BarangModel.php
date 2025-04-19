<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama', 'harga', 'stok', 'deskripsi'];

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiModel::class, 'id_barang', 'id_barang');
    }

}
