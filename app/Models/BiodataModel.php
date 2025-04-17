<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiodataModel extends Model
{
    use HasFactory;

    protected $table = 'biodata';
    protected $primaryKey = 'id_biodata';
    protected $fillable = ['id_akun', 'nama', 'umur', 'alamat', 'gender'];
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunModel::class, 'id_akun', 'id_akun');
    }
}
