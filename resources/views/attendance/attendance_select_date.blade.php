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
                    <a class="btn btn-app box_batch" href="{{url('edit/attendance/'.$id.'/'.$key)}}">
                        <i class="fa fa-folder-open"></i>
                        <strong><?= $each_date ?></strong>
                    </a>
            <?php
                }
                ?>
                </div>
                </div>
        </div>
@endsection

@section('pagescript')

@stop