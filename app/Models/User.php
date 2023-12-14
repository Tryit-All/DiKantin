<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'username',
        'email',
        'email_verified',
        'password',
        'id_kantin',
        'id_role',
        'foto',
        'google_id',
        'created_at',
        'updated_at',
        'fcm_token'
    ];

    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_kasir', 'id_user');
    }
    public function Kantin()
    {
        return $this->belongsTo(Kantin::class, 'id_kantin', 'id_kantin');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, "id_role");
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
}