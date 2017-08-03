'use strict';

angular.module('mainPage').component('mainPage', {
  templateUrl: 'mainPage/main-page.template.html',
  controller: ['$location', '$rootScope',
    function mainPageCtrl($location, $rootScope) {
      var self = this;
      $rootScope.weightComments = 0.33;
      $rootScope.weightShares = 0.33;
      $rootScope.weightReactions = 0.33;
      self.pageIds = [362774807070711, 699089396886714, 552183254811992, 1385846988131069];
      self.pagesNames = ['DoubleDown Casino - Free Slots', 'Vegas Downtown Slots', 'Booksy', 'E-brand'];
      self.pages = [
        {"id": "362774807070711","name": "DoubleDown Casino - Free Slots"},
        {"id": "699089396886714","name": "Vegas Downtown Slots"},
        {"id": "552183254811992","name": "Booksy"},
        {"id": "1385846988131069","name": "E-brand"}
      ];


      $rootScope.selectedPage = self.pages[1];

      self.changePageId = function (page) {
        $rootScope.selectedPage = page;
      };

      $rootScope.shareWeightSlider = {
        value: 33,
        options: {
          floor: 0,
          ceil: 100
        },
        step: 1
      };

      $rootScope.reactionsWeight = {
        value: 33,
        options: {
          floor: 0,
          ceil: 100
        },
        step: 1
      };

      $rootScope.commentsWeight = {
        value: 33,
        options: {
          floor: 0,
          ceil: 100
        },
        step: 1
      };

      self.$onInit = function () {
      };

      self.analyzePage = function () {
        $location.path('/fullAnalysis');
      };
    }]
})
;