<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsOutbox extends Model
{
    use HasFactory;

    protected $table = 'smsoutbox';

    protected $fillable = [
        'sentTo',
        
        'text',
        'receivedAt'   ,
        'deliveryStatus'
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
