@extends('template')

@section('title')
    Wizard Dashboard
@stop

@section('ng-app')
    <html lang="en" ng-app="wizard.dashboard">
    <link rel="stylesheet" href="https://rawgit.com/esvit/ng-table/master/dist/ng-table.min.css">
    @stop

    @section('content')
        @include('header')
            <div class="container" ng-controller="dashboardController">
                <div class="centered title"><h1>Welcome to the dashboard.</h1></div>

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <select class="form-control" ng-change="dashboard.showMenuDetails(selectedRestaurant)"
                                ng-model="selectedRestaurant"
                                ng-options="restaurant.id as restaurant.name for restaurant in dashboard.allStores track by restaurant.id">
                        </select>

                        <table ng-table="dashboard.tableParams" class="table" show-filter="true">
                            <tr ng-repeat="item in $data">
                                <td title="'Menu Name'" filter="{ name: 'text'}" sortable="'name'">
                                    <span ng-bind="item.name"></span></td>
                                <td title="'Price'" filter="{ price: 'number'}" sortable="'price'">
                                    <span ng-bind="item.price | currency:'&#8377;'"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        @stop

    @section('scripts')
        @parent
        <script src="https://rawgit.com/esvit/ng-table/master/dist/ng-table.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@stop