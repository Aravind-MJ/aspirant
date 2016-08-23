@extends('layouts.layout')

@section('title', 'Create Admin')

@section('body')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">Register</h3>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => 'registration.store']) !!}
                        <fieldset>

                            @if (session()->has('flash_message'))
                                @include('session_flash')
                            @endif

                            <!-- Email field -->
                            <div class="form-group">
                                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('email', $errors) !!}
                            </div>

                            <!-- Password field -->
                            <div class="form-group">
                                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('password', $errors) !!}
                            </div>

                            <!-- Password Confirmation field -->
                            <div class="form-group">
                                {!! Form::password('password_confirmation', ['placeholder' => 'Password Confirm', 'class' => 'form-control', 'required' => 'required'])!!}

                            </div>

                            <!-- First name field -->
                            <div class="form-group">
                                {!! Form::text('first_name', null, ['placeholder' => 'First Name', 'class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('first_name', $errors) !!}
                            </div>

                            <!-- Last name field -->
                            <div class="form-group">
                                {!! Form::text('last_name', null, ['placeholder' => 'Last Name', 'class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('last_name', $errors) !!}
                            </div>

                            <!-- Submit field -->
                            <div class="form-group">
                                {!! Form::submit('Create Admin', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
                            </div>

                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>

@endsection