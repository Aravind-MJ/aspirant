@extends('layouts.layout')

@section('title', 'List of Admins')

@section('body')
    @if (session()->has('flash_message'))
        @include('session_flash')
    @endif
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
              <th>Sl no.</th>
              <th>Email</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
        </thead>

        <tbody>
        <?php $i=1; ?>
            @foreach ($users as $user)
            <tr>
                <td>{{$i}}</td>
                <td><a href="{{url('admin/'.$user->id)}}">{{ $user->email }}</a> <br>
                </td>
                <td>{{ $user->first_name}}</td>
                <td>{{ $user->last_name}}</td>
                <td><a href="{{ url('edit/admin/'.$user->enc_id) }}" class="btn btn-warning">Edit</a> </td>
                <td>
                    {!! Form::open(array('url' => 'admin/' . $user->enc_id,)) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::submit('DELETE', array('class' => 'btn btn-danger')) !!}
                    {!! Form::close() !!}
                </td>
             </tr>
             <?php $i++; ?>
            @endforeach

        </tbody>
    </table>

@stop