@extends('layouts.layout')

@section('title', 'Batch attendance')

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
                                <div class="box-title text-center"><h2>Attendance</h2></div>
                                 </div>
                            <div class="box-body">
                                <div class="row">
                                    <?php
                                        $i = 1;
                                        foreach ($data as $enc_id => $each_student) {
                                    ?>
                                    <div class="col-lg-3">
                                    <a href="{{url('attendance/student/'.$enc_id)}}">
                                        @if($each_student->status == 'present')
                                            <div class="selector box box-success selector-present text-center">
                                        @else
                                            <div class="selector box box-danger selector-absent text-center">
                                        @endif
                                            <strong>
                                                <?php echo $i; ?>
                                                <br><i class="fa student_icon fa-user"></i> &nbsp;
                                                <?php echo $each_student->name; ?>
                                            </strong>
                                        </div>
                                    </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </a>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                </div>

@endsection

@section('pagescript')
@stop