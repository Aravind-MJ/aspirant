@extends('layouts.layout')

@section('title', $title)

@section('body')

    @include('flash')

    <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$count['users']}}</h3>

                  <p>Students</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$count['faculty']}}</h3>

                  <p>Faculties</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$count['admins']}}</h3>

                  <p>Admins</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-secret"></i>
                </div>
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
              </div>
            </div>
          </div>

@endsection