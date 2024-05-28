
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
           @if (isset($data) && !empty($data))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th> 
                            <th>Sent From</th>  
                            <th>Sent To</th>                  
                            <th>Body</th>
                            <th>Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                               <td>{{ $item->id }}</td>
                               <td>{{ $item->sentFrom }}</td>
                               <td>{{ $item->sentTo }}</td>
                               <td>{{ $item->text }}</td>
                               <td>{{ $item->receivedAt }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                @else
                    <div style="color: red;">
                        <strong>Error:</strong> No email inbox data available.
                    </div>
                @endif
           

           </div>
       </div>
   </div>
@endsection
