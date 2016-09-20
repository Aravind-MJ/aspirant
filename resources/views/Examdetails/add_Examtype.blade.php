@extends('layouts.layout')

@section('title', 'Add Examtype')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')

{!! Form::open(['route' => 'ExamType.store', 'method'=>'post','enctype' => 'multipart/form-data']) !!}
@include('flash')
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

        <!-- first_name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter  Name']) !!}
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