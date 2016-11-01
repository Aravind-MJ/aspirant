@extends('layouts.layout')

@section('title', 'Rank list By Batch')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')
<div class="box box-primary">
    <div class="box-body">
	
	<div class="form-group">
            {!! Form::Label('batch_id', 'Batch') !!}
            {!! Form::select('batch_id', $batch, $selectedBatch, ['class' => 'form-control']) !!}
            {!! errors_for('batch_id', $errors) !!}
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
                @foreach( $students as $student )
	
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $student->name }} </td>
                    <td>{{ $student->total_mark }}</td>
                     
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>

        </table>        
            
    </div>

</div>
@endsection
@section('pagescript')

<script>
function route(){
	var batch = $('#batch_id').val();
	var path = "{{url('RankList/byBatch')}}/"+batch;
	window.location.href=path;
}
</script>

@endsection