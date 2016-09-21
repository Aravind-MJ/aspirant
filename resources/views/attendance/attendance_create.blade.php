@extends('layouts.layout')

@section('title', 'Mark Attendance')

@section('body')

            @include('flash')
    <style>
            .box-body{
                margin-top: 50px;
                padding: 30px;
            }
            
        </style>
                <br>
                <div class="row">
                    <div class="failed-message" hidden>
                        <div class="callout callout-danger" style="margin-bottom: 5px !important;">
                            <h4>
                                <i class="fa fa-info"></i>
                                Failed...!
                            </h4>
                            Something Went wrong. Please try again...<br>If the problem persists Contact us.<br><br>
                        </div>
                    </div>
                    <div class="success-message" hidden>
                        <div class="callout callout-success" style="margin-bottom: 5px !important;">
                            <h4>
                                <i class="fa fa-info"></i>
                                Success...
                            </h4>
                            The Attendance is successfully Updated.<br>Please wait you will be redirected soon...<br><br>
                        </div>
                    </div>
                        <div class="box box-warning">
                            <div>
                                <div class="box-title text-center"><h2> Mark Attendance</h2></div>
                                 </div>
                            <div class="box-body">
                                <div class="row">
                                    <?php
                                        $i = 1;
                                        foreach ($students as $enc_id => $each_student) {
                                    ?>
                                    <div class="col-lg-3">
                                        <div class="selector box box-success selector-present text-center">
                                            <input class="roll" value="<?php echo $enc_id; ?>" hidden>
                                            <strong>
                                                <?php echo $i; ?>
                                                <br><i class="fa student_icon fa-user"></i> &nbsp;
                                                <?php echo $each_student['name']; ?>
                                            </strong>
                                        </div>
                                    </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-lg btn-warning submit-button" id="mark">
                                        Submit &nbsp;
                                        <i class="fa fa-paper-plane" style="font-size:14px"></i>
                                    </a>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                </div>

@endsection

@section('pagescript')
<script>
    $(function () {
                    var present = [];
                    $(".selector").click(function () {
                        $(this).toggleClass('box-danger box-success selector-present selector-absent');
                    });

                    $(".submit-button").click(function(){
                        var id = '{{$id}}';
                        $('.selector-present').each(function(){
                            present.push($(this).children('.roll').val());
                        });
                        $('.loading-screen').show();
                        $.post('{{url('attendance/mark')}}',{
                            id:id,
                            present:present
                        },
                        function(response){
                            if(response=='success'){
                                $('.loading-screen').hide();
                                $('.box.box-warning').hide();
                                $('.success-message').show();
                                setTimeout(function(){
                                    window.location.href='{{url('attendance/mark')}}';
                                },2000);
                            } else {
                                $('.box.box-warning').hide();
                                $('.failed-message').show();
                                setTimeout(function(){
                                    window.location.href='{{url('attendance/mark')}}';
                                },2000);
                            }
                        });
                        absent = [];
                    });
                });
           </script>
@stop