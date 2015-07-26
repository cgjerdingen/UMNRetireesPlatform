(function () {
    'use strict';
    angular.module('umramember.controllers', [])
        .controller('RegistrationCtrl', ['$scope', function($scope) {
            $scope.household = {
                postalname: '',
                members: [
                    {
                        firstname: '',
                        lastname: '',
                        fullname: '',
                        nametagname: '',
                        nickname: ''
                    }
                ],
                residences: []
            };

            $scope.types = {
                luncheon: null
            };

            $scope.counts = {
                members: 1,
                parkingCoupons: 0
            };
            $scope.costs = {
                member: 0,
                luncheon: 0
            };

            $scope.getTotalCost = function () {
                return parseInt($scope.costs.member) + parseInt($scope.costs.luncheon);
            };

            $scope.$watch(function () {
              return (($scope.household.members[0].firstname || "") + " " + ($scope.household.members[0].lastname || "")).trim();
            }, function (newVal, oldVal) {
                if ($scope.household.postalname === oldVal || newVal === oldVal) {
                    $scope.household.postalname = newVal;
                }

                if ($scope.household.members[0].nametagname === oldVal || newVal === oldVal) {
                    $scope.household.members[0].nametagname = newVal || "";
                }

                if ($scope.household.members[0].nickname === oldVal || newVal === oldVal) {
                    $scope.household.members[0].nickname = $scope.household.members[0].firstname || "";
                }

                if ($scope.household.members[0].fullname === oldVal || newVal === oldVal) {
                    $scope.household.members[0].fullname = newVal || "";
                }
            });
    }]);
})(angular);
