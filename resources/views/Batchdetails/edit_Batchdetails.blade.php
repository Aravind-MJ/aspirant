@extends('layouts.layout')

@section('title', 'Edit Batchdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')

{!! Form::model($Batchdetails, ['method' => 'PATCH', 'route' => ['BatchDetails.update',$Batchdetails->id],'enctype' => 'multipart/form-data']) !!}
@include('flash')
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

        <!-- first_name Field -->
        <div class="form-group">
            {!! Form::label('batch', 'Batch') !!}
            {!! Form::text('batch', null, ['class' => 'form-control', 'placeholder'=>'Enter  Batch']) !!}
            {!! errors_for('batch', $errors) !!}
        </div>
         <div class="form-group">
            {!! Form::label('syllabus', 'Syllabus') !!}
            {!! Form::text('syllabus', null, ['class' => 'form-control', 'placeholder'=>'Enter Syllabus']) !!}
            {!! errors_for('syllabus', $errors) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time_shift', 'Time_shift') !!}
            {!! Form::select('time_shift',array('Morning' => 'Morning', 'AfterNoon' => 'AfterNoon','Evening' =>'Evening'),null, ['class' => 'form-control', 'placeholder'=>'00.00-00.00','id' => 'calendar1'])!!}
            {!! errors_for('time_shift', $errors) !!}
        </div>
       
         <div class="form-group">
            {!! Form::label('year', 'Year') !!}
            {!!Form::selectYear('year', 1990, 2020,null,['class' => 'form-control', 'placeholder'=>'Enter  year'])!!}
            {!! errors_for('year', $errors) !!}
        </div>
        <div class="form-group">
            {!! Form::label('in_charge', 'Incharge') !!}
            {!! Form::select('in_charge',$users,null,['class' => 'form-control', 'placeholder'=>''])!!}
            {!! errors_for('name', $errors) !!}
           
        </div>
       
        <br>
        <div class="form-group">
            {!! Form::submit( 'Submit', ['class'=>'btn btn-primary']) !!} 
        </div>

        {!! Form::close() !!}
        <!--                @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif-->
    </div>

</div>
@stop

@endsection