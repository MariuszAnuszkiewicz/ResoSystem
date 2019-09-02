@extends('layouts.users')

@section('user-content')
    <div class="container-user">
        <div class="card-header"><p>{!! $category !!} </p>

        </div>
        <div class="card-body">
            @auth
            @include('user.components.contentBox')
            @endauth
        </div>
    </div>
    <div class="error_empty"></div>
    <div class="error_not_exists"></div>
@endsection