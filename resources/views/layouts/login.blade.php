<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="author" content="Eliseo Rios!">

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>Kleid | @yield('titulo')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icono.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('templates/bsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('templates/bsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('templates/bsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('templates/bsb/css/style.css') }}" rel="stylesheet">

    {{-- Carousel --}}
    <link rel="stylesheet" href="{!! asset('vendor/vegas/vegas.min.css') !!}">
    <style type="text/css">

        .panel-info {
        opacity: 0.9;
        margin-top:30px;
        }
        .form-group.last { margin-bottom:0px; }
        .vertical-center {
          min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
          min-height: 100vh; /* These two lines are counted as one :-)       */

          display: flex;
          align-items: center;
        }
    </style>
    
</head>

<body class="login-page" style="background-image: url({{ asset('templates/bsb/images/back2.jpg') }}) !important; background-size: cover;>
    <div class="login-box">
        <div class="logo">
            <a href="{{ url('/') }}" style="color: #918787 !important;">Kleid<b> Boutique</b></a>
            <small style="color: #918787 !important;">Moda al alcance</small>
        </div>
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('templates/bsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="v{{ asset('endor/bsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('templates/bsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{ asset('templates/bsb/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('templates/bsb/js/admin.js') }}"></script>
    <script src="{{ asset('templates/bsb/js/pages/examples/sign-in.js') }}"></script>

    <script src="{!! asset('vendor/vegas/vegas.min.js') !!}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#example, body").vegas({
                delay: 5000,
                timer: false,
                shuffle: true,
                firstTransition: 'fade',
                firstTransitionDuration: 5000,
                transition: 'fade',
                transitionDuration: 15000,
                overlay: false,
                slides: [
                    { src: "{!! asset('img/slider/1.jpg') !!}" }, 
                    { src: "{!! asset('img/slider/2.jpg') !!}" },
                    { src: "{!! asset('img/slider/3.jpg') !!}" }

                ]
            });
        });

    </script>

</body>

</html>