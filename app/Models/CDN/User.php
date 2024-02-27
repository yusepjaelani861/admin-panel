<?php

namespace App\Models\CDN;

use App\Models\CDN\Roles\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function roles()
    {
        // return $this->hasMany(UserRole::class);
        return $this->hasManyThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id');
    }

    public function files()
    {
        return $this->hasMany(Files::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class)->orderBy('name', 'asc');
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class)->orderBy('end_date', 'desc');
    }
}
