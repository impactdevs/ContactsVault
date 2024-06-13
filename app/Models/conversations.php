<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversations extends Model
{
    use HasFactory;

    protected $table = 'conversations';

    protected $fillable = [
        'conversation_id',
        'topic',
        'summary',
        'status',
        'priority',
        'queueId',
        'agentId',
        'closedAt' ,
        'createdAt',
        'updatedAt',
        'pendingsince'
           
    ];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];
}
