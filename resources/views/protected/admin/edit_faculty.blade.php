@extends('layouts.layout')

@section('title', 'Edit Faculty')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')

{!! Form::model($faculty, ['method' => 'POST', 'route' => ['update', $faculty->id]]) !!}
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">


        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
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
        
        <div class="form-group">
            {!! Form::label('photo', 'Photo') !!}
            {!! Form::file('photo', null, ['class'=>'form-control', 'placeholder'=>'Photo']) !!}
        </div>

        <br>
        <div class="form-group">
            {!! Form::submit( 'Submit', ['class'=>'btn btn-primary']) !!} 
        </div>

        {!! Form::close() !!}
                @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
@stop

@endsection