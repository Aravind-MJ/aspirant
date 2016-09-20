@extends('layouts.layout')

@section('title', 'Edit Feetypes')

@section('content')

<!--@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->
 
@section('body')
{!! Form::model($Feetypes, ['method' => 'PATCH', 'route' => ['FeeTypes.update',$Feetypes->id],'enctype' => 'multipart/form-data']) !!}

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
        
    </div>

</div>
@stop

@endsection