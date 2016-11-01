@extends('layouts.layout')

@section('title', 'Rank list')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')


<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>First Name</th>
                    <th>mark</th>
                    <th>batch</th>
                    
                   
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $students as $student )
	
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $student->name }} </td>
                    <td>{{ $student->total_mark }}</td>
                    <td>{{ $student->batch }}</td>
                    
                    
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@stop
@endsection