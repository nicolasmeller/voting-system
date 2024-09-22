
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@auth
<p>Hello, {{ Auth::user()->name }}! You are logged in.</p>
@endauth

@endsection

