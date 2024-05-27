@extends('app')

@section('content')
    <div class="container">
        <div class="content">
        <nav class="nav nav-pills flex-column flex-sm-row mt-3">
        <a class="{{ request()->is('sms_outbox' ) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/sms_outbox') }}">SMS</a>
        <a class="{{ request()->is('email_outbox' ) ? 'flex-sm-fill text-sm-center nav-link active' : ' flex-sm-fill text-sm-center nav-link ' }}" aria-current="page" href="{{ url('/email_outbox') }}">EMAIL</a>
        <a class="{{ request()->is('whatsapp_outbox' ) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/whatsapp_outbox') }}">WHATSAPP</a>
    </nav>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h1>SMS Outbox</h1>
            <a href="{{ url('/back') }}" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <div class="form">
                @isset($error)
                    <div style="color: red;">
                        <strong>Error:</strong> {{ $error }}
                    </div>
                @endisset

                @if (!empty($msg) && $msg->isNotEmpty())
                    @foreach ($msg as $sms)
                        <ul>
                            <li><strong>To:</strong> {{ $sms->sentTo ?? 'N/A' }}</li>
                            <li><strong>From:</strong> {{ $sms->sentFrom ?? 'N/A' }}</li>
                            <li><strong>Text:</strong> {{ $sms->text ?? 'N/A' }}</li>
                            <li><strong>Received At:</strong> {{ $sms->receivedAt ?? 'N/A' }}</li>
                            <li><strong>Delivery Status:</strong> {{ $sms->deliveryStatus ?? 'N/A' }}</li>
                        </ul>
                    @endforeach
                @else
                    <div>No items found in the database.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
