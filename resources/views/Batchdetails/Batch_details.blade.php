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
                        <a class="btn btn-default btn-success" href="{{url('BatchDetails/'.$Batchdetails->id).'/edit'}}">Edit</a>
                    </td>
                    
                    <tr><th>Delete</th><td class=center>
                          {!! Form::open(['route' => ['BatchDetails.destroy', $Batchdetails->id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()'])  !!}
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

