@extends('template')

@section('title')
    Opinio App Login
@stop

@section('ng-app')
    <html lang="en" ng-app="wizard.login">
    @stop

@section('content')
    <div class="container" ng-controller="authController">
        <div class="row">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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