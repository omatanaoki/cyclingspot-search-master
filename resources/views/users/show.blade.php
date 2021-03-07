@extends('layouts.app')

@section('content')
    @include('users.user_info', ['user' => $user])
    @if (count($cycles) > 0)
        @include('cycles.cycles', ['cycles' => $cycles])
    @endif
@endsection