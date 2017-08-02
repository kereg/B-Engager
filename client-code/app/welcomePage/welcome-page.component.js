'use strict';

angular.module('welcomePage').component('welcomePage', {
  templateUrl: 'welcomePage/welcome-page.template.html',
  controller: ['$location', function welcomePageCtrl($location) {
    var self = this;

    self.$onInit = function () {
      var d = document;
      var s = 'script';
      var id = 'facebook-jssdk'
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1268965733214006";
      fjs.parentNode.insertBefore(js, fjs);
    };
  }]
})
;