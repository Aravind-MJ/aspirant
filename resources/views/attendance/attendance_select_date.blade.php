@extends('layouts.layout')

@section('title', 'Select Date')

@section('body')

    @include('flash')

<style>
    .app-section .btn-app strong{
        font-size: 17px;
        text-align: center;
    }
</style>
        <div class="box box-primary">
        <div class="box-body">
        <div class="app-section">
            <?php
                foreach ($dates as $key => $each_date) {
                ?>
                    <div class="box_batch">
                       
                        <strong class="box_text"><?= $each_date ?></strong><br>
						<a class="btn edit_form1 btn-warning btn-block" href="{{url('edit/attendance/'.$id.'/'.$key)}}">Edit &nbsp;&nbsp;<i class="fa fa-edit"></i></a>
                        {!! Form::open(['route' => ['attendance.destroy'], 'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::hidden('id',$id) !!}
                        {!! Form::hidden('date',$key) !!}
                        {!! Form::submit('Delete',['class'=>'btn del_form1 btn-danger btn-block']) !!}
                        {!! Form::close() !!}
                    </div>
            <?php
                }
                ?>
                </div>
                </div>
        </div>
@endsection

@section('pagescript')
<script>
function ConfirmDelete()
  {
  var x = confirm("Are you sure you want to delete?");
  if (x)
    return true;
  else
    return false;
  }
</script>
@stop