(function() {
    angular.module('admin', []).controller('MainCtrl', function($scope,$http) {
        $http.post('/admin/manufacturer/api_get').success(function(data) {
            $scope.manufacturers = data['data'];
        });

    });
}());