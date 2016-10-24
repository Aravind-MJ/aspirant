

@extends('layouts.layout')

@section('title', 'Select student progresscard')

@section('content')

@section('body')
@include('flash')
<div class='col-md-offset-1 col-md-9'>
<div class="box box-primary">
    <div class="box-body">
        <?php  $selbatch = isset($selbatch)? $selbatch : null;?>
         <div class="form-group">
       {!! Form::open(array('route' => 'search.Progresscard', 'method'=>'get')) !!}
        @if(isset($batch))
        @if(!empty($batch))
          </div>  
        <div class="form-group">
        {!! Form::select('param1', $batch,$selbatch, array('placeholder' => 'Please select batch','class' => 'form-control')) !!}
           </div> 
          <div class="form-group">
  {!! Form::text('param2', null, array('class'=>'form-control', 'placeholder'=>'Search for student...')) !!}
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}
        {!! Form::close() !!}
        @endif
        @endif
         </div>  
        </div>
</div>
    
    <div class="box box-primary">
         <div class="box-body">
       @if (count($allStudents) === 0)
        <h4><strong> No Progresscard Found! </strong></h4>
        @elseif (count($allStudents) >= 1)
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    
                    <th>Full name</th>
                    <th>Exam_Type</th>
                    <th>Exam_Date</th>
                    <th>Subjects</th>
                    <th>TotalMark</th>
                 
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $allStudents as $student )
                <tr>
                    <td>{{  $student->first_name}} {{$student->last_name }} </td>
                     <td>{{ $student->name}}</td>
                     <td>{{ $student->exam_date }}</td>
                     <td>{{ $student->subject}}</td>
                     <td>{{ $student->mark }}</td>
                     
                 
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </div>

</div>


@section('confirmDelete')
<script>
    $(".delete").on("submit", function () {
        return confirm("Do you want to delete this item?");
    });
</script>
@stop
@section('dataTable')
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": false,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
@stop
@endsection