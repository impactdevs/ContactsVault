
@extends('app')

@section('content')
    <div class="container">
    <div class="content">
    <nav class="nav nav-pills flex-column flex-sm-row mt-3">
            <a class="{{ request()->is('sms_inbox') ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('sms_inbox') }}">SMS</a>
            <a class="{{ request()->is('email_inbox') ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('email_inbox') }}">EMAIL</a>
            <a class="{{ request()->is('whatsapp_inbox') ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('whatsapp_inbox') }}">WHATSAPP</a>
        </nav>

    </div>
    </div>

   <div class="card mt-3">
       <div class="card-header">
       <h2>Email Inbox</h2>
           <a href="" class="btn btn-danger float-end">Back</a>

           @if (session('success'))
               <div class="alert alert-success" role="alert">
                   {{ session('success') }}
               </div>
           @endif
           @if (session('error'))
               <div class="alert alert-success" role="alert">
                   {{ session('error') }}
               </div>
           @endif
       </div>
       <div class="card-body">
           <div class="form">
                @if(!empty($response))
                    <ul>
                        @foreach($response as $msg)
                            <li>{{ $msg['sentAt'] }} - {{ $msg['sender'] }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No Whatsapp messages found.</p>
                @endif
            </div>

           </div>
       </div>
   </div>
@endsection

