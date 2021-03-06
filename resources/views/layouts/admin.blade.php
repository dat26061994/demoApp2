<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <title>Admin </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('public/css/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- mycss--}}
    <link href="{{ url('public/css/mycss.css') }}" rel="stylesheet">
    {{--swetalert--}}
    <link href="{{ url('public/css/admin/css/sweetalert.css') }}" rel="stylesheet">

</head>

<body ng-app="my-app" ng-controller="MemberController">
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
@yield('content')

        <!-- jQuery -->
<script src="{{ url('public/css/admin/js/jquery.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ url('public/css/admin/js/bootstrap.min.js') }}"></script>
{{--Angular JS--}}
<script src="{{ url('public/css/admin/js/angular.min.js') }}"></script>
<script src="{{ url('public/css/admin/js/mem.js') }}"></script>
{{--Pagination Angular--}}
<script src="{{ url('public/css/admin/js/dirPagination.js') }}"></script>
{{--Show Iamge Angular ng-flow--}}
<script src="{{ url('public/css/admin/js/ng-flow-standalone.min.js') }}"></script>
<script src="{{ url('public/css/admin/js/ng-flow.min.js') }}"></script>
<script src="{{ url('public/admin/js/ng-flow.min.js') }}"></script>
{{--Angular Upload Image--}}
<script src="{{ url('public/css/admin/js/ng-file-upload.js') }}"></script>
<script src="{{ url('public/css/admin/js/ng-file-upload-shim.js') }}"></script>
<script src="{{ url('public/css/admin/js/ng-file-upload-shim.min.js') }}"></script>
<script src="{{ url('public/css/admin/js/ng-file-upload.min.js') }}"></script>
{{--sweetalert--}}
<script src="{{ url('public/css/admin/js/sweetalert.min.js') }}"></script>
</body>

</html>
