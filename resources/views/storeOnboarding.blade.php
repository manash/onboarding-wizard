@extends('template')

@section('title')
    Wizard Onboarding
@stop

@section('ng-app')
    <html lang="en" ng-app="wizard.onboarding">
    @stop

    @section('content')
        @include('header')

        <div class="container" ng-controller="storeController">
            <div class="centered title"><h1>Welcome to the onboarding process.</h1></div>
            <br><br>

            @include('store.addStore')
            @include('store.addStoreItem')
            @include('configuringDashboard')
        </div>
    @stop

    @section('scripts')
        @parent
        <script>
            storeObj = JSON.parse('<?php echo addslashes(json_encode($data)); ?>');
        </script>
        <script type="text/javascript" src="{{ asset('js/store.js') }}"></script>
@stop