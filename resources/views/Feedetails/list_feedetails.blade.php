@extends('layouts.layout')

@section('title', 'List Feedetails')

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
                    <th>Student_name</th>
                    <th>First_Insatallment</th>
                    <th>Second_Installment</th>
                    <th>Third_Installment</th>
                    <th>Discount</th>   
<!--                    <th>Balance</th> -->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allFeedetails as $Feedetails)
                <tr>
                     <td>{{ $Feedetails->first_name}} {{ $Feedetails->last_name }}</td>
                     <td>{{ $Feedetails->first}}</td>
                     <td>{{ $Feedetails->second}}</td>
                     <td>{{ $Feedetails->third}}</td>
                     <td>{{ $Feedetails->discount}}</td>
              

                    <td class=center>
                        <a class="btn btn-default btn-success" href="{{url('Feedetails/'.$Feedetails->enc_id).'/edit'}}">Edit</a>
                    </td>
                    <td class=center>
                        {!! Form::open(['route' => ['Feedetails.destroy', $Feedetails->enc_id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()'])  !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Feedetails->id}}">
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
@section('dataTable')
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
@stop
@endsection