@extends('layouts.layout')

@section('title', 'List Student')

@section('content')

@section('body')
@include('flash')
<!--<div class='col-md-offset-1 col-md-9'>-->
<div class="box box-primary">
    <div class="box-body">

        {!! Form::open(array('route' => 'search.queries', 'class'=>'form navbar-form navbar-right searchform', 'method'=>'get')) !!}
        @if(isset($batch))
        @if(!empty($batch))
        {!! Form::select('param1', $batch, null, array('placeholder' => 'Please select batch','class' => 'form-control')) !!}
        @endif
        @endif
        {!! Form::text('param2', null, array('class'=>'form-control', 'placeholder'=>'Search for student...')) !!}
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}
        {!! Form::close() !!}

        @if (count($allStudents) === 0)
        <h4><strong> No Students Found! </strong></h4>
        @elseif (count($allStudents) >= 1)
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Full name</th>
                    <th>Batch</th>
                    <th>DOB</th>                   
                    <th>Photo</th>
                    <th>View more</th>
                    <th>Attendance</th>
                    <th>Marks</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach( $allStudents as $student )
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name}}</td>
                    <td>{{ $student->batch }}</td>
                    <td>{{ $student->dob }}</td>
                    <td><img src="{{ asset('images/students/'. $student->photo) }}"  alt="photo" width="50" height="50"/></td>
                    <td class=center>                      
                        <a href='Student/{{ $student->enc_id }}'>View more</a>
                    </td>
                    <td class=center>                      
                        <a href='attendance/student/{{ $student->enc_userid }}' class='btn btn-primary btn-block'>Attendance</a>
                    </td>
                    <td class=center>                      
                        <a href='mark/{{ $student->enc_userid }}' class='btn btn-primary btn-block'>Mark</a>
                    </td>
                    <td class=center>                      
                        <a href='Student/{{ $student->enc_id }}/edit' class='btn btn-primary btn-block'>Edit</a>
                    </td> 
                    <td class=center>
                        {!! Form::open(['action' => ['StudentController@destroy', $student->enc_id], 'method' => 'POST', 'class' => 'delete']) !!}
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