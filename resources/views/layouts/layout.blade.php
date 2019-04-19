<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kleid | @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/x-icon"/>

    @include('layouts.includes.basic_css')

    @yield('css')
</head>
<body>
    <div class="wrapper overlay-sidebar">
        <div class="main-header">
            <!-- Logo Header -->
            @include('layouts.base.logo')
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">   
                <div class="container-fluid">                    
                    @yield('search')
                    @yield('notificaciones')
                    {{-- @include('layouts.base.notificaciones') --}}
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('layouts.base.menu')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                @yield('header')
                @yield('content')
            </div>
            
            @include('layouts.base.footer')
        </div>
        
        
        <!-- Custom template | don't include it in your project! -->
        
        <!-- End Custom template -->
    </div>

    @include('layouts.includes.basic_scripts')

    @yield('script')
    @yield('javascript')
</body>
</html>