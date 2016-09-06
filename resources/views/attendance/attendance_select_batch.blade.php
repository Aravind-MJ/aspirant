@extends('layouts.layout')

@section('title', 'Attendance by Batch')

@section('body')

    @include('flash')

<style>
    .app-section .btn-app strong{
        font-size: 17px;
        text-align: center;
    }
</style>
        <div class="box box-primary">
        <?php
            foreach($time_shift as $each_shift){
            ?>
        <div class="box-header">
            <div class="box-title"><strong><i class="fa fa-clock-o"></i> &nbsp; Time Shift : <?= ucwords($each_shift)?></strong></div>
        </div>
        <div class="box-body">
        <div class="app-section">
            <?php
                foreach ($batch as $each_batch) {
                    if($each_batch['time_shift']==$each_shift){
                ?>
                    <a class="btn btn-app box_batch" href="{{url('attendance/batch/'.$each_batch['enc_id'])}}">
                        <i class="fa fa-folder-open"></i>
                        <strong><?= $each_batch['batch'] ?></strong>
                    </a>
            <?php
                }
                }
                ?>
                </div>
                </div>
                <?php
            }
            ?>
        </div>
@endsection

@section('pagescript')

@stop