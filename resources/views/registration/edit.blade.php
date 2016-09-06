@extends('layouts.layout')

@section('title', 'Edit Admin')

@section('body')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit</h3>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => ['registration.update',$user->enc_id]]) !!}
                        <fieldset>

                            @include('flash')

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
                                {!! Form::submit('Edit Admin', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
                            </div>

                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>

@endsection