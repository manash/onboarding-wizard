(function () {
    'use strict';

    angular
        .module('wizard.login', ['ui.bootstrap'])
        .controller('authController', AuthController);

    AuthController.$inject = ['$scope'];


    function AuthController($scope) {
        $scope.signup = {};
    }
})();