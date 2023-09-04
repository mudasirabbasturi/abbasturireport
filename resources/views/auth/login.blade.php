<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Report Admin Dashboard">
    <meta name="author" content="Admin, design by: Mudasir Abbas Turi.">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    
</head>
<body class="theme-cyan">
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
                        <img src="{{ asset('report_logo.png') }}" alt="Report">
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Login to your account</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" method="POST" action="{{ route('login') }}">
                                @csrf
                                @if(Session::get('fail'))
                                <span class="text-danger">{{ Session::get('fail') }}</span>
                                @endif
                                <div class="form-group">
                                    <label for="email" class="control-label sr-only">Email</label>
                                    <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                    @if(Session::get('EmailNotFoundError'))
                                    <span class="text-danger">{{ Session::get('EmailNotFoundError') }}</span>
                                    @endif
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Your email">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label sr-only">Password</label>
                                    <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                    @if(Session::get('PasswordError'))
                                    <span class="text-danger">{{ Session::get('PasswordError') }}</span>
                                    @endif
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Your password">
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Remember me</span>
                                    </label>
                                </div> -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ __('Login') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>