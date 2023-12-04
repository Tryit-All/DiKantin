<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'roles';
    protected $fillable = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at'
    ];


    public function permissions()
    {
        return $this->hasMany(RoleHasPermissions::class, "role_id");
    }

}
