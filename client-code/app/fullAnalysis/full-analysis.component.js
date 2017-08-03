'use strict';

angular.module('fullAnalysis').component('fullAnalysis', {
  templateUrl: 'fullAnalysis/full-analysis.template.html',
  controller: ['$rootScope', 'ServerData', function fullAnalysisCtrl($rootScope, ServerData) {
    var self = this;
    self.$onInit = function () {
      self.getDataFromServer();
    }

    self.getDataFromServer = function () {
      self.allServerData = ServerData.get({pageId:$rootScope.selectedPage.id,
          weightComments: $rootScope.weightComments, weightShares:$rootScope.weightShares,
          weightReactions:$rootScope.weightReactions},
        function () {
          //If the user is not authenticated redirection to the login page will take place
          if (self.allServerData.redirect) {
            window.location.href = self.allServerData.redirect;
          }

          //update static values
          self.posts = self.allServerData.data;
        });
    };


  }]
})
;