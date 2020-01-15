

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blood Test Diary</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>





    @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'login')
        <header>
            <div class="media" id="headerTables">
                <div class="media-body" id="headerText">
                    <h1 class="media-heading"style="color:white" >King's College Hospital</h1>
                    <h3 id="textColor" style="color:white">NHS Foundation Trust</h3>
                </div>
                <div class="headerImage">
                    <img src="{{asset('images/logo-footer.png')}}"  style="width:120px "  alt="nhs" id="headerPhoto">
                </div>
            </div>

            <hr class="header-line">

            @if(!Auth::guest())
            <form method="get" id="backForm" action="{{route('editCredentials')}}">
                <button type="submit" class="back"  id="right-panel-link" style="width:10%" >Edit Account</button>
            </form>

             @include('layouts.app.logoutForm')
             @endif

        </header>

        <div>
            <div id="buttonrow">
                <img src="images/centre.jpeg" width="100%">
            </div>
        </div>


    @else
        <header>
            <div class="media" id="headerTables">
                <div class="media-body" id="tableHeaderText">
                    @yield("title")
                </div>
                <div class="headerImage">
                    <img src="{{asset('images/logo-footer.png')}}" style="width:120px "  alt="nhs" id="headerPhoto">
                </div>
            </div>

            <hr class="header-line">


            <form method="get" action="{{route('home')}}" id="backForm">
                <button type="submit" class="back"  id="right-panel-link" style="width:10%"  href="#right-panel">Home</button>
            </form>

            @include('layouts.app.logoutForm')
        </header>


    @endif








@yield('supercontent')

@include('layouts.app.footer')

</body>
</html>
