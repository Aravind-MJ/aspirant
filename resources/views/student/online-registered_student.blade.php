@extends('layouts.layout')

@section('title', 'OnlineRegistered Students')

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
                    <th>Batch</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Parent</th>   
                    <th>Address</th>   
                    <th>Contact</th>
                     <th>School</th>   
                     <th>Rank</th>   
                     <th>Percentage</th> 
                     <th>Photo</th>   
<!--                    <th>Balance</th> -->
                    <th>Edit</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach($allFeedetails as $Feedetails)
                <tr>
                     <td>{{ $Feedetails->firstname}} {{ $Feedetails->lastname }}</td>
                     <td>{{ $Feedetails->batch_id}}</td>
                     <td>{{ $Feedetails->gender}}</td>
                     <td>{{ $Feedetails->dob}}</td>
                     <td>{{ $Feedetails->email}}</td>
                     <td>{{ $Feedetails->parent}}</td>
                     <td>{{ $Feedetails->address}}</td>
                     <td>{{ $Feedetails->contact}}</td>
                     <td>{{ $Feedetails->school}}</td>
                     <td>{{ $Feedetails->rank}}</td>
                     <td>{{ $Feedetails->percent}}</td>
                     
                      <td>
                          <img src="{{ asset('images/students/'. $Feedetails->photo) }}"  alt="photo" width="50" height="50"/>
                      </td>


              

                    <td class=center>
                        <a class="btn btn-default btn-success" href="{{url('Feedetails/'.$Feedetails->enc_id).'/edit'}}">Edit</a>
                    </td>
<!--                     <td class=center>
                        {!! Form::open(['route' => ['Feedetails.destroy', $Feedetails->enc_id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Feedetails->id}}">
                        <button type="submit" class="btn btn-danger btn-block">Delete</button>
                        {!! Form::close() !!}
                    </td>-->
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