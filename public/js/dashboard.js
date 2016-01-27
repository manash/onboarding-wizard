(function () {
    'use strict';

    angular
        .module('wizard.dashboard', ['ngTable', 'ui.bootstrap'])
        .controller('dashboardController', DashboardController)
        .factory('dashboardFactory', DashboardFactory);

    DashboardController.$inject = ['$scope', 'dashboardFactory', 'NgTableParams'];


    function DashboardController($scope, dashboardFactory, NgTableParams) {
        $scope.dashboard = {};

        (function () {
            dashboardFactory.getData('getStores').then(function(response){
                if (response) {
                    $scope.dashboard.allStores = response;
                    $scope.selectedRestaurant = response[0];
                    $scope.dashboard.showMenuDetails(response[0].id)
                }
            });
        })();

        $scope.dashboard.showMenuDetails = function (restaurantId) {
            dashboardFactory.getData('getStoresMenuItem', restaurantId).then(function(response){
                $scope.$data = response;
                $scope.dashboard.tableParams = new NgTableParams({ count: 5}, { counts: [5, 10, 25], dataset: response});
            });
        };

    }

    function DashboardFactory($http, $q) {
        var dashboardObj = {};

        dashboardObj.getData = function (type, data) {
            var deferred = $q.defer();

            switch(type) {
                case 'getStores':
                    var url = '/wizard/getstores';
                    break;

                case 'getStoresMenuItem':
                    var url = '/wizard/getstoresmenuitem/' + data;
                    break;
            }

            $http({
                'method' : 'GET',
                'url' : url
            })
                .success(function (data) {
                    deferred.resolve(data);
                }).error(function (err) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        return dashboardObj;
    }
})();