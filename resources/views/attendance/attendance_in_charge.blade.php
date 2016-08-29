@extends('layouts.layout')

@section('title', 'Choose Batch')

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
        <div class="box box-primary">
        <div class="box-body">
        <div class="app-section">
            <?php
                foreach ($batch as $each_batch) {
                    if($each_batch['status']=='unmarked'){
                ?>
                    <a class="btn btn-app" href="{{url('attendance/'.$each_batch['enc_id'])}}">
                        <i class="fa fa-info text-warning"></i>
                        <strong><?= $each_batch['batch'] ?> - <?= $each_batch['time_shift'] ?></strong>
                    </a>
            <?php
                } else {
                ?>
                    <a class="btn btn-app">
                        <i class="fa fa-check text-success"></i>
                        <strong><?= $each_batch['batch'] ?> - <?= $each_batch['time_shift'] ?></strong>
                    </a>
                <?
                }
                }
                ?>
                </div>
                </div>
        </div>
    @endif
@endsection

@section('pagescript')

@stop