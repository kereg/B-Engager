'use strict';

angular.module('welcomePage').component('welcomePage', {
  templateUrl: 'welcomePage/welcome-page.template.html',
  controller: ['$location', function welcomePageCtrl($location) {
    var self = this;

    self.$onInit = function () {
    };
  }]
})
;