@extends('layouts.layout')

@section('title', 'Student Details')

@section('content')

@section('body')

<div class="col-md-6 col-md-offset-2">
    <div class="box box-primary">
        <div class="box-body">
            <div class="box-header">
                <h3 class="box-title"><strong>Student Profile</strong></h3>
            </div>

            <table id="example2" class="table table-bordered table-hover">
                <tbody>               
                    <tr>                   
                    <tr><th>First name</th> <td>{{ $student->first_name }}</td></tr>
                    <tr><th>Last name</th><td>{{ $student->last_name}}</td></tr>
                    <tr><th>Batch</th><td>{{$student->batch}}</td></tr>
                    <tr><th>Gender</th><td>{{ $student->gender }}</td></tr>
                    <tr><th>DOB</th><td>{{ $student->dob }}</td></tr>
                    <tr><th>Guardian</th><td>{{ $student->guardian }}</td></tr>
                    <tr><th>Address</th><td>{{ $student->address }}</td></tr>
                    <tr><th>Phone</th><td>{{ $student->phone }}</td></tr>
                    <tr><th>School</th><td>{{ $student->school }}</td></tr>
                    <tr><th>CEE Rank</th><td>{{ $student->cee_rank }}</td></tr>
                    <tr><th>Percentage</th><td>{{ $student->percentage }}</td></tr>
                    <tr><th>Photo</th><td><img src="{{ asset('images/students/'. $student->photo) }}"  alt="photo" width="50" height="50"/></td></tr>
                    <tr>                      
                        <td><a href='{{ $student->id }}/edit' class='btn btn-primary btn-block'>Edit Student</a>
                        </td>                   

                        {!! Form::open(['action' => ['StudentController@destroy', $student->id], 'method' => 'POST', 'class' => 'delete']) !!}
                        {!! csrf_field() !!}
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="id" value="{{$student->id}}">
                <td><button type="submit" class="btn btn-danger btn-block">Delete Student</button>
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