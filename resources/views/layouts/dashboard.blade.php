<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Your poinsettia management system.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'SmartSettia') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css" integrity="sha256-VZWWO8oq84vI5Es0R/L74m09VSsVHg0sugRTBgnPZnY=" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Head Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand navbar-link" href="/">
                    <i class="glyphicon glyphicon-grain"></i>SmartSettia
                </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="{{ Route::currentRouteNamed('home') || Request::segment(1) === '/' ? 'active' : '' }}" role="presentation"><a href="/">Home</a></li>
                    <li class="{{ Route::currentRouteNamed('about') ? 'active' : '' }}" role="presentation"><a href="{{ route('about') }}">About</a></li>
                    <li class="{{ Route::currentRouteNamed('help') ? 'active' : '' }}" role="presentation"><a href="{{ route('help') }}">Help</a></li>
                    <li class="{{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}" role="presentation"><a href="{{ route('dashboard') }}">Dashboard </a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="{{ route('admin') }}">Manage <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="{{ Route::currentRouteNamed('user.index') ? 'active' : '' }}" role="presentation"><a href="{{ route('user.index') }}">Manage Users </a></li>
                            <li class="{{ Route::currentRouteNamed('manage-groups') ? 'active' : '' }}" role="presentation"><a href="{{ route('manage-groups') }}">Manage Groups </a></li>
                            <li class="{{ Route::currentRouteNamed('manage-units') ? 'active' : '' }}" role="presentation"><a href="{{ route('device.index') }}">Manage Units </a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                            <img src="/img/avatar.jpg" class="dropdown-image">{{ Auth::user()->name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li class="{{ Route::currentRouteNamed('user-settings') ? 'active' : '' }}" role="presentation"><a href="{{ route('user-settings') }}">Settings</a></li>
                            <li class="{{ Route::currentRouteNamed('user-notifications') ? 'active' : '' }}" role="presentation"><a href="{{ route('user-notifications') }}">Notifications</a></li>
                            <li class="{{ Route::currentRouteNamed('logout') ? 'active' : '' }}" role="presentation" class="active">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout ({{ Auth::user()->name }})</a>
                                <form id="logout-form" action="logout" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- yield content -->
    @yield('content')

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h5>SmartSettia © 2017</h5></div>
                <div class="col-sm-6 social-icons">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Body Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js" integrity="sha256-fzbeRFWxDKUq4+WF3Eyv1jhRcV2hrj5LJDn2asBF6/0=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/dash_image.js') }}"></script>
    @stack('scripts')
</body>
</html>
