'use strict';

/* Controllers */

angular.module('umramember.controllers', [])
    .controller('RegistrationCtrl', ['$scope', function($scope) {
        $scope.memberStatus = 'new';

        $scope.household = {
            postalname: '',
            members: [
                {
                    firstname: '',
                    lastname: ''
                }
            ],
            residences: []
        };

        $scope.counts = {
            members: 1,
            parkingCoupons: 1
        };
        $scope.costs = {
            member: 0,
            luncheon: 0,
            total: 0
        };

        $scope.$watch(function () { return $scope.household.members[0].firstname + " " + $scope.household.members[0].lastname; }, function (newVal, oldVal) {
            if ($scope.household.postalname === oldVal || newVal === oldVal) {
                $scope.household.postalname = newVal;
            }

            if ($scope.household.members[0].fullname === oldVal || newVal === oldVal) {
                $scope.household.members[0].fullname = newVal;
            }
        });

        $scope.$watch(function () { return parseInt($scope.costs.member) + parseInt($scope.costs.luncheon) }, function (newVal, oldVal) {
            $scope.costs.total = newVal;
        });
    }])
