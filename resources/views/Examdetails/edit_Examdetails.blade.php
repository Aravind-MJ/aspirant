@extends('layouts.layout')

@section('title', 'Edit Examdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')

{!! Form::model($Examdetails, ['method' => 'PATCH', 'route' => ['ExamDetails.update',$Examdetails->id],'enctype' => 'multipart/form-data']) !!}
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

    
        <!-- first_name Field -->
        <div class="form-group">
            {!! Form::label('Examtype', 'Examtype') !!}
            {!! Form::select('type_id',$Examtype,null,['class' => 'form-control', 'placeholder'=>''])!!}
            {!! errors_for('name', $errors) !!}
            <!--{!! errors_for('first_name', $errors) !!}-->
        </div>
        <div class="form-group">
            {!! Form::label('date', 'Exam_date') !!}
            {!! Form::text('date', null, ['class' => 'form-control', 'placeholder'=>'','id' => 'datepicker1'])!!}
            {!! errors_for('date', $errors) !!}
        </div>
        <div class="form-group">
            {!! Form::label('total_mark', 'TotalMark') !!}
            {!! Form::text('total_mark',null, ['class' => 'form-control', 'placeholder'=>'TotalMark'])!!}
            {!! errors_for('total_mark', $errors) !!}
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