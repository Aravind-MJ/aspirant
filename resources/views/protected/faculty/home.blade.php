@extends('layouts.layout')

@section('title', 'Faculty | Home')

@section('body')

    @if (session()->has('flash_message'))
            <p>{{ session()->get('flash_message') }}</p>
    @endif

    @if (Sentinel::check())
        <p>{{ "Welcome, " . Sentinel::getUser()->first_name }}</p>
    @endif

    <p>This is for Fcaulty only!</p>

@endsection