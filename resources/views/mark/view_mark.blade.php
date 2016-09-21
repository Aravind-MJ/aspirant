@extends('layouts.layout')

@section('title', 'View Mark')

@section('body')

@include('flash')

<style>
    .app-section .btn-app strong{
        font-size: 17px;
        text-align: center;
    }
</style>
<div class="box box-warning">
            <div class="box-header">
                <div class="box-title">Select Batch and Exam</div>
            </div>
            <div class="box-body">
                {!! Form::open() !!}
                <div class="form-group col-lg-7 col-md-7">
                <label for="batch">Select Batch</label>
                {!! Form::select('batch',$batch,'0',array('class'=>'form-control select-batch')) !!}
                </div>
                <div class="form-group col-lg-7 col-md-7">
                <label for="batch">Select Exam</label>
                {!! Form::select('exam-id',$exam,'0',array('class'=>'form-control exam-id')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title"><strong>Students</strong></div>
    </div>
    <div class="box-body">
        <div class="app-section">
            <h4>Select a Batch to view Students</h4>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
    <script>
    $(document).ready(function(){
        function process(){
            var id = $('.select-batch').val();
            var examId = $('.exam-id').val();
            $('.loading-screen').show();
            $.post('{{url('fetchMark')}}',{
                id:id,
                exam_id:examId
            },
            function(response){
                $('.app-section').html(response);
                var val = $('.exam-id').val();
                $('.exam_id').attr('value',val);
                $('.loading-screen').hide();
            });
        }
        $('.select-batch').val('0');

        $('.select-batch').change(function(){
            process();
        });

        $('.exam-id').change(function(){
            process();
        });

        $('.exam-id').change(function(){
            var val = $('.exam-id').val();
            $('.exam_id').attr('value',val);
        });
    });
    </script>
@stop