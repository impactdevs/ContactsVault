<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //just create one chat here
        $chat = new Chat();
        $chat->name = 'John Doe';
        $chat->message = 'Hello, how are you?';
        $chat->channel = 'email';
        $chat->contact = '0785065399';
        $chat->status = 'unread';
        $chat->chat_type = 'sms';
        $chat->messageCount = '1';
        $chat->save();
    }
}
