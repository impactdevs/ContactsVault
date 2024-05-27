@extends('app')

@section('content')
   <div class="card">
       <div class="card-header">
           <h1>Edit Client</h1>
           <a href="{{ route('clients.index') }}" class="btn btn-danger float-end">Back</a>

           @if (session('success'))
               <div class="alert alert-success" role="alert">
                   {{ session('success') }}
               </div>
           @endif
       </div>
       <div class="card-body">
           <div class="form">
               <form method="POST" action="{{ route('clients.update', $client->id) }}">
                   @csrf
                   @method('PUT')
                   
                   <div class="mb-3">
                       <label for="name" class="form-label">Client name</label>
                       <input type="text" name="name" class="form-control" value="{{ $client->name }}" id="name" aria-describedby="nameHelp" required>
                       <div id="nameHelp" class="form-text">This can be a company name</div>
                       @error('name')
                           <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="phone_no" class="form-label">Phone number</label>
                       <input type="text" name="phone_no" class="form-control" value="{{ $client->phone_no }}" id="phone_no" aria-describedby="phoneHelp" required>
                       <div id="phoneHelp" class="form-text">A Whatsapp number is more preferable</div>
                       @error('phone_no')
                           <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="email" class="form-label">Email address</label>
                       <input type="email" name="email" class="form-control" value="{{ $client->email }}" id="email" aria-describedby="emailHelp" required>
                       <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                       @error('email')
                           <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                   </div>
                   
                   <button type="submit" class="btn btn-primary">Submit</button>
               </form>
           </div>
       </div>
   </div>
@endsection
