<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiodataModel extends Model
{
    use HasFactory;

    protected $table = 'biodata';  // Menentukan nama tabel yang digunakan oleh model
    protected $primaryKey = 'id_biodata';  // Menentukan primary key tabel
    protected $fillable = ['id_akun', 'nama', 'umur', 'alamat', 'gender'];  // Kolom yang dapat diisi massal (mass assignable)

    // Relasi dengan model Akun (Belongs to)
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunModel::class, 'id_akun', 'id_akun');  // Relasi many-to-one antara Biodata dan Akun
    }
}
