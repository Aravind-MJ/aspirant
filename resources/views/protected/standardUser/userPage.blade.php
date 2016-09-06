@extends('layouts.layout')

@section('title', 'Registered Users')

@section('body')

    @include('flash')

    @if (Sentinel::check())
        <p>{{ "Welcome, " . Sentinel::getUser()->first_name }}</p>
    @endif

    <p>This is for standard users only!</p>

@endsection