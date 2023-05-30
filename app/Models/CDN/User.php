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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function files()
    {
        return $this->hasMany(Files::class)->where('status', true);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class)->where('status', 1)->orderBy('name', 'asc');
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class)->orderBy('end_date', 'desc');
    }
}
