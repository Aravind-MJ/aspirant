@extends('layouts.layout')

@section('title', 'List Examtype')

<!--@section('content')

@if (session()->has('flash_message'))
<p>{{ session()->get('flash_message') }}</p>
@endif-->

@section('body')
@include('flash')
<!--<style>
    th{
        padding-left:10px;
  
    }
</style>-->

<div class='col-md-offset-1 col-md-10'>
<div class="box box-primary">
    <div class="box-body">


        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 30%">Sl.No</th>
                    <th style="width: 30%">Name</th>
                  
                    <!--<th>Photo</th>-->
                    <th style="width: 5%">Edit</th>
                    <th style="width: 5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $allExamtype as $Examtype )
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $Examtype->name }}</td>
                     
                    <td class=center>
                        <a class="btn btn-primary btn-block" href="{{url('ExamType/'.$Examtype->enc_id).'/edit'}}">Edit</a>
                    </td>
                    
                    <td class=center>
                        {!! Form::open(['route' => ['ExamType.destroy', $Examtype->enc_id], 'method' => 'POST','onsubmit' => 'return ConfirmDelete()'])  !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$Examtype->id}}">
                        <button type="submit" class="btn btn-danger btn-block">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                 <?php $i++ ?>
                @endforeach
            </tbody>

        </table>
    </div>

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
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
@stop
@endsection