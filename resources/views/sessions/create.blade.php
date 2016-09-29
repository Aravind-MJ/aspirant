@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="container full_front_page">
        <div class="row">
		<!-- Back to home link -->
		<div class="back_admin" > <button class="button1" style="vertical-align:middle"><span>Back to Home </span></button>	</div>
            <div class="col-md-6 col-md-offset-3 new">
			
                <div class="panel panel-default">
				
				<center> <img src="images/aspirant-login-logo.png" class="img-rounded img-rounded1"  width="204" height="106"> </center>
                    <div class="panel-heading">
                        <h3 class="panel-title">LOGIN FORM</h3>
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
                                {!! Form::submit('LOGIN', ['class' => 'btn btn btn1 btn-lg btn-success btn-block']) !!}
                            </div>
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div style="text-align:center">
                    <p class="user_pass"><a href="{{ url('forgot_password') }}">Forgot Password?</a></p>
                    
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