<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'kode_tr';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = array('status_konfirm', 'status_pesanan', 'tanggal', 'id_customer', 'id_kurir', 'id_kasir', 'total_bayar', 'total_harga', 'kembalian', 'status_pengiriman', 'bukti_pengiriman', 'model_pembayaran', 'expired_at', 'created_at', 'updated_at');

    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_tr', 'kode_tr');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function Kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir', 'id_kurir');
    }

    public static function getTotalPendapatanByTanggal($tanggal)
    {
        return static::where('created_at', $tanggal)
            ->sum('total_harga');
    }
    public static function getTotalTransaksiByTanggal($tanggal)
    {
        return static::whereDate('created_at', $tanggal)->count();
    }
}