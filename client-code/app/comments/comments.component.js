'use strict';

angular.module('comments').component('comments', {
  templateUrl: 'comments/comments.template.html',
  controller: ['$location', function commentsCtrl($location) {
    var self = this;

    self.$onInit = function () {

    };
  }]
})
;