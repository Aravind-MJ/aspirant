@extends('layouts.layout')

@section('title', 'List Notice')

@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif

@section('body')

@include('flash')
<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Batch</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach( $allNotice as $notice )
                <tr>
                    <td>{!! $notice->message !!}</td>
                    <td>{{ $notice->batch }}</td>
                    <td class=center>
                       
                        <a href='Notice/{{ $notice->id }}/edit' class='btn btn-primary'>Edit</a>
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['action' => ['NoticeController@destroy', $notice->id], 'method' => 'POST', 'class' => 'delete']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$notice->id}}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@stop
@section('confirmDelete')
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this item?");
    });
</script>
@stop
@endsection