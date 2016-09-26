@extends('layouts.layout')

@section('title', 'Choose Batch')

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
        <div class="box-body">
        <div class="box-header">
            <div class="box-title"><strong><i class="fa fa-clock-o"></i> &nbsp; Time Shift : <?= ucwords($each_shift)?></strong></div>
        </div>
        <div class="app-section">
            <?php
                foreach ($batch as $each_batch) {
                    if($each_batch['time_shift']==$each_shift){
                        if($each_batch['status']=='unmarked'){
                ?>
<<<<<<< Updated upstream
                    <a class="btn btn-app box_batch" href="{{url('attendance/mark/'.$each_batch['enc_id'])}}">
                        <i class="fa fa-info"></i>
=======
                    <a class="btn btn-app box_batch" href="{{url('mark/attendance/'.$each_batch['enc_id'])}}">
                        <i class="fa fa-users"></i>
>>>>>>> Stashed changes
                        <strong><?= $each_batch['batch'] ?></strong>
                    </a>
            <?php
                } else {/*
                ?>
                    <a class="btn btn-app box_batch">
                        <i class="fa fa-check"></i>
                        <strong><?= $each_batch['batch'] ?></strong>
                    </a>
                <?
                        */}
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