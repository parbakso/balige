angular.module('admin').controller('dataloker', function($scope, $http, $filter, $timeout, baseURL) {
    $scope.data = {};
    $scope.alerts = [];
    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    $http.get(baseURL.url('api/loker')).success(function(data) {
        $scope.data = data;
        $scope.totalItems = $scope.data.length;
        $scope.currentPage = 1;
        $scope.numPerPage = 5;
        // fungsi sorting data ASC/DESC
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = $scope.data.indexOf(value);
            return (begin <= index && index < end);
        };
        $scope.$watch('query', function(query) {
            $scope.data = data;
            $scope.data = $filter('filter')($scope.data, $scope.query);
            $scope.totalItems = $scope.data.length;
            $scope.currentPage = 1;
            $scope.numPerPage = 5;
        }, true);
    })
    $scope.delete = function(id) {
        if (confirm("Anda yakin untuk menghapus data?") === true) {
            $http.delete(baseURL.url('admin/loker/') + id).success(function(data) {
                if (data.success) {
                    $http.get(baseURL.url('api/loker')).success(function(data) {
                        $scope.data = data;
                        $scope.alerts.push({type: 'success', msg: 'Data Berhasil Dihapus'});
                        $timeout(function() {
                            $scope.alerts = [];
                        }, 5000);
                    })
                }
            });
        }
    }
});
angular.module('admin').controller('lokercreate', function($scope, $http, $filter, $timeout, $upload, baseURL) {
    $scope.data = {};
    $scope.alerts = [];
    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    $scope.submit = function() {
        $scope.data['isi'] = CKEDITOR.instances.editor1.getData();
        if ($scope.data.foto) {
            $upload.upload({
                url: baseURL.url('admin/loker'),
                method: 'POST',
                file: $scope.data.foto,
                data: $scope.data
            }).success(function(data) {
                if (data.success) {
                    $timeout(function() {
                        window.location.replace(baseURL.url('admin/loker'));
                    }, 3000);
                }
            });
        } else {
            $http.post(baseURL.url('admin/loker'), $scope.data).success(function(data) {
                if (data.success) {
                    $timeout(function() {
                        window.location.replace(baseURL.url('admin/loker'));
                    }, 3000);
                }
            }).error(function(e, status) {
                if (status === 422) {
                    var x;
                    for (x in e) {
                        $scope.alerts.push({'type': "danger", 'msg': (e[x][0])});
                    }
                    $timeout(function() {
                        $scope.alerts = [];
                    }, 5000);
                }
            });
        }
    }
});
angular.module('admin').controller('lokeredit', function($scope, $http, $filter, $timeout, $upload, baseURL) {
    $scope.data = {}
    var id = $filter('_uriseg')(6);
    $http.get(baseURL.url('api/loker/') + id).success(function(data) {
        $scope.data = data;
    })
    $scope.submit = function(id) {
        $scope.data['isi'] = CKEDITOR.instances.editor1.getData();
        if ($scope.data.foto) {
            $upload.upload({
                url: baseURL.url('admin/loker'),
                method: 'POST',
                file: $scope.data.foto,
                data: $scope.data
            }).success(function(data) {
                if (data.success) {
                    $timeout(function() {
                        window.location.replace(baseURL.url('admin/loker'));
                    }, 3000);
                }
            });
        } else {
            $http.put(baseURL.url('admin/loker/') + id, $scope.data).success(function(data) {
                if (data.success) {
                    $timeout(function() {
                        window.location.replace(baseURL.url('admin/loker'));
                    }, 3000);
                }
            }).error(function(e, status) {
                if (status === 422) {
                    var x;
                    for (x in e) {
                        $scope.alerts.push({'type': "danger", 'msg': (e[x][0])});
                    }
                    $timeout(function() {
                        $scope.alerts = [];
                    }, 5000);
                }
            });
        }
    }
});
