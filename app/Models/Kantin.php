<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    use HasFactory;
    protected $table = 'kantin';
    protected $primaryKey = 'id_kantin';
    public $incrementing = true;
    public $timestamps = true;
    protected $quarded = [];
    // protected $fillable = 'nama';

    protected $fillable = ['nama', 'id_kantin'];

    public function infoKantin()
    {
        return $this->hasOne(Kantin::class, 'id_kantin', 'id_kantin');
    }
    public function User()
    {
        return $this->belongsTo(Kantin::class, 'id_kantin', 'id_kantin');
    }
}