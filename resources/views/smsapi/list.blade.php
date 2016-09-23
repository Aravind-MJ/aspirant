@extends('layouts.layout')

@section('title', 'List Sms History')

@section('content')

@section('body')

@include('flash')
<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>SMS Type</th>
                    <th>Send By</th>
                    <th>Recipients</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach( $data as $each )
                <tr>
                    <td>{{ $each->type }}</td>
                    <td>{{ $each->name }}</td>
                    <td>{{ $each->numbers }}</td>
                    <td>{{ $each->message }}</td>
                    <td>{{ $each->time }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@stop
@endsection