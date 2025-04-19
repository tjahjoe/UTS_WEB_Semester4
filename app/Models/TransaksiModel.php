<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['id_pembelian', 'id_barang', 'jumlah_beli', 'tanggal_transaksi', 'status'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'id_barang', 'id_barang');
    }
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(PembelianModel::class, 'id_pembelian', 'id_pembelian');
    }

}
