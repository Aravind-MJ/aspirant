@extends('layouts.layout')

@section('title')
    Home
@stop

@section('body')

    <div class="jumbotron">
        <h3>@if(Sentinel::check())
                                        {{ Sentinel::getUser()->first_name }} {{Sentinel::getUser()->last_name}}
        @endif
        </h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia perferendis id odit laudantium non blanditiis debitis repellat nulla accusamus cupiditate unde.</p>

        @if (!Sentinel::check())
        <p>
            <a href="{{ url('login') }}" class="btn btn-success btn-lg" role="button">Login</a> or <a href="{{ url('register') }}" class="btn btn-primary btn-lg" role="button">Register</a>
        </p>
        @endif
    </div>

@stop