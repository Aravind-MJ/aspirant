@extends('layouts.layout')

@section('title', 'List Student')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')


<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Batch</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Guardian</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>School</th>
                    <th>CEE Rank</th>
                    <th>Percentage</th>
                    <th>Photo</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $allStudents as $student )
                <tr>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name}}</td>
                    <td>{{ $student->batch }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->dob }}</td>
                    <td>{{ $student->guardian }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->school }}</td>
                    <td>{{ $student->cee_rank }}</td>
                    <td>{{ $student->percentage }}</td>
                    <td><img src="{{ asset('images/students/'. $student->photo) }}"  alt="photo" width="50" height="50"/></td>
                    <td class=center>
                       
                        <a href='Student/{{ $student->id }}/edit' class='btn btn-primary'>Edit</a>
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['action' => ['StudentController@destroy', $student->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$student->id}}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@stop

@endsection