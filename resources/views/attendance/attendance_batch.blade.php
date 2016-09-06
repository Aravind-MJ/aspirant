@extends('layouts.layout')

@section('title', 'Attendance of Batch')

@section('body')
    @include('flash')
    <?php
        $weeks = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    ?>
    <div class="box box-primary">
        <div class="box-body">
            <ul class="nav nav-tabs">
            @foreach($months as $month)
              <li <?=($month == $last_month)?'class="active"':''?> ><a data-toggle="tab" href="#{{$month}}">{{$month}}</a></li>
            @endforeach
            </ul>
            <div class="tab-content">
            @foreach($months as $month)
              <div id="{{$month}}" class="tab-pane fade in <?=($month == $last_month)?'active':''?>">
                <?php
                    if(empty($working_days[$month])){
                        echo '<h3>No attendance Available</h3>';
                    } else {
                    ?>
                    <table class="attendance_table table table-bordered text-center">
                        <thead>
                            <tr>
                                <th colspan="7">{{$month}}</th>
                            </tr>
                            <tr>
                                @foreach($weeks as $week)
                                    <th>{{$week}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                    <?
                        $temp = explode('-',$month);
                        $first_date = date_create('1-'.$temp[0].'-'.$temp[1]);
                        $first_day = date_format($first_date,'D');
                        $start_blanks = array_search($first_day,$weeks);
                        $total_days = cal_days_in_month(CAL_GREGORIAN,date_format($first_date,'m'),date_format($first_date,'Y'));
                        for($i=0;$i<$total_days+$start_blanks;$i++){
                            $day = $i-$start_blanks+1;
                            ?>
                                <td
                                <?=(isset($present[$month]) AND array_search($day,$present[$month])>-1)?'class="present"':''?>
                                <?=(isset($absent[$month]) AND array_search($day,$absent[$month])>-1)?'class="absent"':''?>
                                <?=(isset($working_days[$month]) AND array_search($day,$working_days[$month])==false AND $day>0)?'class="holiday"':''?>
                                >
                                <?=($day>0)?$day:''?></td>
                            <?
                            if(($i+1)%7==0){
                                ?>
                                    </tr><tr>
                                <?
                            }
                        }
                        while(($i)%7!=0){
                            ?>
                                <td></td>
                            <?
                            $i++;
                        }

                    ?>      </tr>
                        </tbody>
                    </table>
                    <?php
                    }
                ?>
              </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection

@section('pagescript')

@stop