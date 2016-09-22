@extends('layouts.layout')

@section('title', 'List Batchdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')
@include('flash')

<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Batch</th>
                    <th>Syllabus</th>
                    <th>Time_shift</th>
                    <th>year</th>
                    <th>In_charge</th>
                    <th>View More</th>
                    <!--<th>Photo</th>-->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allBatchdetails as $Batchdetails)
                <tr>
                     <td>{{ $Batchdetails->batch}}</td>
                     <td>{{ $Batchdetails->syllabus}}</td>
                     <td>{{ $Batchdetails->time_shift}}</td>
                     <td>{{ $Batchdetails->year}}</td>
                     <td>{{ $Batchdetails->first_name}}</td>
                 
                     <td class=center>                      
                        <a href='BatchDetails/{{ $Batchdetails->id }}'>View more</a>
                    </td>
                    <td class=center>
                        <a class="btn btn-default btn-success" href="{{url('BatchDetails/'.$Batchdetails->enc_id).'/edit'}}">Edit</a>
                    </td>
                    <td class=center>
                        {!! Form::open(['route' => ['BatchDetails.destroy', $Batchdetails->enc_id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()'])  !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Batchdetails->id}}">
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