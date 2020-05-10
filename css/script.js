angular.module('main', ['toaster'])

.controller('myController', function($scope, toaster) {

    $scope.pop = function(){
        toaster.pop('success', "title", "text");
        toaster.pop('error', "title", "text");
        toaster.pop('warning', "title", "text");
        toaster.pop('note', "title", "text");
    };
});
 
