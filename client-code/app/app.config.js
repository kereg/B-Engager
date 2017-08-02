'use strict';

// Declare app level module which depends on views, and components
angular.module('bEngagerApp').
config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
  $locationProvider.hashPrefix('!');

  $routeProvider
      .when("/welcomePage" , {
          // templateUrl: "welcomePage/welcome-page.template.html",
          template: "<welcome-page></welcome-page>"
      })
      .when("/mainPage" , {
          template : "<main-page></main-page>"
      })
      .when("/fullAnalysis" , {
          template : "<full-analysis></full-analysis>"
      })
      .when("/comments" , {
          template : "<comments></comments>"
      })
      .otherwise({redirectTo: '/welcomePage'});
}]);
