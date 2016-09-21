@extends('layouts.layout')

@section('title', 'Attendance of Batch')

@section('body')
    @include('flash')
    <div class="box box-warning">
        <div class="box-header">
            <div class="box-title">Select Date Range</div>
        </div>
        <div class="box-body">
            <div class="input-group col-lg-6 col-md-6">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" id="date_range">
                <span class=".date_range_object"></span>
            </div>
        </div>
    </div>
    <div class="alert alert-danger custom-alert">
        <span class="alert-message"></span>
        <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
    </div>
    <div class="box box-primary chart-box">
        <div class="box-body chart-responsive">
            <div class="chart" id="attendance-chart" style="height: 500px;"></div>
        </div>
    </div>
@endsection

@section('pagescript')
<script>
$(document).ready(function(){
    var id = '{{$id}}';
    var start_date = moment().subtract(6,'days').format('YYYY-MM-DD');
    var end_date = moment().format('YYYY-MM-DD');

    $('.custom-alert').hide();

    function process(response){
        if(response[0] != '{'){
            $('.alert-message').text(response);
            $('.chart-box').hide();
            $('.custom-alert').show();
        } else {
            $('.chart-box').show();
            $('.custom-alert').hide();
            response = JSON.parse(response);
            $('#attendance-chart').html('');
            var line = new Morris.Line(response);
        }
        $('text[text-anchor="middle"]').hide();
    }

    $.post('{{url('rangeAttendance')}}',
    {
        id:id,
        start_date:start_date,
        end_date:end_date
    },
    function(response){
        process(response);
    });
    $('#date_range').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(6, 'days'),
              endDate: moment()
            },
            function (start, end) {
                start = start.format('YYYY-MM-DD');
                end = end.format('YYYY-MM-DD');
                $.post('{{url('rangeAttendance')}}',
                {
                    id:id,
                    start_date:start,
                    end_date:end
                },
                function(response){
                    process(response);
                });
            }
        );

        /*$.post('{{url('rangeAttendance')}}',
        {
            id:id,
            start_date:start,
            end_date:end
        },
        function(response){
            process(response);
        });*/

});
</script>
@stop