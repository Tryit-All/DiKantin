<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_customer',
        'nama',
        'no_telepon',
        'alamat',
        'email',
        'password',
        'token',
        'email_verified',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_customer', 'id_customer');
    }
}