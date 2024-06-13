<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    //table name
    protected $table = 'messages';

    protected $fillable = [
        'name',
        'message',
        'channel',
        'contact',
        'status',
        'messageCount',
        'chat_type'
    ];
}
