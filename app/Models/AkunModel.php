<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AkunModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    protected $fillable = ['email', 'password', 'status', 'tingkat'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function biodata(): HasOne
    {
        return $this->hasOne(BiodataModel::class, 'id_akun', 'id_akun');
    }
}
