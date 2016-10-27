

@extends('layouts.layout')

@section('title', 'Select student progresscard')

@section('content')

@section('body')
@include('flash')


<head>
	<style>
		
		
		table {
			border: 1px solid #000;
			width:100%;
		}
		
		table tr {
			width:300px;
		}
		
		table tr th {
			text-align:center;
			font-size:20px;
			height: 40px;
			background-color:#fef1e9;
			width:auto;
		}
		
		table tr td {
			background-color:fef1e1;
			text-align:center;
			height: 40px;
			width:auto;
		}
              .outer {
  border: 1px solid #8b8378;
  background-color: #ecf1ef;
  height: 250px;
  padding-top: 10px;
}

.inner {
  background-color: #ecf1ef;
  height: 230px;
  padding-top: 10px;
}

.contentt {
  background-color: #ecf1ef;
  height: 100px;
  padding-top: 10px;
}

.photo {
  background-color: #eef3e2;
  height: 200px;
  width: 200px;
  padding-top: 10px;
  padding-bottom: 10px;
}

.name {
  background-color: #eef3e2;
  color: #000;
  padding-left: 20px;
  height: 50px;
  padding-top: 5px;
  border: 1px solid #c1cdcd;
}

.batch {
  background-color: #eef3e2;
  height: 50px;
  padding-left: 20px;
  color: #000;
  padding-top: 5px;
  border: 1px solid #c1cdcd;
}
                
	</style>
</head>
<div class='col-md-offset-1 col-md-9 boxx'>
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
         <div class="box-body boxx" id='report'>
            @if(count($student)<=0)
                <h4><strong> No Progresscard Found! </strong></h4>
            @else
            <table  id="example2" class="table table-bordered table-hover">
                
                     <tbody> 
                        <div class="box-header">
                            <h2 class="box-title"><strong> Student Progresscard</strong></h2>
                        </div>
                 <div class="col-md-12 outer">

                    <div class="col-md-6 inner">
                        <div class="col-md-12 contentt">
                            <b>Name</b><br><div class="col-md-12 name">
                                <h4>{{ $student ->first_name }} {{ $student->last_name }}</h4>
                            </div>
                        </div>
                        <div class="col-md-12 contentt">
                            <b>Batch</b><br><div class="col-md-12 batch">
                                <h4>{{ $student->batch }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 inner">
                        <b>photo</b><br><div class="col-md-12 photo">
                            <img src="{{ asset('images/students/'. $student->photo) }}" width="100%" height="100%">
                        </div>
                    </div>
                </div>
<!--                        <td><img src="{{ asset('images/students/'. $student->photo) }}" alt="photo" width="50" height="50"/></td>    
                        <tr>
                            <th>Full Name</th>
                            <td>{{ $student ->first_name }} {{ $student->last_name }}</td>
                        </tr>
                       <tr>
                           <th>Batch</th>
                            <td>{{ $student->batch }}</td>
                       </tr>                       -->
                    </tbody>
               
            </table>
         
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Mark Details</h3>
                </div>
                <div class="box-body">
               
                    <table id="example2" class="table table-bordered table-hover"> 
                         
                        <tr>
                            <th rowspan="2">Exam Type</th>
                            <th colspan="{{count($subjects)}}">Subjects</th>
                            <th rowspan="2">Total Mark</th>
                        </tr>                   
                        <tr>
                            @foreach($subjects as $subject)
				<th>{{$subject}}</th>
                            @endforeach
			</tr> 
                        @foreach($marks as $mark)                      
                        <tr>
				<td>{{$mark['name']}}</td>
                                @foreach($subjects as $subject)
                                    @if(isset($mark['marks'][$subject]))
                                    <td>{{$mark['marks'][$subject]->mark}}</td>
                                    @else
                                    <td>No Marks Found</td>
                                    @endif
                                @endforeach
                                <td>{{$mark['total_mark']}}</td>
			</tr>
                        @endforeach
                    </table>
                       <p align="center"><button id="printPage">Print</button></p>
          @endif               
    </div>
    </div>
</div>
    </div>
</div>





@section('confirmDelete')
<script lang='javascript'>
    $(document).ready(function(){
        $('#printPage').click(function(){
            var data = '<input type="button" value="Print this page" onClick="window.print()">';
            data += '<div id="div_print">';
            data += $('#report').html();
            data += '</div>';

            myWindow=window.open('','','width=600,height=300');
            myWindow.innerWidth = screen.width;
            myWindow.innerHeight = screen.height;
            myWindow.screenX = 0;
            myWindow.screenY = 0;
            myWindow.document.write(data);
            myWindow.focus();
        });
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