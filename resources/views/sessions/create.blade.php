@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'sessions.store']) !!}
                        <fieldset>

                            @include('flash')

                            <!-- Email field -->
                            <div class="form-group">
                                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('email', $errors) !!}
                            </div>

                            <!-- Password field -->
                            <div class="form-group">
                                {!! Form::password('password', ['placeholder' => 'Password','class' => 'form-control', 'required' => 'required'])!!}
                                {!! errors_for('password', $errors) !!}
                            </div>

                            <div class="checkbox">
                                <!-- Remember me field -->
                                <div class="form-group">
                                    <label>
                                        {!! Form::checkbox('remember', 'remember') !!} Remember me
                                    </label>
                                </div>
                            </div>

                            <!-- Submit field -->
                            <div class="form-group">
                                {!! Form::submit('Login', ['class' => 'btn btn btn-lg btn-success btn-block']) !!}
                            </div>
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div style="text-align:center">
                    <p><a href="{{ url('forgot_password') }}">Forgot Password?</a></p>
                    
                    <p><strong>Super Admin User:</strong> superadmin@superadmin.com<br>
                    <strong>Super Admin Password:</strong> sentinelsuperadmin</p>

                    <p><strong>Admin User:</strong> admin@admin.com<br>
                    <strong>Admin Password:</strong> sentineladmin</p>

                    <p><strong>Standard User:</strong> user@user.com<br>
                    <strong>Standard User Password:</strong> sentineluser</p>
                    
                    <p><strong>Faculty User:</strong> faculty@faculty.com<br>
                    <strong>Faculty Password:</strong> sentinelfaculty</p>
                </div>


            </div>
        </div>
    </div>

@endsection