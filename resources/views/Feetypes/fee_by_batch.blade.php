

@extends('layouts.layout')

@section('title', 'Select Fee by batch')

@section('content')

@section('body')
@include('flash')
<div class='col-md-offset-1 col-md-9'>
<div class="box box-primary">
    <div class="box-body">
        <?php  $selbatch = isset($selbatch)? $selbatch : null;?>
         <div class="form-group">
       {!! Form::open(array('route' => 'search.fees', 'method'=>'get')) !!}
        @if(isset($batch))
        @if(!empty($batch))
          </div>  
        <div class="form-group">
        {!! Form::select('param1', $batch,$selbatch, array('placeholder' => 'Please select batch','class' => 'form-control')) !!}
           </div> 
          <div class="form-group">
<!--  {!! Form::text('param2', null, array('class'=>'form-control', 'placeholder'=>'Search for student...')) !!}-->
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
        <h4><strong> No Students Found! </strong></h4>
        @elseif (count($allStudents) >= 1)
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Full name</th>
                    <th>TotalFee</th>
                    <th>First_Installment</th>
                   <th>Second_Installment</th>  
                    <th>Third_Installment</th>  
                    <th>Discount</th>
                     <th>Balance</th>
<!--                    <th>Discount</th>
                    <th>Balance</th>-->
<!--                    <th>View more</th>-->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $allStudents as $student )
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $student->first_name}} {{$student->last_name }} </td>
                    <td class= btn btn-primary btn-block> {{ $student ->total_fee }}                     
                                             </td>
                   <td>{{ $student->first }}</td>
                    <td>{{ $student->second }}</td>
                     <td>{{ $student->third }}</td>
                      <td>{{ $student->discount }}</td>
                       <td>{{ $student->balance }}</td>

                    
                    <td class=center>                      
                        <a href='Feebybatch/{{ $student->enc_id }}/edit' class='btn btn-primary btn-block'>Payment details</a>
                    </td> 
                    <td class=center>
                        {!! Form::open(['action' => ['FeebybatchController@destroy', $student->enc_id], 'method' => 'POST', 'class' => 'delete']) !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$student->id}}">
                        <button type="submit" class="btn btn-danger btn-block">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </div>
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