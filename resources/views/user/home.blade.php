@extends('layouts.users')

@section('user-content')
   @auth
   <div class="container-user">
       <div class="card-header"><p>Home</p>

       </div>
   </div>
   @endauth
@endsection