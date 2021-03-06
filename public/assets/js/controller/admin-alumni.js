angular.module('admin').controller('alumni', function($scope, $http, $filter, $timeout, baseURL) {
    $scope.data = {};
    $scope.alerts = [];
    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    var angkatan_id = $filter('_uriseg')(6);
    $http.get(baseURL.url('api/angkatan/') + angkatan_id + '/alumni').success(function(data) {
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
            $scope.numPerPage = 15;
        }, true);
    })
    $scope.delete = function(id, id_angkatan) {
        console.log(id_angkatan);
        if (confirm("Anda yakin untuk menghapus data?") === true) {
            $http.delete(baseURL.url('admin/alumni/') + id ).success(function(data) {
                if (data.success) {
                    $http.get(baseURL.url('api/angkatan/') + angkatan_id + '/alumni').success(function(data) {
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
angular.module('admin').controller('alumnicreate', function($scope, $http, $filter, $timeout, baseURL) {
    $scope.data = {};
    $scope.parent = {checkOut:''};
    $scope.alerts = [];
    $scope.agama = [{'id': 'islam', 'label': 'Islam'}, {'id': 'kristen', 'label': 'Kristen'}, {'id': 'hindu', 'label': 'Hindu'}, {'id': 'budha', 'label': 'Budha'}, {'id': 'katolik', 'label': 'Katolik'}];
    $scope.status = [{'id': 'menikah', 'label': 'Menikah'}, {'id': 'lajang', 'label': 'Belum Menikah'}];
    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    var id = $filter('_uriseg')(6);
    $scope.data['id_angkatan'] = id;
    $scope.kelas = {};
    $http.get(baseURL.url('api/angkatandropdown')).success(function(data) {
        $scope.kelas = data;
    });
    $scope.id_provinsi_tinggal = {};
    $http.get(baseURL.url('api/provinsi-list-dropdown   ')).success(function(data) {
        $scope.id_provinsi_tinggal = data;
    });    
    $scope.submit = function() {
        var tanggal_lahir = $('#datepicker').val();
        $scope.data["tanggal_lahir"] = tanggal_lahir;
        console.log($scope.data);
        $http.post(baseURL.url('admin/angkatan/') + id + '/alumni', $scope.data).success(function(data) {
            if (data.success) {
                window.location.replace(baseURL.url('admin/angkatan/') + $scope.data['id_angkatan'] + '/alumni');
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
});
angular.module('admin').controller('alumniedit', function($scope, $http, $filter, $timeout, baseURL) {
    $scope.data = {};
    $scope.alerts = [];
    $scope.agama = [{'id': 'islam', 'label': 'Islam'}, {'id': 'kristen', 'label': 'Kristen'}, {'id': 'hindu', 'label': 'Hindu'}, {'id': 'budha', 'label': 'Budha'}, {'id': 'katolik', 'label': 'Katolik'}];
    $scope.status = [{'id': 'menikah', 'label': 'Menikah'}, {'id': 'lajang', 'label': 'Belum Menikah'}];
    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    var id = $filter('_uriseg')(6);
    $http.get(baseURL.url('api/alumni/') + id).success(function(data) {
        $scope.data = data;
    })

    $scope.kelas = {};
    $http.get(baseURL.url('api/angkatandropdown')).success(function(data) {
        $scope.kelas = data;
    });

    $scope.id_provinsi_tinggal = {};
    $http.get(baseURL.url('api/provinsi-list-dropdown   ')).success(function(data) {
        $scope.id_provinsi_tinggal = data;
    });        
    $scope.submit = function(id) {
        var tanggal_lahir = $('#datepicker').val();
        $scope.data["tanggal_lahir"] = tanggal_lahir;
        $http.put(baseURL.url('admin/alumni/') + id, $scope.data).success(function(data) {
            if (data.success) {
                $timeout(function() {
                    window.location.replace(baseURL.url('admin/angkatan/') + $scope.data['id_angkatan'] + '/alumni');
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
});
