@extends('layouts.layout')

@section('title', 'Mark Attendance')

@section('body')

    @if (isset($flash_message))
            @include('flash')
    @else


    @endif
@endsection

@section('pagescript')

@stop