@extends('app')

@section('content')
    <div class="container mt-3">
        <div class="content">
            
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="form">
                <form method="POST" action="{{ url('/send_message') }}">
                    @csrf 
                    <div class="mb-3">
                        <label for="conversationId" class="form-label">Conversation ID</label>
                        <input type="text" name="conversationId" class="form-control" id="conversationId" aria-describedby="conversationHelp" >
                    </div>

                    <div class="mb-3">
                        <label for="channel" class="form-label">Channel</label>
                        <input type="text" name="channel" class="form-control" id="channel" aria-describedby="channelHelp" >
                    </div>

                    <div class="mb-3">
                        <label for="from" class="form-label">From Phone Number</label>
                        <input type="text" name="from" class="form-control" id="from" aria-describedby="fromHelp" >
                    </div>

                    <div class="mb-3">
                        <label for="to" class="form-label">To Phone Number</label>
                        <input type="text" name="to" class="form-control" id="to" aria-describedby="toHelp" >
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">SMS Content</label>
                        <textarea name="content" class="form-control" id="content" aria-describedby="contentHelp" placeholder="Enter your SMS message here."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="contentType" class="form-label">Content Type</label>
                        <input type="text" name="contentType" class="form-control" id="contentType" aria-describedby="contentTypeHelp" >
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
@endsection
