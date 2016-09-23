@extends('layouts.layout')

@section('title', 'Send an Sms - '.ucwords($type));

@section('body')
{!! Form::open(['url' => 'SmsApi', 'method'=>'post']) !!}
@include('flash')
<div class="box box-primary">
    <div class="box-body">
        {!! Form::hidden('type', $type) !!}
        <!-- Numbers Field -->
        <div class="form-group">
            {!! Form::label('numbers[]', 'Select Numbers') !!}
            {!! Form::select('numbers[]',$numbers,null,['id'=>'numbers','class' => 'form-control select2 phone-numbers','multiple'=>'multiple']) !!}
            {!! errors_for('numbers[]', $errors) !!}
        </div>
        <!-- Message Field -->
        <div class="form-group">
            {!! Form::label('message', 'Message') !!}
            {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder'=>'Enter Message']) !!}
            {!! errors_for('message', $errors) !!}
        </div>

        <br>
        <div class="form-group">
            {!! Form::submit( 'Submit', ['class'=>'btn btn-primary']) !!} 
        </div>

        {!! Form::close() !!}
    </div>

</div>
@stop

@section('pagescript')
    <script>
        $('.phone-numbers').select2();
    </script>
@stop