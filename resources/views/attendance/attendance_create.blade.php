@extends('layouts.layout')

@section('title', 'Mark Attendance')

@section('body')

    @if (isset($flash_message))
            @include('flash')
    @else
    <style>
            .box-body{
                margin-top: 50px;
                padding: 30px;
            }
            .selector-present{
                height:60px;
                border: 1px solid green;
                padding-top:10px;
                margin:10px;
                display : inline-block;
                background-color: lightgreen;
                cursor: pointer;
            }
            .selector-absent{
                height:60px;
                border: 1px solid red;
                padding-top:10px;
                margin:10px;
                display : inline-block;
                background-color: lightcoral;
                color:white;
                cursor: pointer;
            }
            #mark{
                width:300px;
                margin-top: 40px;
            }
        </style>
                <br>
                <div class="row">
                    <div class="error-message" hidden>
                        <div class="callout callout-danger" style="margin-bottom: 0 !important;">
                            <h4>
                                <i class="fa fa-info"></i>
                                Failed...!
                            </h4>
                            Something Went wrong. Please try again...<br>If the problem persists Contact us.<br><br>
                        </div>
                    </div>
                    <div class="success-message" hidden>
                        <div class="callout callout-success" style="margin-bottom: 0 !important;">
                            <h4>
                                <i class="fa fa-info"></i>
                                Success...
                            </h4>
                            The Attendance is successfully Updated.<br>Please wait you will be redirected soon...<br><br>
                        </div>
                    </div>
                        <div class="box box-warning">
                            <div>
                                <div class="box-title text-center"><h2>MARK ATTENDANCE</h2></div>
                                 </div>
                            <div class="box-body">
                                <div class="row">
                                    <?php
                                    $i = 1;
                                    $data = array(
                                        'student1','student2'
                                    );
                                    foreach ($data as $student) {
                                        ?>
                                    <div class="col-lg-3">
                                        <div class="selector box box-success selector-present text-center" value="<?php echo $student; ?>">
                                            <strong>
                                                <?php echo $i; ?>
                                                <br>
                                                <?php echo $student; ?>
                                            </strong>
                                        </div>
                                    </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                                <center>
                                    <a class="btn btn-lg btn-warning" id="mark">Submit</a>
                                </center>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                </div>

    @endif
@endsection

@section('pagescript')
    $(function () {
                    var absent = [];
                    $(".error-message").hide();
                    $(".success-message").hide();
                    $(".box-info").show();
                    $(".selector").click(function () {
    //                    var id = $(this).attr('value');
    //                    if ($(this).attr("class") === "selector box box-danger selector-absent text-center") {
    //                        $(this).attr('class', 'selector box box-success selector-present text-center');
    //                        for (i = 0; i < absent.length; i++) {
    //                            if (absent[i] === id) {
    //                                absent.splice(i, 1);
    //                            }
    //                        }
    //                    } else {
    //                        $(this).attr('class', 'selector box box-danger selector-absent text-center');
    //                        absent.push(id);
    //                    }
    //                    $("#message").hide();
                        $(this).toggleClass('box-danger box-success selector-present selector-absent');
                    });
                });
@stop