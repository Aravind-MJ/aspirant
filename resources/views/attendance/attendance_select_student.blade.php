@extends('layouts.layout')

@section('title', 'Attendance by Student')

@section('body')

    @if (session()->has('flash_message'))
            @include('session_flash')
        @else

    <style>
        .app-section .btn-app strong{
            font-size: 17px;
            text-align: center;
        }
    </style>
        <div class="box box-warning">
            <div class="box-header">
                <div class="box-title">Select Batch</div>
            </div>
            <div class="box-body">
                {!! Form::open(['route' => 'attendance.student']) !!}
                <div class="form-group col-lg-7 col-md-7">
                {!! Form::select('batch',$batch,$selected['batch'],array('class'=>'form-control')) !!}
                </div>
                {!! Form::submit('Filter',array('class'=>'btn btn-primary col-lg-1 col-md-1')) !!}
                {!! Form::close() !!}
            </div>
        </div>
            <div class="box box-primary">
            <div class="box-header">
                <div class="box-title"><strong>Batch</strong></div>
            </div>
            <div class="box-body">
            <div class="app-section">
                <?php
                    foreach ($students as $enc_id => $each_student) {
                    ?>
                        <a class="btn btn-app box_batch" href="{{url('attendance/student/'.$enc_id)}}">
                            <i class="fa fa-folder-open"></i>
                            <strong><?= $each_student['name'] ?></strong>
                        </a>
                <?php
                    }
                    ?>
                    </div>
                    </div>
            </div>
        @endif
@endsection

@section('pagescript')

@stop