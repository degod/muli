<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">

        <title>Muli</title>

        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            @font-face {
                font-family: Montserrat;
                src: url({{ asset('fonts/Montserrat-Regular.ttf') }});
            }
            @font-face {
                font-family: Montserrat-Medium;
                src: url({{ asset('fonts/Montserrat-Medium.ttf') }});
            }
            @font-face {
                font-family: Montserrat-Bold;
                src: url({{ asset('fonts/Montserrat-Bold.ttf') }});
            }
            @font-face {
                font-family: Montserrat-SBold;
                src: url({{ asset('fonts/Montserrat-SBold.ttf') }});
            }
            html, body {
                font-family: 'Montserrat', sans-serif;
            }
            #watermark {
                opacity: .013;
                color: black;
                font-size: 6.7em;
                font-family: 'Montserrat-Bold', sans-serif;
                text-align: center;
                font-style: italic;
                position: absolute;
                top: 38vh;
                display: block;
                left: 6vw;
                display: none;
            }
            #vue-app {
                top: -20vh;
            }
            .form-control {
                background-color: white !important;
            }
            h4 {
                font-family: 'Montserrat-SBold', sans-serif !important;
                font-size: 1.3em;
            }
        </style>
    </head>
    <body>
        <p id="watermark">OBINNAPRO PROPERTY</p>

        <div id="vue-app">
            <flash message=""></flash>
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
