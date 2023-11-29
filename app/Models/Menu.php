<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at'];

    public function DetailTransaksi()
    {
        return $this->hasOne(DetailTransaksi::class, 'id_menu', 'id_menu');
    }

    public function Kantin()
    {
        return $this->belongsTo(Menu::class, 'id_kantin', 'id_kantin');
    }
}