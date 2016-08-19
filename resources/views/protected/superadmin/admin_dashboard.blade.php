@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')

    @if (session()->has('flash_message'))
            <p>{{ session()->get('flash_message') }}</p>
    @endif


    <div class="jumbotron">
        <h1>Admin Page</h1>
        <p>This page is for Super admins only!</p>
    </div>


@endsection