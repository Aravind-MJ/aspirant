@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')

    @include('flash')


    <div class="jumbotron">
        <h1>Admin Page</h1>
        <p>This page is for Super admins only!</p>
    </div>


@endsection