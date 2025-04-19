<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $primaryKey = 'id_pembelian';
    protected $fillable = ['id_akun', 'status', 'total'];

    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunModel::class, 'id_akun', 'id_akun');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiModel::class, 'id_pembelian', 'id_pembelian');
    }
}
