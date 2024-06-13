@extends('app')

@section('content')
    <div class="container h-100">
        <div class="card chat-container">
            <div class="card-header d-flex align-items-center">
                <a href="{{ route('inbox.index') }}" class="">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div class="avatar">
                    <img src="https://via.placeholder.com/50" class="rounded-circle" alt="Avatar">
                </div>
                <div class="ms-3">
                    <h5 class="mb-0">{{ $chat->name }}</h5>
                    <p class="text-muted mb-0">{{ $chat->contact }}</p>
                </div>
            </div>

            <div class="card-body chat-messages">
                @foreach (['How are you Wilber?', 'I am ok sir', 'How is home?', 'Home is great...', 'Home is great...', 'Home is great...', 'Home is great...', 'Home is great...', 'Home is great...', 'Home is great...'] as $message)
                    <div class="message mb-3">
                        <div class="message-content p-3 rounded bg-primary text-light">
                            <p class="mb-1">{{ $message }}</p>
                            <p class="small text-muted mb-0">12/12/2024</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-footer">
                <form action="/inbox/{{ $chat->id }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none border-spacing-5"
                            placeholder="Type your message here" name="message">
                        <button class="btn btn-primary">
                            <i class="bi bi-telegram"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            /* Enable vertical scrolling for messages */
        }
    </style>
@endsection
