@extends('template')

@section('title')
    Laravel
@stop

@section('ng-app')
    <html lang="en" ng-app="wizard.login">
    @stop

@section('content')
    <div class="container" ng-controller="authController">
        <div class="row">
            <div class="main">
                <h3>Please Log In, or <a href="{{url('register')}}">Sign Up</a></h3>

                @include('authentication.login')
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@stop