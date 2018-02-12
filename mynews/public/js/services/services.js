myApp
    .factory('myService', function ($http, $q) {
        return {
            getFile: function (file) {
                let deffered_obj = $q.defer();
                $http.get(file).then(function success(response) {
                    deffered_obj.resolve(response.data);
                }, function error(response) {
                    deffered_obj.reject(response.data);
                });
                return deffered_obj.promise
            }
        }
    })
    .controller('myCtrl', ['$scope', '$http', 'myService',
        function ($scope, $http, myService) {
            $scope.page = 0;
            $scope.prevPage = function (page) {
                $scope.page = Math.max(0, page - 1);
            };
            $scope.nextPage = function (page, max_pages) {
                $scope.page = Math.min(max_pages, page + 1);
            };
            $scope.getRandom = function(){
                return Math.floor((Math.random()*4)+1);
            };
            let promise = myService.getFile('/json/data.json');
            promise.then(function (data) {
                $scope.data = data.news;
            });
        }]);