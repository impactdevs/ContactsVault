@extends('app')

@section('content')
<div class="container mt-3">
    <div class="content">
    <nav class="nav nav-pills flex-column flex-sm-row">
        <a class="{{ request()->is('compose_sms/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/compose_sms/' . $client->id) }}">SMS</a>
        <a class="{{ request()->is('compose_email/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : ' flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/compose_email/'. $client->id) }}">EMAIL</a>
        <a class="{{ request()->is('compose_whatsapp/' . $client->id) ? 'flex-sm-fill text-sm-center nav-link active' : 'flex-sm-fill text-sm-center nav-link' }}" aria-current="page" href="{{ url('/compose_whatsapp/'. $client->id) }}">WHATSAPP</a>
    </nav>

    </div>
    </div>


   <div class="card mt-3">
       <div class="card-header">
           <h1>Send Email to {{ $client->name }}</h1>
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
               <form method="POST" action="{{ route('sendemail', $client->id)}}">
                   @csrf 

                   <div class="mb-3">
                       <label for="email" class="form-label">Email Address</label>
                       <input type="email" name="email" class="form-control" id="email" value="{{ $client->email }}" aria-describedby="phoneHelp" >
                   </div>

                   <div class="mb-3">
                       <label for="subject" class="form-label">Subject</label>
                       <input type="text" name="subject" class="form-control" id="subject" aria-describedby="phoneHelp">
                   </div>

                   <div class="mb-3">
                       <label for="body" class="form-label">Email body</label>
                       <textarea class="form-control" id="content" placeholder="Enter the Description" rows="5" name="body"></textarea>
                    </div>
                   <button type="submit" class="btn btn-primary">Send</button>
               </form>
           </div>
       </div>
   </div>
@endsection
