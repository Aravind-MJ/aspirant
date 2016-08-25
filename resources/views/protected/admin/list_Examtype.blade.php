@extends('layouts.layout')

@section('title', 'List Examtype')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')


<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                  
                    <!--<th>Photo</th>-->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $allExamtype as $Examtype )
                <tr>
                    <td>{{ $Examtype->name }}</td>
                     
             

                    <td class=center>
                        {!! Form::open(['route' => ['edit', $Examtype->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="Edit">
                        <input type="hidden" name="id" value="{{$Examtype->id}}">
                        <button type="submit" class="btn btn-default btn-success">Edit</button>
                        {!! Form::close() !!}
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['route' => ['destroy', $Examtype->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Examtype->id}}">
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