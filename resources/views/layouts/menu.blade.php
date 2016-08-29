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
            <li class="treeview {{ set_active('faculty') }}{{ set_active('admin') }}{{ set_active('sadmin') }}">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                </ul>
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
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Faculty</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">2</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('addFaculty')}}"><i class="fa fa-circle-o"></i> Add Faculty</a></li>
                    <li><a href="{{URL::route('listFaculty')}}"><i class="fa fa-circle-o"></i> List Faculty</a></li>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Examtype</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">2</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::route('addExamtype')}}"><i class="fa fa-circle-o"></i> Add Examtype</a></li>
                    <li><a href="{{URL::route('listExamtype')}}"><i class="fa fa-circle-o"></i> List Examtype</a></li>
                </ul>
            </li>
            
            
                <li class="treeview {{ set_active('attendance') }}{{ set_active('mark/attendance') }}">
                    <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Attendance</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->inRole('faculty'))
                            <li><a href="{{ url('mark/attendance') }}"><i class="fa fa-circle-o"></i> Mark Attendance</a></li>
                        @endif
                        <li><a href="{{ url('attendance/batch') }}"><i class="fa fa-circle-o"></i> Attendance By Batch</a></li>
                        <li><a href="{{ url('attendance/student') }}"><i class="fa fa-circle-o"></i> Attendance By Students</a></li>
                    </ul>
                </li>
            <li class="header">Settings</li>
            <li><a href="{{url('changePassword/'. \App\Encrypt::encrypt($user->id))}}"><i class="fa fa-circle-o text-orange"></i> <span>Change Password</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->