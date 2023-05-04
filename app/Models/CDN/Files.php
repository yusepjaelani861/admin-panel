<?php

namespace App\Models\CDN;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'user_id',
        'folder_id',
        'name',
        'filename',
        'path',
        'slug',
        'size',
        'extension',
        'mime_type',
        'original_url',
        'views'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folders()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}
