(function () {
    'use strict';

    angular
        .module('wizard.onboarding', ['ui.bootstrap'])
        .controller('storeController', StoreController)
        .factory('dataFactory', dataFactory);

    StoreController.$inject = ['$scope', '$uibModal', '$window', 'dataFactory'];


    function StoreController($scope, $uibModal, $window, dataFactory) {
        var modalInstance;

        $scope.store = {
            'goBack' : 0
        };
        $scope.store.addedItems = [];
        $scope.store.errorFields = [];
        $scope.store.detail = storeObj.detail ? (storeObj.detail) : {};

        if (storeObj.detail) {
            delete storeObj.detail;
        }
        $scope.store.setupDetail = storeObj;
        console.log($scope.store);
        $scope.store.saveStoreDetails = function () {
            dataFactory.saveData('saveStoreDetails', $scope.store).then(function(response) {
                $scope.store.errorFields = response.fieldName;

                if (!response.response) {
                    $scope.store.setupError = response.msg;
                } else {
                    $scope.store.setupDetail.storeId = response.storeId;
                    $scope.store.setupDetail.storeName = $scope.store.detail.name;
                    $scope.store.setupDetail.wizardStep = 2;
                    $scope.store.setupError = false;
                }
            });
        };

        $scope.store.saveItem = function () {
            dataFactory.saveData('saveItem', $scope.store).then(function(response) {console.log(response);
                $scope.store.errorFields = response.fieldName;

                if (!response.response) {
                    $scope.store.addItemError = response.msg;
                } else {
                    $scope.store.addItemError = false;
                    $scope.store.addedItems.unshift([
                        $scope.store.newitem.name,
                        $scope.store.newitem.price
                    ]);
                    delete $scope.store.newitem;
                }
            });
        };

        $scope.store.checkIfStorePresent = function () {
            dataFactory.getData('storePresence', $scope.store.detail.name).then(function(response) {
                if (!response.response) {
                    $scope.store.setupError = response.msg;
                    if (response.fieldName) {
                        $scope.store.errorFields.push(response.fieldName);
                    }
                } else {
                    $scope.store.setupError = false;
                }
            });
        };

        $scope.store.checkIfItemPresent = function () {
            dataFactory.getData('itemPresence', $scope.store.newitem.name).then(function(response) {
                if (!response.response) {
                    $scope.store.setupError = response.msg;
                } else {
                    $scope.store.setupError = false;
                }
            });
        };

        $scope.store.continueToDashboard = function () {
            if ($scope.store.setupDetail) {
                delete $scope.store.setupDetail;
            }

            modalInstance ? modalInstance.dismiss(): '';
            modalInstance = $uibModal.open({
                templateUrl: 'configuring-dashboard.html',
                size: 'md',
                backdrop : true
            });

            setTimeout(function () {
                $window.location = $window.location.origin + '/wizard/dashboard';
                modalInstance ? modalInstance.dismiss(): '';
            }, 5000);
        };

        $scope.store.skipStep = function(step) {
            dataFactory.saveData('skipStep', {
                "step" : step,
                "storeId" : $scope.store.setupDetail.storeId
            }).then(function(response) {console.log(response);
                if (step == $scope.store.setupDetail.storeSetupOrder.length) {
                    $scope.store.continueToDashboard();
                }
            });
        };

        $scope.store.goBack = function () {
            $scope.store.setupDetail.wizardStep -= 1;
        }
    }

    function dataFactory($http, $q) {
        var storeObj = {};

        storeObj.saveData = function (type, data) {
            var deferred = $q.defer();

            switch (type) {
                case 'saveStoreDetails':
                    storeObj.url = '/wizard/addstore';
                    break;

                case 'saveItem':
                    storeObj.url = '/wizard/additem';
                    break;

                case 'skipStep':
                    storeObj.url = '/wizard/skipstep';
                    break;
            }

            $http({
                'method' : 'POST',
                'url' : storeObj.url,
                'data': data
            })
            .success(function (data) {
                deferred.resolve(data);
            }).error(function (err) {
                deferred.reject(err);
            });

            return deferred.promise;
        };

        storeObj.getData = function (type, data) {
            var deferred = $q.defer();

            switch(type) {
                case 'storePresence':
                    var url = '/wizard/checkstorepresence/' + data;
                    break;
            }

            $http({
                'method' : 'GET',
                'url' : url
            })
            .success(function (data) {console.log(data);
                deferred.resolve(data);
            }).error(function (err) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        return storeObj;
    }
})();