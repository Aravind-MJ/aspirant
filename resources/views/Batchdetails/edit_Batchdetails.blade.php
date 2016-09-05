@extends('layouts.layout')

@section('title', 'Edit Batchdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')

{!! Form::model($Batchdetails, ['method' => 'PATCH', 'route' => ['BatchDetails.update',$Batchdetails->id],'enctype' => 'multipart/form-data']) !!}
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

        <!-- first_name Field -->
        <div class="form-group">
            {!! Form::label('batch', 'Batch') !!}
            {!! Form::text('batch', null, ['class' => 'form-control', 'placeholder'=>'Enter  Batch']) !!}
            <!--{!! errors_for('first_name', $errors) !!}-->
        </div>
         <div class="form-group">
            {!! Form::label('syllabus', 'Syllabus') !!}
            {!! Form::text('syllabus', null, ['class' => 'form-control', 'placeholder'=>'Enter Syllabus']) !!}
            <!--{!! errors_for('first_name', $errors) !!}-->
        </div>
        <div class="form-group">
            {!! Form::label('time_shift', 'Time_shift') !!}
             {!! Form::text('time_shift', null, ['class' => 'form-control', 'placeholder'=>'00.00-00.00','id' => 'basicExample'])!!}
        </div>
       
         <div class="form-group">
            {!! Form::label('year', 'Year') !!}
            {!! Form::text('year', null, ['class' => 'form-control', 'placeholder'=>'Enter  year','id' => 'datepicker'])!!}
            <!--{!! errors_for('first_name', $errors) !!}-->
        </div>
        <div class="form-group">
            {!! Form::label('in_charge', 'Incharge') !!}
            {!! Form::select('in_charge',$users,null,['class' => 'form-control', 'placeholder'=>''])!!}
            {!! errors_for('name', $errors) !!}
            <!--{!! errors_for('first_name', $errors) !!}-->
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