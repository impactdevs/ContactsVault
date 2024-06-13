@extends('app')
@section('content')
    <div class="container mt-2">
        @foreach ($chats as $chat)
            <x-chat.card :chat="$chat" />
        @endforeach
    </div>
@endsection
