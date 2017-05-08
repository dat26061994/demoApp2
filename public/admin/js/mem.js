var app = angular.module('my-app', ['angularUtils.directives.dirPagination',"flow"]).constant('API', 'http://localhost:8080/demoApp2/admin/');

app.controller('MemberController', function ($scope, $http, API, $httpParamSerializerJQLike) {

    /*  show all member */
    $http({
        method: 'GET',
        url: API + 'list'
    }).then(function successCallback(response) {
        console.log(response);
        $scope.members = response.data;
    }, function errorCallback(response) {
        console.log(response);
        alert("Error");
    });

    $scope.valid = {
        text: 'guest',
        word: /^\s*\w*\s*$/
    };

    /*Sort and search Data*/
    $scope.sortColumn = 'id';
    $scope.reverse = true;
    $scope.sortData = function (column) {
        if ($scope.sortColumn == column) {
            $scope.reverse = !$scope.reverse;
        } else {
            $scope.reverse = false;
            $scope.sortColumn = column;
        }
    };

    $scope.getSortClass = function (column) {
        if ($scope.sortColumn == column) {
            return $scope.reverse ? 'glyphicon glyphicon-triangle-top' : 'glyphicon glyphicon-triangle-bottom';
        }
        return '';
    };
    $scope.searchData = "";
    $scope.members = [];
    $scope.pageSize = 5;
    $scope.currentPage = 0;
    /*privew image before update*/
    $scope.imageStrings = [];
    $scope.processFiles = function (files) {
        angular.forEach(files,function (flowFile, i) {
            var fileReader = new FileReader();
            fileReader.onload =function (event) {
                var uri = event.target.result;
                $scope.imageStrings[i] = uri;
            };
            fileReader.readAsDataURL(flowFile.file);
        });
    }
    /* show modal*/
    $scope.modal = function (state, id) {
        $scope.state = state;
        switch (state) {
            case 'add':
                $scope.frmTitle = 'Add New Member';
                break;
            case 'edit':
                $scope.frmTitle = 'Edit Member';
                $http({
                    method: 'GET',
                    url: API + 'edit/' + id
                }).then(function successCallback(response) {
                    $scope.id = id;
                    $scope.member = response.data;
                }, function errorCallback() {
                    alert('ERROR');
                });
                break;
            default:
                break;
        }
        $('#exampleModal').modal('show');
    };

    /*Add and Edit Member*/
    $scope.save = function (state, id) {
        if (state == 'add') {
            var data = $httpParamSerializerJQLike($scope.member);
            $http({
                method: 'POST',
                url: API + 'add',
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                console.log(response);
                alert(data);
                location.reload();
            }, function errorCallback(response) {
                console.log(response);
                alert('Error');
            });
        } else if (state == 'edit') {
            $http({
                method: 'POST',
                url: API + 'edit/' + id,
                data: $httpParamSerializerJQLike($scope.member),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                console.log(response);
                location.reload();
            }, function errorCallback(response) {
                console.log(response);
                alert('Error');
            });
        }
    };
    /*Delete Member*/
    $scope.comfirmDelete = function (id) {
        var isConfirmDelete = confirm("Do you want delete ??");
        if (isConfirmDelete) {
            $http.get(API + 'delete/' + id).then(function successCallback(response) {
                console.log(response);
                location.reload();
            }, function errorCallback(response) {
                console.log(response);
                alert('Error');
            });
        } else {
            return false;
        }

    };
});



app.factory('httpPostFactory', function($http) {
    return function(file, data, callback) {
        $http({
            method: 'POST',
            url: file,
            data: data,
            headers: {
                'Content-Type': undefined
            }
        }).then(function successCallback(response) {
            callback(response);
        }, function errorCallback(response) {
            console.log(data);
        });
    };
});




