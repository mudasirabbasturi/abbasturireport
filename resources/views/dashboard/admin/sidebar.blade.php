<div id="left-sidebar" class="sidebar border">
    <div class="">
        <div class="user-account">
            <img src="{{ asset('images/users/' . Auth::user()->profile_picture) }}"
                class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                    <strong>{{ Auth::user()->full_name }}</strong></a>

                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{ route('employee.show', Auth::user()->id) }}"><i class="icon-user"></i>My Profile</a></li>
                    <!-- <li><a href="#"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li> -->
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                        <i class="icon-power"></i>{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <hr>
            <ul class="row list-unstyled">
                <li class="col-4">
                    <small>Sales</small>
                    <h6>{{ $ProjectDeliverCount }}</h6>
                </li>
                <li class="col-4">
                    <small>Order</small>
                    <h6>{{ $ProjectCount }}</h6>
                </li>
                <li class="col-4">
                    <small>Revenue</small>
                    <h6>$0</h6>
                </li>
            </ul>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        <li>
                            <a href="/admin"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        {{-- <li class="@if(Request::is('admin') || Request::is('admin/project/*') || Request::is('admin/projects/*') || Request::is('admin/project')) active @endif"> --}}
                        <li class="@if(Request::is('admin/projects/*') || Request::is('admin/project')) active @endif">
                            <a href="#projects" class="has-arrow"><i class="fa fa-plane"></i>
                                <span>Projects</span></a>
                            <ul>
                                <li class="@if(Request::is('admin/project')) active @endif">
                                    <a href="{{ route('project.index') }}">
                                        Projects 
                                        <sup class="text-primary">
                                            <b>{{ $ProjectCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                                <li class="@if(Request::is('admin/project/create')) active @endif">
                                    <a href="{{ route('project.create') }}">Add Project</a>
                                </li>
                                <li class="@if(Request::is('admin/project/project-view')) d-block active @else d-none @endif">
                                    <a href="#">View Project</a>
                                </li>
                                <li class="@if(Request::is('admin/project/edit-project')) d-block active @else d-none @endif">
                                    <a href="#">Edit Project</a>
                                </li>
                                <li class="@if(Request::is('admin/projects/pending')) active @endif">
                                    <a href="{{ route('project.pending') }}">
                                        Pending 
                                        <sup style="color: #e37300;">
                                            <b>{{ $ProjectPendingCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('admin/projects/current-progress')) active @endif">
                                    <a href="{{ route('admin.current.progress') }}">
                                        Current Progress
                                        <sup style="color: #399902;">
                                            <b>{{ $ProjectCurrentCount }}</b>
                                        </sup>
                                    </a>
                                </li>
                                <li class="@if(Request::is('admin/projects/take-of-on-progress')) active @endif">
                                    <a href="{{ route('project.progress') }}">
                                       Takeoff On Progress 
                                        <sup class="text-primary">
                                            <b>{{ $ProjectTakeOfOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('admin/projects/pricing-on-progress')) active @endif">
                                    <a href="{{ route('project.pricingProgress') }}">
                                       Pricing On Progress 
                                        <sup class="text-primary">
                                            <b>{{ $ProjectPricingOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                                <li class="@if(Request::is('admin/projects/completed')) active @endif">
                                    <a href="{{ route('project.completed') }}">
                                        Completed 
                                        <sup class="text-info">
                                            <b>{{ $ProjectCompletedCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('admin/projects/hold')) active @endif">
                                    <a href="{{ route('project.hold') }}">
                                        Hold.
                                        <sup class="text-danger">
                                            <b>{{ $ProjectHoldCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('admin/projects/revision')) active @endif">
                                    <a href="{{ route('project.revision') }}">
                                        Revision. 
                                        <sup class="text-danger">
                                            <b>{{ $ProjectRevisionCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('admin/projects/deliver')) active @endif">
                                <a href="{{ route('project.deliver') }}">
                                    Deliver 
                                    <sup class="text-success">
                                        <b>{{ $ProjectDeliverCount }}</b>
                                    </sup>
                                </a>
                           </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/filter/*') || Request::is('admin/filter') || Request::is('admin/filterData')) active @endif">
                            <a href="#filter" class="has-arrow"><i class="fa fa-filter"></i>
                                <span>Filter</span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('admin/filter')) active @endif">
                                    <a href="{{ route('project.adminFilter') }}">
                                        <span>Filter Project Data</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/userfilter/*') || Request::is('admin/userfilter')) active @endif">
                            <a href="#userfilter" class="has-arrow"><i class="fa fa-filter"></i>
                                <span>Filter </span><i class="icon-users"></i>
                            </a>
                            <ul>
                                @foreach ($AllUsers as $usersingle)
                                    <li class="@if(Request::is('admin/userfilter/' . $usersingle->id)) active @endif">
                                        <a href="{{ route('project.adminFilter.user', $usersingle->id) }}">
                                            <span>{{ $usersingle->full_name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/employee/*') || Request::is('admin/employee')) active @endif">
                            <a href="#Employee" class="has-arrow"><i class="icon-users"></i>
                                <span>Employee</span></a>
                            <ul>
                                <li class="@if(Request::is('admin/employee')) active @endif">
                                    <a href="{{ route('adminEmployeeIndex') }}">Employee</a></li>
                                <li class="@if(Request::is('admin/employee/create')) active @endif">
                                    <a href="{{ route('employee.create') }}">Add Employee</a></li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/client/*') || Request::is('admin/client')) active @endif">
                            <a href="#Client" class="has-arrow"><i class="icon-users"></i>
                                <span>Clients</span></a>
                            <ul>
                                <li class="@if(Request::is('admin/client')) active @endif">
                                    <a href="{{ route('admin.clients') }}">Clients</a></li>
                                <li class="@if(Request::is('admin/client/create')) active @endif">
                                    <a href="{{ route('admin.client.create') }}">Add Client</a></li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/notifications/*') || Request::is('admin/notifications')) active @endif">
                            <a href="#notification" class="has-arrow"><i class="icon-bell"></i>
                                <span>
                                    Notification
                                    <sup>
                                        <b class="text-primary" style="font-size: 10px;">
                                            <span id="sidebar-notification-count">{{$NotificationsCount}}</span>
                                            <sup>
                                                <b class="text-info" style="font-size: 12px;">
                                                    <span id="sidebar-notification-count-new">{{$NotificationsCountNew}}</span>
                                                    <sup>
                                                        <b class="text-danger" style="font-size: 14px;">
                                                            <span id="sidebar-notification-count-new-tome">{{$NotificationsCountNewToMe}}</span>
                                                        </b>
                                                    </sup>
                                                </b>
                                            </sup>
                                        </b>
                                    </sup>
                                </span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('admin/notifications')) active @endif">
                                    <a href="{{ route('admin.notifications') }}">
                                        <span>
                                            All Notification
                                            <sup><b class="text-primary" id="sidebar-notification-count-sub">{{ $NotificationsCount }}</b></sup>
                                        </span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('admin/notifications/new')) active @endif">
                                    <a href="{{ route('admin.notifications.new') }}">
                                        <span>
                                            Notification:
                                            <sup>New: <b class="text-info" id="sidebar-notification-count-new-sub">{{ $NotificationsCountNew }}</b></sup>
                                        </span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('admin/notifications/new/to-me')) active @endif">
                                    <a href="{{ route('admin.notifications.NewToMe') }}">
                                        <span>
                                            Notifi,, To Me
                                            <sup>New: <b class="text-danger" id="sidebar-notification-count-new-tome-sub">{{ $NotificationsCountNewToMe }}</b></sup>
                                        </span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('admin/notifications/create')) active @endif">
                                    <a href="{{ route('admin.notification.send') }}">
                                        <span>Send Notification</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/chart/*') || Request::is('admin/chart')) active @endif">
                            <a href="#Chart" class="has-arrow"><i class="icon-bar-chart"></i>
                                <span>Chart</span></a>
                            <ul>
                                <li class="@if(Request::is('admin/chart')) active @endif">
                                    <a href="{{ route('admin.chart') }}">Chart</a></li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/calender/*') || Request::is('admin/calender')) active @endif">
                            <a href="#calender" class="has-arrow"><i class="icon-calendar"></i>
                                <span>Calender</span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('admin/calender')) active @endif">
                                    <a href="{{ route('admin.calender') }}">
                                        <span>Event calender</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('admin/payroll/*') || Request::is('admin/payroll')) active @endif">
                            <a href="#payroll" class="has-arrow"><i class="fa fa-book"></i>
                                <span>Pay Roll.</span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('admin/payroll')) active @endif">
                                    <a href="{{ route("payroll.index") }}">
                                        <span>Employee Salary.</span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('admin/payroll/create')) active @endif">
                                    <a href="{{ route("payroll.create") }}">
                                        <span>Pay Salary.</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      function updateNotificationCountSidebar() {
        var xhr = new XMLHttpRequest()
        var URL = "{{ route('admin.notifications.count') }}"
        xhr.open('GET', URL, true)
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText)
            document.getElementById('sidebar-notification-count').textContent = response.count
            document.getElementById('sidebar-notification-count-sub').textContent = response.count
            document.getElementById('sidebar-notification-count-new').textContent = response.countNew
            document.getElementById('sidebar-notification-count-new-sub').textContent = response.countNew
            document.getElementById('sidebar-notification-count-new-tome').textContent = response.countNewToMe
            document.getElementById('sidebar-notification-count-new-tome-sub').textContent = response.countNewToMe
          }
        };
        xhr.send();
      }
    
      updateNotificationCountSidebar();
      setInterval(updateNotificationCountSidebar, 5000);
    });
        
    </script>