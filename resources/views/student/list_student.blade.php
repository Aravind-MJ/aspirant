@extends('layouts.layout')

@section('title', 'List Student')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')


<div class="box box-primary">
    <div class="box-body">
        
        {!! Form::open(array('route' => 'search.queries', 'class'=>'form navbar-form navbar-right searchform')) !!}
        {!! Form::text('search', null, array('required', 'class'=>'form-control', 'placeholder'=>'Search for student...')) !!}
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}
        {!! Form::close() !!}
        @if (count($allStudents) === 0)
        <h4><strong> No Students Found! </strong></h4>
        @elseif (count($allStudents) >= 1)
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Full name</th>
                    <th>Batch</th>
                    <th>DOB</th>                   
                    <th>Photo</th>
                    <th>View more</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $allStudents as $student )
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name}}</td>
                    <td>{{ $student->batch }}</td>
                    <td>{{ $student->dob }}</td>
                    <td><img src="{{ asset('images/students/'. $student->photo) }}"  alt="photo" width="50" height="50"/></td>
                    <td class=center>                      
                        <a href='Student/{{ $student->id }}'>View more</a>
                    </td>
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
        @endif
    </div>

</div>
@stop

@endsection