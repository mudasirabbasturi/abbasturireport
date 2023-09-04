<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas">
                <i class="lnr lnr-menu fa fa-bars"></i>
             </button>
        </div>
        <div class="navbar-brand">
            <a href="/admin">
                {{-- <img src="{{ asset('report_logo.png') }}"
                     alt="Report Logo" class="img-responsive logo"> --}}
                <img src="{{ asset('ReportLogo.PNG')}}"
                     alt="Report Logo" class="img-responsive logo">
            </a>
        </div>
        <div class="navbar-right pt-1">
            <a href="{{ route('project.pending') }}" class="btn l-amber btn-sm">
                <small class="text-secondary"><b>New Added </b><span class="badge badge-danger">{{ $ProjectPendingCount }}</span></small>
            </a>
            <span style="position: relative;">
                <button class="btn l-green btn-sm dropdown-toggle" 
                        type="button" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"><small><b class="text-secondary">Quick Links</b></small></button>
                <div class="dropdown-menu" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 100%; left: 0px; will-change: transform;">
                    <a class="dropdown-item" href="{{ route('project.pricingProgress') }}">
                        Pricing On Progress 
                        <span class="badge badge-primary">{{ $ProjectPricingOnProgressCount }}</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('project.progress') }}">
                        Takeoff On Progress 
                        <span class="badge badge-primary">{{ $ProjectTakeOfOnProgressCount }}</span>
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item disabled" href="javascript:void(0);" disabled>Warning..</a>
                    <a class="dropdown-item" href="{{ route('project.hold') }}">
                        Hold
                        <span class="badge badge-danger">{{ $ProjectHoldCount }}</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('project.revision') }}">
                        Revision 
                        <span class="badge badge-danger">{{ $ProjectRevisionCount }}</span>
                    </a>
                </div>
            </span>
            <a href="{{ route('admin.current.progress') }}" class="btn l-amber btn-sm" style="position: relative;">
                <small class="text-secondary">
                    <b>Current Progress 
                    </b>
                    <span class="badge badge-danger">{{ $ProjectCurrentCount }}</span>
                </small>
            </a>
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('admin.calender') }}" 
                           class="icon-menu d-none d-sm-block d-md-none d-lg-block">
                        <i class="icon-calendar"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="icon-bell">
                                <sup>
                                    <b class="text-danger" style="font-size: 10px;">
                                      <span id="header-notification-count-new-tome">{{ $NotificationsCountNewToMe }}</span>
                                    </b>
                                    <sup>
                                      <b class="text-warning" style="font-size: 12px;">
                                        <span id="header-notification-count-new">{{ $NotificationsCountNew }}</span>
                                      </b>
                                    </sup>
                                </sup>
                            </i>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li class="header">
                                @if ($NotificationsCountNewToMe > 0)
                                    <a href="{{ route('admin.notifications.NewToMe') }}">
                                        <strong>
                                            You have personal
                                            <span class="text-danger">
                                                <b id="header-notification-count-new-tome-sub"> {{ $NotificationsCountNewToMe }}</b>
                                            </span>New Notifications.Please Click To view.
                                        </strong>
                                    </a>
                                @else
                                    New Personal Notifications None.....
                                @endif
                            </li>
                            <li class="header">
                                @if ($NotificationsCountNew > 0)
                                    <a href="{{ route('admin.notifications.new') }}">
                                        <strong>
                                            You have 
                                            <span class="text-warning">
                                                <b id="header-notification-count-new-sub">{{ $NotificationsCountNew }}</b>
                                            </span>New Notifications.Please Click To view.
                                        </strong>
                                    </a>
                                @else
                                    New Notifications None.....
                                @endif
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" 
                           class="icon-menu"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="icon-login"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function updateNotificationCount() {
    var xhr = new XMLHttpRequest()
    var URL = "{{ route('admin.notifications.count') }}"
    xhr.open('GET', URL, true)
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText)
        document.getElementById('header-notification-count-new').textContent = response.countNew
        document.getElementById('header-notification-count-new-sub').textContent = response.countNew
        document.getElementById('header-notification-count-new-tome').textContent = response.countNewToMe
        document.getElementById('header-notification-count-new-tome-sub').textContent = response.countNewToMe
      }
    };
    xhr.send();
  }

  updateNotificationCount();
  setInterval(updateNotificationCount, 5000);
});
    
</script>