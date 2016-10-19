@extends('layouts.layout')

@section('title', 'Edit batch Details')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')

<div class="row">
    @include('flash')
    <div class="col-md-6 col-md-offset-1">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Student-Profile Details</h3>
            </div>
            <div class="box-body">
                {!! Form::model($user,['method'=>'POST','route' => ['studentProfilen.update',$user->enc_id]]) !!}

                <fieldset>

                    <!--@include('flash')-->

                    <!-- Email field -->
                    <div class="form-group">
                        {!! Form::text('email', $user->email, ['disabled' => '', 'class' => 'form-control', 'required' => 'required'])!!}
                        {!! errors_for('email', $errors) !!}
                    </div>

                    <!-- First name field -->
                    <div class="form-group">
                        {!! Form::text('first_name', $user->first_name, ['placeholder' => 'First Name', 'class' => 'form-control', 'required' => 'required'])!!}
                        {!! errors_for('first_name', $errors) !!}
                    </div>

                    <!-- Last name field -->
                    <div class="form-group">
                        {!! Form::text('last_name', $user->last_name, ['placeholder' => 'Last Name', 'class' => 'form-control', 'required' => 'required'])!!}
                        {!! errors_for('last_name', $errors) !!}
                    </div>

                    <!-- Submit field -->
                    <div class="form-group">
                        {!! Form::submit('Edit Student', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
                    </div>

                </fieldset>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
    <!--</div>
    <div class="row">-->
    <div class="col-md-6 col-md-offset-1">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Student-Fee-Details</h3>
            </div>
                <div class="box-body">

                    {!! Form::model($feedetails, ['method'=>'PATCH','route' => ['Feebybatch.update', $feedetails->id],'enctype' => 'multipart/form-data']) !!}

                  

                    </div>--><div class="form-group">
                        {!! Form::label('first', 'First_Installment') !!}
                        {!! Form::text('first',null, ['class'=>'form-control', 'placeholder'=>'First-Installment']) !!}
                        {!! errors_for('first', $errors) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('second', 'Second_Installment') !!}
                        {!! Form::text('second',null, ['class'=>'form-control', 'placeholder'=>'Second-Installment']) !!}
                        {!! errors_for('second', $errors) !!}
                    </div>
                     <div class="form-group">
                        {!! Form::label('third', 'Third_Installment') !!}
                        {!! Form::text('third',null, ['class'=>'form-control', 'placeholder'=>'Third-Installment']) !!}
                        {!! errors_for('third', $errors) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('discount', 'Discount') !!}
                        {!! Form::text('discount',null, ['class'=>'form-control', 'placeholder'=>'Discount']) !!}
                        {!! errors_for('discount', $errors) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('balance', 'Balance') !!}
                        {!! Form::text('balance',null, ['class'=>'form-control', 'placeholder'=>'Balance']) !!}
                        {!! errors_for('balance', $errors) !!}
                    </div>
                 

                    <br>

                    <div class="form-group">
                        {!! Form::submit( 'Edit Student', ['class'=>'btn btn-lg btn-primary btn-block']) !!} 
                    </div>

                    {!! Form::close() !!}
                </div>

        </div>
    </div>
    
    
@stop

@endsection