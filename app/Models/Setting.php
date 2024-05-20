<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_logo_path',
        'company_phone_number',
        'company_email',
        'fb_messenger_username',
        'twitter_username',
        'lapse_time',
        'followup_time',
        'automatic_reply_on_first_received_message',
        'is_automatic_reply_on',
    ];
}
