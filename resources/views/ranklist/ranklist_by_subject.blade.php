@extends('layouts.layout')

@section('title', 'Rank list By Subject')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')
<div class="box box-primary">
    <div class="box-body">
	
	<div class="form-group">
            {!! Form::Label('subject_id', 'Examdetails') !!}
            {!! Form::select('subject_id', $subject, $selectedSubject, ['class' => 'form-control']) !!}
            {!! errors_for('subject_id', $errors) !!}
				
    </div>  
    <br>
	
    <div class="form-group">
            <button class="btn btn-primary" onclick="route()">Filter</button>
    </div>
	
	<table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>First Name</th>
                    <th>mark</th>    
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $student as $each_subject )
	
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $each_subject->name }} </td>
                    <td>{{ $each_subject->total_mark }}</td>
                     
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>

        </table>        
            
    </div>

</div>
<script>
function route(){
	var subject = $('#subject_id').val();
	//alert(subject);
	var path = "{{url('RankList/bySubject')}}/"+subject;
	window.location.href=path;
}
</script>
@endsection
