
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset("/bower_components/admin-lte/dist/img/avatar04.png") }}" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>{{Session::get('uName')}}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- search form (Optional) -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
                    </div>
                </form>
                <!-- /.search form -->

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                    <!-- <li class="header">HEADER</li> -->
                    <!-- Optionally, you can add icons to the links -->
                    <!-- <li class="active"><a href="#"><span>Link</span></a></li>
                    <li><a href="#"><span>Another Link</span></a></li> -->
                    <li class="treeview">
                        <?php $userAccess = Session::get('userAccess'); ?>
                      @if($userAccess === 'admin' || $userAccess === 'superadmin')  
                        <a href="#"><span>Masters</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('userAccess.index')}}">User Access</a></li>
                            <li><a href="{{route('office.index')}}">Office</a></li>
                            <li><a href="{{route('region.index')}}">Region</a></li>
                            <li><a href="{{route('requestType.index')}}">Request Type</a></li>
                            <li><a href="{{route('containerType.index')}}">Container Type</a></li>
                            <li><a href="{{route('errorType.index')}}">Error Type</a></li>
                            <li><a href="{{route('priorityType.index')}}">Priority Type</a></li>
                            <li><a href="{{route('errorCat.index')}}">Error Category</a></li>
                            <li><a href="{{route('mode.index')}}">Modes</a></li>
                            <li><a href="{{route('holiday.index')}}">Holliday</a></li>
                            <li><a href="{{route('tat.index')}}">TAT</a></li>
                            <li><a href="{{route('statusCat.index')}}">Status Category</a></li>
                            <li><a href="{{route('status.index')}}">Status</a></li>
                            <li><a href="{{route('rfiType.index')}}">RFI Type</a></li>
                            <li><a href="{{route('commodity.index')}}">Commodity</a></li>
                        </ul>
                      @endif  
                        <a href="{{route('indexing.create')}}"><span>Indexing</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <a href="{{route('publishing.index')}}"><span>Publishing</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <a href="{{route('auditing.index')}}"><span>Auditing</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <a href="{{route('rfi.view')}}"><span>RFI Queue</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <a href="{{route('completed.view')}}"><span>Completed Queue</span> <i class="fa fa-angle-left pull-right"></i></a>
                    </li>
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>