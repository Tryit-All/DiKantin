<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history_penarikan';
    protected $fillable = ['total_penarikan', 'kode_penarikan', 'id_kantin', 'id_kurir'];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'id_kantin');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }

}
