@extends('layouts.layout')

@section('title', 'List of Admins')

@section('body')
    @include('flash')
    <div class="box box-primary">
    <div class="box-body">
    <table id="admins" class="table table-stripped table-hover text-center">
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
                <td class="col-lg-1">{{$i}}</td>
                <td>{{ $user->email }}<br>
                </td>
                <td>{{ $user->first_name}}</td>
                <td>{{ $user->last_name}}</td>
                <td class="col-lg-1"><a href="{{ url('edit/admin/'.$user->enc_id) }}" class="btn btn-warning btn-block">Edit</a> </td>
                <td class="col-lg-1">
                    {!! Form::open(array('url' => 'admin/' . $user->enc_id,)) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::submit('DELETE', array('class' => 'btn btn-danger btn-block')) !!}
                    {!! Form::close() !!}
                </td>
             </tr>
             <?php $i++; ?>
            @endforeach

        </tbody>
    </table>
    </div>
    </div>

@stop

@section('pagescript')
    $('#admins').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });
@stop