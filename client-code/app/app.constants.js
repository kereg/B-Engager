'use strict';

// Declare app level module which depends on views, and components
angular.module('bEngagerApp').
constant('CONSTANTS', {

}).
  //during run we add the "CONSTANTS" constant to $rootScope in order to use it in the template mode as well
run(['$rootScope','CONSTANTS', function ($rootScope,CONSTANTS) {
  $rootScope.CONSTANTS = CONSTANTS;
}]);
