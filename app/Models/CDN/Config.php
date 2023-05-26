<?php

namespace App\Models\CDN;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'meta',
        'value'
    ];
}
