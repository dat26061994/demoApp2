var app = angular.module('my-app', ['angularUtils.directives.dirPagination', "flow", 'ngFileUpload']);

app.directive('file', function () {
    return {
        scope: {
            file: '='
        },
        link: function (scope, element, attr) {
            element.bind('change', function (event) {
                var file = event.target.files[0];
                scope.file = file ? file : '';
                scope.$apply();
            })
        }
    }
});

app.controller('MemberController', function ($scope, $http, $httpParamSerializerJQLike) {

    /*  show all member */
    $http({
        method: 'GET',
        url: 'admin/list'
    }).then(function successCallback(response) {
        $scope.members = response.data;
    }, function errorCallback(response) {
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

    /* show modal*/
    $scope.modal = function (state, id) {
        $scope.state = state;
        if (state == 'add') {
            $('#exampleModaladd').modal('show');
        } else if (state == 'edit') {
            $http({
                method: 'GET',
                url: 'admin/edit/' + id
            }).then(function successCallback(response) {
                $scope.id = id;
                $scope.file = null;
                $scope.member = response.data;
                $('.avatar').attr('src', 'public/upload/' + response.data.avatar);
                $('.inputCurrentAvatar').attr('value', response.data.avatar);
            }, function errorCallback() {
                sweetAlert("Error...", "Something went wrong!", "error");
            });
            $('#exampleModaledit').modal('show');
        }
    };

    /*Add and Edit Member*/
    $scope.save = function (state, id) {
        if (state == 'add') {
            $scope.submitted = true;
            $http({
                method: 'POST',
                url: 'admin/add',
                data: {
                    name: $scope.member.name,
                    age: $scope.member.age,
                    address: $scope.member.address,
                    file: $scope.file
                },
                headers: {'Content-Type': undefined},
                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    return formData;
                }
            }).then(function successCallback(response) {
                swal("Success!", "You clicked the button!", "success");
                
            }, function errorCallback(response) {
                sweetAlert("Error...", "Something went wrong! Can not add new Member", "error");
            });

        } else if (state == 'edit') {
            $http({
                method: 'POST',
                url: 'admin/edit/' + id,
                data: {
                    name: $scope.member.name,
                    age: $scope.member.age,
                    address: $scope.member.address,
                    file: $scope.file
                },
                headers: {'Content-Type': undefined},
                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    return formData;
                }
            }).then(function successCallback(response) {
                swal("Success!", "You clicked the button!", "success");

            }, function errorCallback(response) {
                sweetAlert("Error...", "Something went wrong! Can not edit member.", "error");
            });
        }
    };
    /*Delete Member*/
    $scope.comfirmDelete = function (id) {
        var isConfirmDelete = confirm("Do you want delete ??");
        if (isConfirmDelete) {
            $http.get('admin/delete/' + id).then(function successCallback(response) {
                swal("Success!", "", "success");
                location.reload();
            }, function errorCallback(response) {
                sweetAlert("Oops...", "Something went wrong! Can not delete member", "error");
            });
        } else {
            return false;
        }

    };
});


