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
                        <li class="@if(Request::is('/employee')) active @endif">
                            <a href="/employee"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        {{-- @if(Request::is('employee') || Request::is('employee/project') || Request::is('employee/projects/*') active @endif --}}
                        <li class="@if(Request::is('employee/project') || Request::is('employee/projects/*') ) active @endif">
                            <a href="#projects" class="has-arrow"><i class="icon-grid"></i>
                                <span>Projects</span></a>
                            <ul>
                                <li class="@if(Request::is('employee/project')) active @endif">
                                    <a href="{{ route('employeeProjectIndex') }}">
                                        Projects
                                        <sup class="text-primary">
                                            <b>{{ $ProjectCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                                <li class="@if(Request::is('employee/projects/pending')) active @endif">
                                    <a href="{{ route('pending') }}">
                                        Pending
                                        <sup style="color: #e37300;">
                                            <b>{{ $ProjectPendingCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/projects/current-progress')) active @endif">
                                    <a href="{{ route('current.progress') }}">
                                        Current Progress
                                        <sup style="color: #399902;">
                                            <b>{{ $ProjectCurrentCount }}</b>
                                        </sup>
                                    </a>
                                </li>
                                <li class="@if(Request::is('employee/projects/take-of-on-progress')) active @endif">
                                    <a href="{{ route('takeOfOnprogress') }}">
                                        TakeOf On Progress
                                        <sup class="text-primary">
                                            <b>{{ $ProjectTakeOfOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/projects/pricing-on-progress')) active @endif">
                                    <a href="{{ route('pricingOnprogress') }}">
                                        Pricing On Progress
                                        <sup class="text-primary">
                                            <b>{{ $ProjectPricingOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                                <li class="@if(Request::is('employee/projects/completed')) active @endif">
                                    <a href="{{ route('completed') }}">
                                        Completed
                                        <sup class="text-info">
                                            <b>{{ $ProjectCompletedCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/projects/hold')) active @endif">
                                    <a href="{{ route('hold') }}">
                                        Hold
                                        <sup class="text-danger">
                                            <b>{{ $ProjectHoldCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/projects/revision')) active @endif">
                                    <a href="{{ route('revision') }}">
                                        Revision
                                        <sup class="text-danger">
                                            <b>{{ $ProjectRevisionCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('employee/self/projects/*') || Request::is('employee/self/projects')) active @endif">
                            <a href="#{{ Auth::user()->full_name }}" class="has-arrow"><i class="icon-user"></i>
                                <span>{{ Auth::user()->full_name }}</span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('employee/self/projects')) active @endif">
                                    <a href="{{ route('selfProIndex') }}">
                                        Projects
                                        <sup class="text-primary">
                                            <b>{{ $SelfProjectCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                                {{-- <li class="@if(Request::is('employee/self/projects/pending')) active @endif">
                                    <a href="{{ route('selfProPending') }}">
                                        Pending
                                        <sup style="color: #e37300;">
                                            <b>{{ $projectCountPending }}</b>
                                        </sup>
                                    </a>
                               </li> --}}
                                <li class="@if(Request::is('employee/self/projects/take-of-on-progress')) active @endif">
                                    <a href="{{ route('selfProTakeOfonProgress') }}">
                                        TakeOf On Progress
                                        <sup class="text-primary">
                                            <b>{{ $SelfProjectTakeOfOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/self/projects/pricing-on-progress')) active @endif">
                                    <a href="{{ route('selfProPricingOnProgress') }}">
                                        Pricing On Progress
                                        <sup class="text-primary">
                                            <b>{{ $SelfProjectPricingOnProgressCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/self/projects/completed')) active @endif">
                                    <a href="{{ route('selfProCompleted') }}">
                                        Completed
                                        <sup class="text-info">
                                            <b>{{ $SelfProjectCompletedCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/self/projects/hold')) active @endif">
                                    <a href="{{ route('selfProHold') }}">
                                        Hold
                                        <sup class="text-danger">
                                            <b>{{ $SelfProjectHoldCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/self/projects/revision')) active @endif">
                                    <a href="{{ route('selfProRevision') }}">
                                        Revision
                                        <sup class="text-danger">
                                            <b>{{ $SelfProjectRevisionCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                               <li class="@if(Request::is('employee/self/projects/deliver')) active @endif">
                                    <a href="{{ route('selfProDeliver') }}">
                                        Deliver
                                        <sup class="text-info">
                                            <b>{{ $SelfProjectDeliverCount }}</b>
                                        </sup>
                                    </a>
                               </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('employee/notifications/*') || Request::is('employee/notifications/index')) active @endif">
                            <a href="#notification" class="has-arrow"><i class="icon-bell"></i>
                                <span>
                                    Notification
                                    <sup>
                                        <b class="text-warning" style="font-size: 10px;">
                                            <span id="sidebar-notification-count-new">{{ $NotificationsCountNew }}</span>
                                            <sup>
                                                <b class="text-danger" style="font-size: 12px;">
                                                    <span id="sidebar-notification-count-new-tome">{{ $NotificationsCountNewToMe }}</span>
                                                </b>
                                            </sup>
                                        </b>
                                    </sup>
                                </span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('employee/notifications/new')) active @endif">
                                    <a href="{{ route("employee.notifications.new") }}">
                                        <span>
                                            New Notifications
                                            <sup class="text-warning">
                                                <b id="sidebar-notification-count-new-sub">{{ $NotificationsCountNew }}</b>
                                            </sup>
                                        </span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('employee/notifications/new/to-me')) active @endif">
                                    <a href="{{ route('employee.notifications.NewToMe') }}">
                                        <span>
                                            Notifications To Me
                                            <sup class="text-danger">
                                                <b id="sidebar-notification-count-new-tome-sub">{{ $NotificationsCountNewToMe }}</b>
                                            </sup>
                                        </span>
                                    </a>
                                </li>
                                <li class="@if(Request::is('employee/notifications/send')) active @endif">
                                    <a href="{{ route("employee.notification.send") }}">
                                        <span>Send Notification</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if(Request::is('employee/calender/*') || Request::is('employee/calender')) active @endif">
                            <a href="#calender" class="has-arrow"><i class="icon-calendar"></i>
                                <span>Event Calendar</span>
                            </a>
                            <ul>
                                <li class="@if(Request::is('employee/calender')) active @endif">
                                    <a href="{{ route('employee.calender') }}">
                                        <span>Event Calendar</span>
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
      function updateNotificationCountSidebarEmployee() {
        var xhr = new XMLHttpRequest()
        var URL = "{{ route('employee.notifications.count') }}"
        xhr.open('GET', URL, true)
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText)

            document.getElementById('sidebar-notification-count-new').textContent = response.countNew
            document.getElementById('sidebar-notification-count-new-sub').textContent = response.countNew
            document.getElementById('sidebar-notification-count-new-tome').textContent = response.countNewToMe
            document.getElementById('sidebar-notification-count-new-tome-sub').textContent = response.countNewToMe
          }
        };
        xhr.send();
      }
    
      updateNotificationCountSidebarEmployee();
      setInterval(updateNotificationCountSidebarEmployee, 5000);
    });
        
    </script>