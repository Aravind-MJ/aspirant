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

<!--         first_name Field -->
         <div class="form-group">
            {!! Form::Label('batch_id', 'Batch') !!}
            {!! Form::select('batch_id', $batch, null, ['class' => 'form-control']) !!}
        </div> 
         <div class="form-group">
            {!! Form::label('total_fee', 'Total Fee') !!}
            {!! Form::text('total_fee', null, ['class' => 'form-control', 'placeholder'=>'Enter Total Fee']) !!}
            {!! errors_for('total_fee', $errors) !!}
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