'use strict';

/**
 * @ngdoc function
 * @name coq.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of coq
 */
angular.module('coq')
  .controller('DashboardCtrl', function($scope, $state) {

    $scope.$state = $state;

  });