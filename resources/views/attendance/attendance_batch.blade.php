@extends('layouts.layout')

@section('title', 'Faculty | Attendance by Batch')

@section('body')

    @if (isset($flash_message))
            @include('flash')
    @else

    <table id="attendance" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
    </table>

    @endif
@endsection

@section('pagescript')

@stop