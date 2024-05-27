@extends('app')

@section('content')
   <div class="card mt-5">
       <div class="card-header">
           <h3>Client List</h3>
           <a href="{{ route('clients.create') }}">
           <button type="button" class="btn btn-primary float-end">Add New Client</button>
           </a>

           @if (session('success'))
               <div>{{ session('success') }}</div>
           @endif
       </div>
       <div class="card-body">
           <table class="table">
               <thead>
                   <tr>
                       <th scope="col">Client ID</th>
                       <th scope="col">Name</th>
                       <th scope="col">Phone No.</th>
                       <th scope="col">Email</th>
                       <th scope="col">Action</th>
                   </tr>
               </thead>
               <tbody>
                   @if ($clients->count())
                       @foreach ($clients as $client)
                       <tr class="table-active">
                               <td>{{ $client->id }}</td>
                               <td>{{ $client->name }}</td>
                               <td>{{ $client->phone_no }}</td>
                               <td>{{ $client->email }}</td>
                               <td>
                                   <a href="{{ route('clients.show', $client->id) }}">
                                   <button type="submit" class="btn btn-success" >Show</button>
                                   </a>
                                   <a href="{{ route('clients.edit', $client->id) }}">
                                   <button type="submit" class="btn btn-info" >Edit</button>
                                   </a>
                                   <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-danger" >Delete</button>
                                   </form>
                               </td>
                           </tr>
                       @endforeach
                   @else
                       <tr>
                           <td colspan="5">No clients available yet.</td>
                       </tr>
                   @endif
               </tbody>
           </table>
       </div>
   </div>
@endsection
