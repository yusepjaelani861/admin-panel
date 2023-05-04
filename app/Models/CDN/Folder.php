<?php

namespace App\Models\CDN;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'slug',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'parent_id')->with('folders')->where('status', 1)->orderBy('name', 'asc');
    }

    public function files()
    {
        return $this->hasMany(Files::class)->orderBy('name', 'asc');
    }
}
