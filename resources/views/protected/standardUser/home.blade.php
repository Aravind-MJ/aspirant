@extends('layouts.layout')

@section('title', 'Student | Home')

@section('body')
    @include('flash')
	
	<div class="container">
        <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 full_profile1 ">
			<div class="col-md-1 col-sm-1 col-xs-12 ">
			
			</div>
            <div class="col-md-12 col-sm-12 col-xs-12 full_users">
			
					
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="name"><i class="fa fa-user icon_pro" style="font-size:18"></i> <span class="profile_data"> &nbsp; Name :</span>  {{ $student->first_name }} {{ $student->last_name}}
						</div>
						<div class="line"></div>
						<div class="bod"><i class="fa fa-calendar icon_pro" style="font-size:18"></i><span class="profile_data"> &nbsp; Date of birth :</span> {{ $student->dob }}
						
						</div>
						<div class="line"></div>
						<div class="roll_num"><i class="fa fa-tags icon_pro" style="font-size:18"></i><span class="profile_data"> &nbsp; Batch :</span> {{$student->batch}}						
						</div>
						<div class="line"></div>
						</div>		
					<div class="col-md-3 col-sm-3 col-xs-12 full_user img_profile">
					<center> <img src="{{ asset('images/students/'. $student->photo) }}" class="img-rounded"  width="180" height="160"></center>
				</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="add"><i class="fa fa-map-marker icon_pro" style="font-size:18"></i> <span class="profile_data"> &nbsp; &nbsp; Guardian :</span> {{ $student->guardian }}
						
						<div class="line"></div>
						<div class="add"><i class="fa fa-map-marker icon_pro" style="font-size:18"></i> <span class="profile_data"> &nbsp; &nbsp;Address :</span> {{ $student->address }}
						<span class="join_profile">&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-users icon_pro" style="font-size:18"></i><span class="profile_data"> &nbsp; Gender :</span> Male </span></div> 
						</div>
						<div class="line"></div>
						<div class="bod"><i class="fa fa-envelope icon_pro" style="font-size:18"></i><span class="profile_data"> &nbsp; Email id:</span> {{ $student->email }}  
						<span class="join_profile">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar  icon_pro" style="font-size:18"></i>
						<span class="profile_data"> &nbsp; Rank :</span> {{ $student->cee_rank }}</span></div>
						<div class="line"></div>
						<div class="bod"><i class="fa fa-phone icon_pro" style="font-size:18"></i><span class="profile_data"> &nbsp; Phone Number :</span> {{ $student->phone }}
						<span class="join_profile">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-table icon_pro" style="font-size:18"></i>
						<span class="profile_data"> &nbsp; Percentage :</span> {{ $student->percentage }}%</span> </div>
						<div class="line"></div>
						
						
					</div>		
				</div>
		
			</div>
		
		</div>
	</div>
@endsection