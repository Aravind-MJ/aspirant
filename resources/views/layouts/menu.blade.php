<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ set_active('faculty') }}{{ set_active('admin') }}{{ set_active('sadmin') }}">
                <a href="/">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @if($user->inRole('superadmin'))
            <li class="treeview {{ set_active('create/admin') }}{{ set_active('list/admins') }}">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Admin</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('create/admin') }}"><i class="fa fa-circle-o"></i>Add admin</a></li>
                    <li><a href="{{ url('list/admins') }}"><i class="fa fa-circle-o"></i>List admin</a></li>
                </ul>
            </li>
            @endif
           @if($user->inRole('superadmin')||$user->inRole('admins'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Faculty</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('Faculty.create')}}"><i class="fa fa-circle-o"></i> Add Faculty</a></li>
                    <li><a href="{{URL::route('Faculty.index')}}"><i class="fa fa-circle-o"></i> List Faculty</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-slideshare"></i>
                    <span>Student Registration</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ action("StudentController@create") }}"><i class="fa fa-circle-o"></i> Add Student</a></li>
                    <li><a href="{{ action("StudentController@index") }}"><i class="fa fa-circle-o"></i> List Students</a></li>
                </ul>
            </li>
            @endif
            @if($user->inRole('users'))
            <li><a href="{{URL::route('notice.getNotice')}}"><i class="fa fa-bell"></i> List Notice</a></li>
            @endif
            @if($user->inRole('superadmin')||$user->inRole('admins'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span>Notice</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('Notice.create')}}"><i class="fa fa-circle-o"></i> Add Notice</a></li>
                    <li><a href="{{URL::route('Notice.index')}}"><i class="fa fa-circle-o"></i> List Notice</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Examtype</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('ExamType.create')}}"><i class="fa fa-circle-o"></i> Add Examtype</a></li>
                    <li><a href="{{URL::route('ExamType.index')}}"><i class="fa fa-circle-o"></i> List Examtype</a></li>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text-o"></i>
                    <span>ExamDetails</span>
                    <span class="pull-right-container">
                        <span class="fa fa-angle-left pull-right"></span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('ExamDetails.create')}}"><i class="fa fa-circle-o"></i> Add ExamDetails</a></li>
                    <li><a href="{{URL::route('ExamDetails.index')}}"><i class="fa fa-circle-o"></i> List ExamDetails</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-twitch"></i>
                    <span>FeeTypes</span>
                    <span class="pull-right-container">
                        <span class="fa fa-angle-left pull-right"></span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('FeeTypes.create')}}"><i class="fa fa-circle-o"></i> Add FeeTypes</a></li>
                    <li><a href="{{URL::route('FeeTypes.index')}}"><i class="fa fa-circle-o"></i> ListFeeTypes</a></li>
<!--                     <li><a href="{{URL::route('Feebybatch.index')}}"><i class="fa fa-circle-o"></i> jhjkd</a></li>-->
                     <li><a href="{{ action("FeebybatchController@index") }}"><i class="fa fa-circle-o"></i> Fee By Batch</a></li>
                </ul>
            </li>
            
             <li class="treeview">
                <a href="#">
                    <i class="fa fa-twitch"></i>
                    <span>FeeDetails</span>
                    <span class="pull-right-container">
                        <span class="fa fa-angle-left pull-right"></span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('Feedetails.create')}}"><i class="fa fa-circle-o"></i> Add FeeDetails</a></li>
                    <li><a href="{{URL::route('Feedetails.index')}}"><i class="fa fa-circle-o"></i> ListFeeDetails</a></li>
<!--                     <li><a href="{{URL::route('Feebybatch.index')}}"><i class="fa fa-circle-o"></i> jhjkd</a></li>-->
                   
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>ProgressCard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{ action("StudentprogresscardController@index") }}"><i class="fa fa-circle-o"></i> Progresscard</a></li>
                   
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-delicious"></i>
                    <span>Batch Details</span>
                    <span class="pull-right-container">
                        <span class="fa fa-angle-left pull-right"></span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('BatchDetails.create')}}"><i class="fa fa-circle-o"></i> Add BatchDetails</a></li>
                    <li><a href="{{URL::route('BatchDetails.index')}}"><i class="fa fa-circle-o"></i> List BatchDetails</a></li>
                </ul>
            </li>
            @endif
            @if($user->inRole('users'))
                <li><a href="{{ url('attendance/student/'.\App\Encrypt::encrypt($user->id)) }}">
                    <i class="fa fa-files-o"></i> View Attendance</a>
                </li>
            @else
                @if($user->inRole('faculty'))
                <li><a href="{{ url('Search') }}">
                    <i class="fa fa-files-o"></i> Search Students</a>
                </li>
                @endif
                <li class="treeview {{ set_active('attendance') }}{{ set_active('mark/attendance') }}">
                    <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Attendance</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                    </a>
                    <ul class="treeview-menu">
                            <li><a href="{{ url('attendance/mark') }}"><i class="fa fa-circle-o"></i> Mark Attendance</a></li>
                            <li><a href="{{ url('attendance/batch') }}"><i class="fa fa-circle-o"></i> Attendance By Batch</a></li>
                            <li><a href="{{ url('attendance/student') }}"><i class="fa fa-circle-o"></i> Attendance By Students</a></li>
                            @if(!$user->inRole('faculty'))
                                <li><a href="{{ url('edit/attendance') }}"><i class="fa fa-circle-o"></i> Edit Attendance</a></li>
                            @endif
                    </ul>
                </li>
            @endif
                @if(!$user->inRole('users'))
                <li class="treeview {{ set_active('mark') }}">
                    <a href="#">
                        <i class="fa fa-sliders"></i>
                        <span>Marks</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{URL::route('mark.create')}}"><i class="fa fa-circle-o"></i> Add Mark</a></li>
                        <li><a href="{{URL::route('mark.index')}}"><i class="fa fa-circle-o"></i> View Mark</a></li>
                    </ul>
                </li>
                @else
                    <li><a href="{{url('Marks')}}"><i class="fa fa-sliders"></i>Marks</a></li>
                @endif
                @if(!$user->inRole('users')&&!$user->inRole('faculty'))
                    <li class="treeview {{ set_active('SendAnSms') }}">
                        <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span>SMS</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ set_active('SendAnSms/students') }}"><a href="{{ url('SendAnSms/students') }}"><i class="fa fa-circle-o"></i> Sms Students</a></li>
                        <li class="{{ set_active('SendAnSms/batches') }}"><a href="{{ url('SendAnSms/batches') }}"><i class="fa fa-circle-o"></i> Sms Batch</a></li>
                        <li class="{{ set_active('SendAnSms/faculty') }}"><a href="{{ url('SendAnSms/faculty') }}"><i class="fa fa-circle-o"></i> Sms Faculty</a></li>
                        <li class="{{ set_active('SmsHistory') }}"><a href="{{ url('SmsHistory') }}"><i class="fa fa-circle-o"></i> Sms History</a></li>
                    </ul>
                </li>
                @endif
            <li class="header">Settings</li>
            <li><a href="{{url('changePassword/'. \App\Encrypt::encrypt($user->id))}}"><i class="fa fa-circle-o text-orange"></i> <span>Change Password</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->