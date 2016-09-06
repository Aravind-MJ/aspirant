@extends('layouts.layout')

@section('title', 'Student Details')

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
                    <tr><th>First name</th> <td>{{ $student->first_name }}</td></tr>
                    <tr><th>Last name</th><td>{{ $student->last_name}}</td></tr>
                    <tr><th>Batch</th><td>{{ $student->batch }}</td></tr>
                    <tr><th>Gender</th><td>{{ $student->gender }}</td></tr>
                    <tr><th>DOB</th><td>{{ $student->dob }}</td></tr>
                    <tr><th>Guardian</th><td>{{ $student->guardian }}</td></tr>
                    <tr><th>Address</th><td>{{ $student->address }}</td></tr>
                    <tr><th>Phone</th><td>{{ $student->phone }}</td></tr>
                    <tr><th>School</th><td>{{ $student->school }}</td></tr>
                    <tr><th>CEE Rank</th><td>{{ $student->cee_rank }}</td></tr>
                    <tr><th>Percentage</th><td>{{ $student->percentage }}</td></tr>
                    <tr><th>Photo</th><td><img src="{{ asset('images/students/'. $student->photo) }}"  alt="photo" width="50" height="50"/></td></tr>
                    <tr><th>Edit</th><td class=center>
                       
                        <a href='{{ $student->id }}/edit' class='btn btn-primary'>Edit</a>
                    </td></tr>
                    
                    <tr><th>Delete</th><td class=center>
                        {!! Form::open(['action' => ['StudentController@destroy', $student->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$student->id}}">
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