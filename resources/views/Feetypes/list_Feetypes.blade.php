@extends('layouts.layout')

@section('title', 'List Feetypes')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')
@include('flash')

<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                  
                    <!--<th>Photo</th>-->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $allFeetypes as $Feetypes )
                <tr>
                    <td>{{ $Feetypes->name }}</td>
                     
             

                    <td class=center>
                        <a class="btn btn-default btn-success" href="{{url('FeeTypes/'.$Feetypes->enc_id).'/edit'}}">Edit</a>
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['route' => ['FeeTypes.destroy', $Feetypes->enc_id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Feetypes->id}}">
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

@endsection