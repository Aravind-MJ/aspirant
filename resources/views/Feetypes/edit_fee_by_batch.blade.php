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
                <h3 class="box-title">Student-Personal Details</h3>
            </div>
                <div class="box-body">

                    {!! Form::model($student, ['method'=>'PATCH','route' => ['Student.update', $student->id],'enctype' => 'multipart/form-data']) !!}

                    <div class="form-group">
                        {!! Form::Label('batch', 'Batch') !!}
                        {!! Form::select('batch_id', $batch, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::Label('gender', 'Gender') !!}<br>
                        {!! Form::radio('gender', 'male') !!}{!! Form::Label('gender', 'Male') !!}
                        {!! Form::radio('gender', 'female') !!}{!! Form::Label('gender', 'Female') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('dob', 'Date Of Birth') !!}
                        {!! Form::text('dob', null, ['class'=>'form-control', 'placeholder'=>'Date Of Birth', 'id'=>'datepicker']) !!}
                        {!! errors_for('dob', $errors) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('total_fee', 'Total_Fee') !!}
                        {!! Form::text('total_fee',null, ['class'=>'form-control', 'placeholder'=>'Total_fee']) !!}
                        {!! errors_for('total_fee', $errors) !!}
                    </div>
                 

                    <br>

                    <div class="form-group">
                        {!! Form::submit( 'Edit Student', ['class'=>'btn btn-lg btn-primary btn-block']) !!} 
                    </div>

                    {!! Form::close() !!}
                </div>

        </div>
    </div>
</div>
@stop

@endsection