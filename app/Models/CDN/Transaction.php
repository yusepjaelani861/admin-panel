<?php

namespace App\Models\CDN;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cdn';

    protected $fillable = [
        'user_id',
        'reference',
        'merchant_ref',
        'amount',
        'status',
        'checkout_url',
        'data'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
