<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];
}
