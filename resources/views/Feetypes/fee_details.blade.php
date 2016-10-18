@extends('layouts.layout')

@section('title', 'Fee details of student')

@section('content')

@section('body')

<div class="col-md-6 col-md-offset-2">
    <div class="box box-primary">
        <div class="box-body">
            <div class="box-header">
                <h2 class="box-title"><strong> Fee details of student</strong></h2>
            </div>

            <table id="example2" class="table table-bordered table-hover">
                <tbody>                   
                    <tr><th>First name</th><td>{{ $student->first_name }}</td></tr>
                    <tr><th>Last name</th><td>{{ $student->last_name}}</td></tr>
                    <tr><th>Batch</th><td>{{$student->batch}}</td></tr>
                    <tr><th>Gender</th><td>{{ $student->gender }}</td></tr>
                                     
                    <tr>                      
                        <td><a href='{{ $student->enc_id }}/edit' class='btn btn-primary btn-block'>Edit Student</a>
                        </td>                   

                        {!! Form::open(['action' => ['FeebybatchController@destroy', $student->enc_id], 'method' => 'POST', 'class' => 'delete']) !!}
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