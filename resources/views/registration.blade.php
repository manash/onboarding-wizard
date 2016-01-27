@extends('template')

@section('title')
    Opinio App Registration
@stop

@section('ng-app')
    <html lang="en" ng-app="wizard.login">
    @stop

    @section('content')
        <div class="container" ng-controller="authController">
            <div class="row">
                <div class="main">
                    <h3>Please Sign Up, or <a href="{{url('login')}}">Login</a></h3>

                    @include('authentication.signup')
                </div>
            </div>
        </div>
    @stop

    @section('scripts')
        @parent
        <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop