<?php

namespace App\Models\CDN\Roles;

use App\Models\CDN\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'name',
        'price',
        'max_storage'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permission()
    {
        return $this->hasMany(RolePermission::class);
    }
}
