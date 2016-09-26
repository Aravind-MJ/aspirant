@extends('layouts.layout')

@section('title', 'Student | Notices')

@section('body')
    @include('flash')
	
	<div class="container">
        <div class="row">
		
			<div class="col-md-12 col-sm-22 col-xs-12 full_profile1 ">
			
			<div class="col-md-12 col-sm-12 col-xs-12 full_notics">
                            @foreach( $allNotice as $notice )
			<div class="notic_data">
			<i class="fa  fa-chevron-right" style="font-size:18"></i>
			&nbsp;&nbsp; {!! $notice->message !!} 
			<br><div class="date_noties">{{ date('d-m-Y', strtotime($notice->created_at)) }} </div>
			<div class="line1"></div>
			</div>
                            @endforeach
			<br>
			</div>
			</div>
		</div>
	</div>

@endsection