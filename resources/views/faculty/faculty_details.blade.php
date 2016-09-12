@extends('layouts.layout')

@section('title', 'Faculty Details')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')

<div class="col-md-6 col-md-offset-2">
    <div class="box box-primary">
        <div class="box-body">
            <div class="box-header">
                <h3 class="box-title"><strong>Faculty Profile</strong></h3>
            </div>

            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                    <tr><th>First name</th><td>{{ $faculty->first_name }}</td></tr>
                    <tr><th>Last name</th><td>{{ $faculty->last_name}}</td></tr>
                    <tr><th>Qualification</th><td>{{ $faculty->qualification }}</td></tr>
                    <tr><th>Subject</th><td>{{ $faculty->subject}}</td></tr>
                    <tr><th>Phone</th><td>{{ $faculty->phone }}</td></tr>
                    <tr><th>Address</th><td>{{ $faculty->address }}</td></tr>
                    <tr><th>Photo</th><td><img src="{{ asset('images/'. $faculty->photo) }}"  alt="photo" width="50" height="50"/></td>
                    <tr><td><a href='{{ $faculty->id }}/edit' class='btn btn-primary btn-block'>Edit</a> </td>                  
                    <td>{!! Form::open(['action' => ['FacultyController@destroy', $faculty->id], 'method' => 'POST', 'class' => 'delete']) !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="delete">
                    <input type="hidden" name="id" value="{{$faculty->id}}">
                    <button type="submit" class="btn btn-danger btn-block">Delete</button>
                    {!! Form::close() !!}
                    </td>
                    </tr>
                    </tbody>

            </table>
        </div>
    </div>
</div>
@stop
@section('confirmDelete')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this item?");
    });
</script>
@stop
@endsection