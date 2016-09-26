@extends('layouts.layout')

@section('title', 'Student | Mark')

@section('body')
    @include('flash')
    <div class="box box-primary">
        <div class="box-header">
            <div class="box-title">Marks</div>
        </div>
        <div class="box-body">
            <table class="table dataTable stripped">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Mark</th>
                        <th>Exam Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($marks as $each)
                    <tr>
                        <td>{{$each->exam->type}}</td>
                        <td>{{$each->mark}}</td>
                        <td>{{$each->exam->exam_date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection