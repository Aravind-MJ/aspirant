@extends('layouts.layout')

@section('title', 'Edit Examdetails')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')

{!! Form::model($Subjects, ['method' => 'PATCH', 'route' => ['Subjects.update',$Subjects->id],'enctype' => 'multipart/form-data']) !!}
@include('flash')
<!--{!! Form::open() !!}-->
<div class="box box-primary">
    <div class="box-body">

    
        <!-- first_name Field -->
        <div class="form-group">
        
        <div class="form-group">
            {!! Form::label('subjects', 'Subject') !!}
            {!! Form::text('subjects', null, ['class' => 'form-control', 'placeholder'=>'Enter subject'])!!}
            {!! errors_for('subjects', $errors) !!}
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