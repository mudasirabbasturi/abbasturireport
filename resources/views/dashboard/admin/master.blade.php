<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Report Bootstrap 4.1.1 Admin Template">
    <meta name="author" content="Report Admin, design by: Mudasir Abbas Turi.">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    @yield('styles')
</head>

<body class="theme-cyan layout-fullwidth">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img src="{{ asset('ReportLogo.PNG') }}" alt="Report Admin Dashboard" width="350" height="100">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div id="wrapper">
        @include("dashboard.admin.header")
        @include("dashboard.admin.sidebar")
        <div id="main-content">
          @yield('content')
        </div>
    </div>
    @yield('scripts')

</body>

</html>