@extends('layouts.layout')

@section('title', 'Faculty | Home')

@section('body')

    @include('flash')

    @if (Sentinel::check())
        <p>{{ "Welcome, " . Sentinel::getUser()->first_name }}</p>
    @endif

    <p>This is for Fcaulty only!</p>

@endsection