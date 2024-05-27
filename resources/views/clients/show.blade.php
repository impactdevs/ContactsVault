
@extends('app')

@section('content')
   <div class="card">
       <div class="card-header">
           <h1>Clients</h1>
           <a href="{{ route('clients.index') }}">
           <button type="button" class="btn btn-danger float-end">Back</button>
           </a>
       </div>
       <div class="card-body">
           <div class="text">

            <ul class="list-group">
            <li class="list-group-item active" aria-current="true">{{ $client->name }} </li>
            
            <li class="list-group-item">Client phone number : {{ $client->phone_no }}</li>
            <li class="list-group-item">Client email : {{ $client->email }}</li>
            
            </ul>
            <br>
            <div class="mb-3">
            <a href="{{ url('/compose_sms/'.$client->id) }}">
            <button type="button" class="btn btn-success float-end">Contact Client</button>
            </a>
           </div>
           </div>
       </div>
   </div>
@endsection
