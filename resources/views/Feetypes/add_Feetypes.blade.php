@extends('layouts.layout')

@section('title', 'Add Feetypes')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')
{!! Form::open(['route' => 'FeeTypes.store', 'method'=>'post','enctype' => 'multipart/form-data']) !!}
@include('flash')
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

       <div class="form-group">
            {!! Form::Label('batch_id', 'Batch') !!}
            {!! Form::select('batch_id', $batch, null, ['class' => 'form-control']) !!}
            {!! errors_for('batch_id', $errors) !!}
        </div>  
        
<!--        <div class="form-group">
            {!! Form::label('first', 'First_Installment') !!}
            {!! Form::text('first', null, ['class' => 'form-control', 'placeholder'=>'Enter First-Installment']) !!}
            {!! errors_for('first', $errors) !!}
        </div>
        <div class="form-group">
            {!! Form::label('second', 'Second_Installment') !!}
            {!! Form::text('second', null, ['class' => 'form-control', 'placeholder'=>'Enter Second-Installment']) !!}
            {!! errors_for('second', $errors) !!}
        </div>
         <div class="form-group">
            {!! Form::label('third', 'Third_Installment') !!}
            {!! Form::text('third', null, ['class' => 'form-control', 'placeholder'=>'Enter Third-Installment']) !!}
            {!! errors_for('third', $errors) !!}
        </div>-->
         <div class="form-group">
            {!! Form::label('total_fee', 'Total Fee') !!}
            {!! Form::text('total_fee', null, ['class' => 'form-control', 'placeholder'=>'Enter Total Fee']) !!}
            {!! errors_for('total_fee', $errors) !!}
        </div>
<!--       <div class="form-group">
            {!! Form::label('discount', 'Discount') !!}
            {!! Form::text('discount', null, ['class' => 'form-control', 'placeholder'=>'Discount']) !!}
            {!! errors_for('discount', $errors) !!}
        </div>
       <div class="form-group">
            {!! Form::label('balance', 'Balance') !!}
            {!! Form::text('balance', null, ['class' => 'form-control', 'placeholder'=>'Balance']) !!}
            {!! errors_for('balance', $errors) !!}
        </div>-->
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