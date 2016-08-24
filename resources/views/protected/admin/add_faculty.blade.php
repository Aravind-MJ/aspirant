@extends('layouts.layout')

@section('title', 'Add Faculty')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')

{!! Form::open(['route' => 'newFaculty','enctype' => 'multipart/form-data']) !!}
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

        <!-- first_name Field -->
        <div class="form-group">
            {!! Form::label('firstname', 'First Name') !!}
            {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder'=>'Enter First Name']) !!}
            <!--{!! errors_for('first_name', $errors) !!}-->
        </div>

        <!-- last_name Field -->
        <div class="form-group">
            {!! Form::label('lastname', 'Last Name') !!}
            {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder'=>'Enter Last Name']) !!}
            <!--{!! errors_for('last_name', $errors) !!}-->

        </div>

        <div class="form-group">
            {!! Form::label('qualification', 'Qualification') !!}
            {!! Form::text('qualification', null, ['class'=>'form-control', 'placeholder'=>'Enter Qualification']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('subject', 'Subject') !!}
            {!! Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>'Enter Subject']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Enter Phone']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('address', 'Address') !!}
            {!! Form::textarea('address', null,  ['class'=>'form-control', 'placeholder'=>'Address']) !!}
        </div>

        <!-- email Field -->
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'Email']) !!}
            <!--{!! errors_for('email', $errors) !!}-->
        </div>

        <!-- Password field -->
        <div class="form-group">
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Password']) !!}
            <!--{!! errors_for('password', $errors) !!}-->
        </div>

        <!-- Password Confirmation field -->
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Repeat Password') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Repeat Password'] )!!}
        </div> 

        <div class="form-group">
            {!! Form::label('photo', 'Photo') !!}
            {!! Form::file('photo', null, ['class'=>'form-control']) !!}
            <!--{!! Form::file('photo', array('class' => 'form-control')) !!}-->
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