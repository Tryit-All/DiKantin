<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'role_has_permissions';
    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, "role_id");
    }

    public function permissions()
    {
        return $this->belongsTo(Permissions::class, "permissions_id");

    }

}
