<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappOutbox extends Model
{
    use HasFactory;
    protected $table = 'whatsappoutbox';

    protected $fillable = [
        'sentTo',
        'sentFrom',
        'text',
        'receivedAt'   ,
        'deliveryStatus'
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
