<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{
    use HasFactory;

    protected $table = 'emailoutbox';

    protected $fillable = [
        'sentTo',
        'sentFrom',
        'text',
        'sentAt'   ,
        'deliveryStatus'
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
