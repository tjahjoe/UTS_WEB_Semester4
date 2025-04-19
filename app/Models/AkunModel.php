<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AkunModel extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    protected $fillable = ['email', 'password', 'status', 'tingkat'];

    public function biodata(): HasOne
    {
        return $this->hasOne(BiodataModel::class, 'id_akun', 'id_akun');
    }
}
