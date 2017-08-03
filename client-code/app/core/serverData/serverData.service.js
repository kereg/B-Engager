'use strict';

angular.module('core.serverData').factory('ServerData', ['$resource',
  function ($resource, pageId, weightComments, weightShares, weightReactions) {
    // return $resource('assets/clientsData/:dataType.json',
    return $resource('/B-Engager/server-code/analyze.php',
      {
        pageId:pageId,
        weightComments: weightComments,
        weightShares: weightShares,
        weightReactions: weightReactions
      }
      ,
      {
        query: {
          method: 'GET',
          isArray: true
        }
      }
    );
  }
]);

