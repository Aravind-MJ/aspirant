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
            <thead>
                <tr>
                    <th>Qualification</th>
                    <th>Subject</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <!--<th>Photo</th>-->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $allFaculties as $faculty )
                <tr>
                    <td>{{ $faculty->qualification }}</td>
                    <td>{{ $faculty->subject}}</td>
                    <td>{{ $faculty->phone }}</td>
                    <td>{{ $faculty->address }}</td>

                    <td class=center>
                        {!! Form::open(['route' => ['edit', $faculty->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="Edit">
                        <input type="hidden" name="id" value="{{$faculty->id}}">
                        <button type="submit" class="btn btn-social">Edit</button>
                        {!! Form::close() !!}
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['route' => ['destroy', $faculty->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$faculty->id}}">
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