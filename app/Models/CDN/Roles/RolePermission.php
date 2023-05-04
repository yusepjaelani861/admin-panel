<?php

namespace App\Models\CDN\Roles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'role_id',
        'permission',
        'value',
        'status'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
