<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="{{ URL::asset('assets/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
  @yield('styles')
</head>
<body>
    <div id="app" style="background-color: white; ">
        <nav  class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container" >
                <a class="navbar-brand" href="{{ url('/') }}"><i class="fa fa-leaf"></i>

                    {{ config('app.name', 'Laravel') }}
                </a>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="float:right;">
                        <!-- Authentication Links -->
                        @guest
<!--
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
-->
                            @if (Route::has('register'))
<!--
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
-->
                            @endif
                        @else
                            <script>
                        $(".navbar").show();
                        </script>
                            <li class="nav-item dropdown" style="list-style-type:none;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: #2E384D;font-family: 'Rubik-Medium';font-weight: Regular;text-decoration:none;width: 107px;height: 23px;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     <img src="{{ Auth::user()->profile_pic }}"  style="width: 25px;height: 25px;opacity: 1;border-radius: 50%;margin-right:10px;" >
                                     {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="dropdownList">
                               
                                <a class="dropdown-item" href="{{ url('/home') }}" style="color:black;list-style-type:none;text-decoration:none;">
                                        {{ __('Dashboard') }}
                                    </a><br><br>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}" style="color:black;list-style-type:none;text-decoration:none;"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
