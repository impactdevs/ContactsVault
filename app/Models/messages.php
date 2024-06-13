<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'msg_id',
        'channel',
        'from',
        'to',
        'direction',
        'conversationId',
        'text',
        'closedAt' ,
        'createdAt',
        'updatedAt',
        'contentType'
           
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
