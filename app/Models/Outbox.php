<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    use HasFactory;

    protected $table = 'outbox';

    protected $fillable = [
        'sentTo',
        'sentFrom',
        'body',
        'channel',
        'deliveryStatus'
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];

}
