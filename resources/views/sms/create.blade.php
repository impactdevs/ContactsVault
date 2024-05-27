@extends('app')

@section('content')
    <div class="container mt-3">
    <div class="content">
    <nav class="nav nav-pills flex-column flex-sm-row">
        <a class="{{ request()->is('compose_sms/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/compose_sms/' . $client->id) }}">SMS</a>
        <a class="{{ request()->is('compose_email/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : ' flex-sm-fill text-sm-center nav-link ' }}" aria-current="page" href="{{ url('/compose_email/'. $client->id) }}">EMAIL</a>
        <a class="{{ request()->is('compose_whatsapp/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/compose_whatsapp/'. $client->id) }}">WHATSAPP</a>
    </nav>
    </div>
    </div>

   <div class="card mt-3">
       <div class="card-header">
           <h1>Send SMS to {{ $client->name }}</h1>
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
               <form method="POST" action="{{ route('sendsms', $client->id)}}">
                   @csrf 

                   <div class="mb-3">
                       <label for="phone_no" class="form-label">Phone number</label>
                       <input type="text" name="phone_no" class="form-control" id="phone_no" value="{{ $client->phone_no }}" aria-describedby="phoneHelp" >
                   </div>

                   <div class="mb-3">
                       <label for="sms" class="form-label">SMS Message</label>
                       <textarea name="sms" class="form-control" id="sms" aria-describedby="smsHelp" placeholder="Enter your SMS message here."></textarea>
                   </div>
                
                   <button type="submit" class="btn btn-primary">Send</button>
               </form>
           </div>
       </div>
   </div>
@endsection
