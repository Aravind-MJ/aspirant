@extends('layouts.layout')

@section('title', 'List Faculty')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')


<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>First name</th><td>{{ $faculty->first_name }}</td></tr>
                    <tr><th>Last name</th><td>{{ $faculty->last_name}}</td></tr>
                    <tr><th>Qualification</th><td>{{ $faculty->qualification }}</td></tr>
                    <tr><th>Subject</th><td>{{ $faculty->subject}}</td></tr>
                    <tr><th>Phone</th><td>{{ $faculty->phone }}</td></tr>
                    <tr><th>Address</th><td>{{ $faculty->address }}</td></tr>
                    <tr><th>Photo</th><td><img src="{{ asset('images/'. $faculty->photo) }}"  alt="photo" width="50" height="50"/></td>
                    <tr><th>Edit</th><td class=center>                       
                        <a href='{{ $faculty->id }}/edit' class='btn btn-primary'>Edit</a>
                    </td></tr>                    
                    <tr><th>Delete</th><td class=center>
                        {!! Form::open(['action' => ['FacultyController@destroy', $faculty->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$faculty->id}}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

</div>
@stop

@endsection