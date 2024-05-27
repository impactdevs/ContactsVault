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
            <h1>WhatsApp Outbox</h1>
            <a href="" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <div class="form">
                @isset($error)
                <div class="alert alert-success" role="alert">
                        <strong>Error:</strong> {{ $error }}
                    </div>
                @endisset

                @if (isset($data) && !empty($data))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Text</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->sentFrom }}</td>
                                    <td>{{ $item->sentTo }}</td>
                                    <td>{{ $item->text }}</td>
                                    <td>{{ $item->deliveryStatus }}</td>
                                    <td>{{ $item->sentAt }}</td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div>No items found in the API response.</div>
                @endif

                @isset($response)
                    <div>
                        <strong>Raw Response:</strong>
                        <pre>{{ $response }}</pre>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
