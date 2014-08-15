'use strict';

/* Controllers */

angular.module('umramember.controllers', [])
    .controller('RegistrationCtrl', ['$scope', function($scope) {
        $scope.memberStatus = 'new';

        $scope.counts = {
            members: 1,
            parkingCoupons: 1
        };
        $scope.costs = {
            member: 0,
            luncheon: 0,
            total: 0
        };

        $scope.$watch(function () { return parseInt($scope.costs.member) + parseInt($scope.costs.luncheon) }, function (newVal, oldVal) {
            $scope.costs.total = newVal;
        });
    }])
