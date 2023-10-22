<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'telepon',
        'status',
    ];

    public function Transaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_kurir', 'id_kurir');
    }
}
