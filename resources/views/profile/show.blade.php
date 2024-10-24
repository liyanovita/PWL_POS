@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Profile</h1>
    <p>Username: {{ $user->username }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Level: {{ $user->level->level_nama }}</p>
</div>
@endsection
