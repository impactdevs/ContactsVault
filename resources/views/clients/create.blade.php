
@extends('app')

@section('content')
   <div class="card">
       <div class="card-header">
           <h1>Clients</h1>
           <a href="{{ route('clients.index') }}">
           <button type="button" class="btn btn-danger float-end">Add New Client</button>
           </a>

           @if (session('success'))
            <div class="alert alert-success" role="alert">
            {{ session('success') }}
            </div>
           @endif
       </div>
       <div class="card-body">
           <div class="form">
           <form method="POST" action="{{ route('clients.store') }}" >
           @csrf 
                <div class="mb-3">
                    <label for="name" class="form-label">Client name</label>
                    <input type="text" name="name"class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">This can be a company name</div>
                </div>

                <div class="mb-3">
                    <label for="phone_no" class="form-label">Phone number</label>
                    <input type="text" name="phone_no" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">A Whatsapp number is more preferrable</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
           </div>
       </div>
   </div>
@endsection
