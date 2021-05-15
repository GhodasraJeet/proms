@extends('mail.layout_mail')
@section('title','Welcome To PROMS')

@section('content')

<div class="row">
    <div class="col-md-12 d-flex justify-content-center">
        <h2>Welcome To PROMS {{ $user->name }}</h2>
        <div><a href="{{route('login')}}" class="btn btn-primary">Login</a></div>
    </div>
</div>

@endsection
