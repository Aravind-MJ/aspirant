@extends('layouts.layout')

@section('title', ' Batchdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->
@section('content')

@section('body')
@include('flash')

<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <tbody> 
                 
                <tr>                   
                    <tr><th>Batch     </th><td>{{ $Batchdetails->batch}}</td></tr>
                    <tr><th>Syllabus  </th><td>{{ $Batchdetails->syllabus}}</td></tr>
                    <tr><th>Time_shift</th><td>{{ $Batchdetails->time_shift}}</td></tr>
                    <tr><th>Year      </th><td>{{ $Batchdetails->year}}</td></tr>
                    <tr><th>In_charge </th><td>{{ $Batchdetails->first_name}}</td></tr>
                    <tr><th>Edit       </th><td class=center>
                       
                        <a href='{{ $Batchdetails->id }}/edit' class='btn btn-primary'>Edit</a>
                    </td></tr>
                    
                    <tr><th>Delete</th><td class=center>
                        {!! Form::open(['action' => ['BatchDetailsController@destroy', $Batchdetails->id], 'method' => 'POST']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Batchdetails->id}}">
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

