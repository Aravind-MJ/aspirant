@extends('layouts.layout')

@section('title', 'Add Notice')

@section('content')

@section('body')
  @include('flash')
{!! Form::open(['action' => 'NoticeController@store','method'=>'POST']) !!}
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

        <div class="form-group">
            {!! Form::Label('batch', 'Batch') !!}
            {!! Form::select('batch_id', $batch, null, ['class' => 'form-control']) !!}
        </div>      

        <div class="form-group">
            {!! Form::label('message', 'Message') !!}
            {!! Form::textarea('message', null,  ['placeholder'=>'Message', 'class' => 'form-control ckeditor']) !!}
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
@section('ckeditor')
<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js" />
@stop
@endsection
 
