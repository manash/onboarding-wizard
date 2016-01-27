<!DOCTYPE html>
@section('ng-app')
    <html lang="en">
    @show

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="fragment" content="!">
        <title>@yield('title')</title>
        @section('stylesheets')
            <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
            <link href="{{ asset('css/style.css') }}" rel="stylesheet">
            <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" integrity="sha256-k2/8zcNbxVIh5mnQ52A0r3a6jAgMGxFJFE2707UxGCk= sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous">
        @show
    </head>
    <body style="font-family: 'Open Sans', sans-serif;">
        @yield('content')

        @section('scripts')
            <script src="{{ asset('js/angular.min.js') }}"></script>
            <script src="{{ asset('js/ui-bootstrap-tpls-1.1.0.min.js') }}"></script>
        @show
    </body>
</html>
