<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Library System</title>

        <!-- CSS And JavaScript -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Library System
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>
                @if (Auth::check())
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                            @if (Auth::user()->userType == 'user')
                            <li><a href="{{ url('/books/search') }}">Borrow</a></li>
                            <li><a href="{{ url('/books/bookReturn') }}">Return</a></li>  
                            @endif
                             @if (Auth::user()->userType =='admin')                    
                            <li><a href="{{ url('/books') }}">Books</a></li>
                            <li><a href="{{ url('/users') }}">Users</a></li>
                            <li><a href="{{ url('/reports') }}">Reports</a></li>
                            @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }}<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                </ul>
                @endif
            </div>
        </div>
        @yield('content')

    </body>
</html>
