<link href="../assets/plugins/checkbox/icheck-material.min.css" rel="stylesheet" type="text/css">
<script src="../assets/plugins/angularjs/angularjs.min.js"></script>
<script src="../assets/plugins/lodash/lodash.js"></script>

<div ng-app="app" ng-controller="date_off" ng-init="init()">
    <div class="modal fade" id="care" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="label label-default close-modal cursor" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                    <div class="row">


                        <div class="col-md-4">
                            <div class="wrap-history">
                                <h4 class="title">
                                    Cập nhật chăm sóc
                                </h4>
                                <form role="form" ng-submit="saveStudentCare()">

                                    <div class="form-group">
                                        <strong>
                                            Số điện thoại:
                                        </strong>
                                        {{current_student.phone}}
                                    </div>
                                    <div class="form-group">
                                        <strong>
                                            Tag:
                                        </strong>
                                        <div tabindex="-1" class="input-dropdown">
                                            <input type="text" class="form-control" ng-blur="clickOutSide()" ng-model="care.name_care" ng-change="changeCare()" ng-focus="changeCare()">
                                            <ul id="myUL">
                                                <li class="cursor" ng-repeat="(index,value) in list_key" ng-mousedown="clickKey(value.name)">
                                                    <a>{{value.name}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" class="btn btn-primary" value="Cập nhật" ng-click="changeNameGroup()">
                                    </div>
                                </form>

                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="wrap-history">
                                <h4 class="title">
                                    Lịch sử chăm sóc
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead style="background: white">
                                            <tr>
                                                <th class="text-center">
                                                    Ngày
                                                </th>
                                                <th class="text-center">Nhân viên chăm sóc</th>
                                                <th class="text-center">
                                                    Tình trạng
                                                </th>
                                                <th class="text-center">
                                                    Thao tác
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="background: white">
                                            <tr ng-repeat="(index,value) in care_data">
                                                <td class="text-center">
                                                    {{value.created}}
                                                </td>
                                                <td>
                                                    {{value.import_name}}
                                                </td>
                                                <td>
                                                    {{value.name_care }}
                                                </td>
                                                <td>

                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="p1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Xác nhận</button>
                </div> -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="infor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="label label-default close-modal cursor" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                    <div class="row">
                        <form role="form" ng-submit="saveStudent()">
                            <h4 class="text-center" style="font-weight: 600">
                                Thông tin học viên
                            </h4>
                            <input type="text" class="form-control hidden" value="current_student.id" ng-model="current_student.id">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Số điện thoại:
                                    </strong>
                                    <input type="text" class="form-control" ng-model="current_student.phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Tên:
                                    </strong>
                                    <input type="text" class="form-control" ng-model="current_student.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Ngày sinh:
                                    </strong>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control datepicker" ng-model="current_student.date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Địa chỉ:
                                    </strong>
                                    <input type="text" class="form-control" ng-model="current_student.address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Số chứng minh:
                                            </strong>
                                            <input type="text" class="form-control" ng-model="current_student.identity_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="icheck-material-green">
                                    <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-checked="current_student.is_registed" ng-model="current_student.is_registed" id="green" />
                                    <label for="green">Học viên chính thức</label>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <input type="submit" class="btn btn-primary" value="Cập nhật" ng-click="changeNameGroup()">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Xác nhận</button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="container-tab">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" ng-submit="addStudent()" class="pull-right" style="max-width: 250px">
                            <div class="input-group other">
                                <input type="text" style="height: 32px" ng-model="student.phone" class="form-control" placeholder="Nhập số điện thoại">
                                <div class="input-group-addon">
                                    <input type="submit" class="input-group-addon" value="Tạo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <ul class="nav nav-tabs">
                    <li ng-class="{'active':filter.is_registed==2}" class="cursor" ng-click="getDataStudent(2)"><a><i class="fa fa-list" aria-hidden="true"></i> Tất cả</a></li>
                    <li ng-class="{'active':filter.is_registed==1}" class="cursor" ng-click="getDataStudent(1)"><a><i class="fa fa-address-card" aria-hidden="true"></i> Đã đăng ký</a></li>
                    <li ng-class="{'active':filter.is_registed==0}" class="cursor" ng-click="getDataStudent(0)"><a><i class="fa fa-refresh" aria-hidden="true"></i> Chưa đăng ký</a></li>

                    <li class="pull-right" style="max-width: 200px">


                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead style="background: white">
                                    <tr>
                                        <th style="width: 5%" class="text-center">STT</th>
                                        <th>Số điện thoại</th>
                                        <th>Tên</th>
                                        <th>
                                            Số lần chăm sóc
                                        </th>
                                        <th>
                                            Chăm sóc gần nhất
                                        </th>
                                        <th class="text-center" style="width: 10%">
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="background: white">
                                    <tr ng-repeat="(index,value) in ajax_data">
                                        <td class="text-center">
                                            <div style="height: 50px;line-height: 50px">
                                                {{p.offset + index + 1}}
                                            </div>
                                        </td>
                                        <td>
                                            {{value.phone}}
                                        </td>
                                        <td>
                                            {{value.name}}
                                        </td>
                                        <td>
                                            {{value.total}}
                                        </td>
                                        <td>
                                            {{value.recent}}
                                        </td>
                                        <td class="text-center">
                                            <div class="excute">
                                                <div class="dropdown" style="display: inline-block">
                                                    <span style="cursor: pointer;padding: 7px 15px;border:1px solid rgb(20, 20, 148);border-radius: 5px;color:rgb(20, 20, 148)" data-toggle="dropdown">
                                                        Thao tác <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                    </span>
                                                    <ul class="dropdown-menu" style="    left: unset;right: 100%; top: -10px;">
                                                        <li>
                                                            <a class="cursor" ng-click="openInforModal(value)">
                                                                <i class="fa fa-eye text-primary" aria-hidden="true"></i>
                                                                Thông tin cá nhân
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="cursor" ng-click="openCareModal(value)">
                                                                <i class="fa fa-handshake-o text-success" aria-hidden="true" style="font-size: 13px"></i>
                                                                Chăm sóc
                                                            </a>
                                                        </li>
                                                        <!-- <li>
                                                            <a href="staffs/submit_order/{{value.type}}/{{value.id}}">
                                                            <i class="fa fa-history" aria-hidden="true"></i>
                                                                Lịch sử chăm sóc
                                                            </a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="p" style="padding-bottom: 10px;width:100%;display: inline-block">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #ui-datepicker-div {
        z-index: 999999 !important;
    }

    #infor .modal-dialog {
        width: 1000px;
    }

    .close-modal {
        position: absolute;
        padding: 0;
        line-height: 32px;
        position: absolute;
        text-align: center;
        top: -6px;
        right: -7px;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        font-size: 20px;
        color: brown;
        transition: 0.3s all;
    }

    .close-modal:hover {
        background: white;
        color: black;
    }

    .input-dropdown {
        position: relative
    }

    #myUL {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        z-index: 9;
    }

    #myInput {

        background-image: url('/css/searchicon.png');
        /* Add a search icon to input */
        background-position: 10px 12px;
        /* Position the search icon */
        background-repeat: no-repeat;
        /* Do not repeat the icon image */
        width: 100%;
        /* Full-width */
        font-size: 16px;
        /* Increase font-size */
        padding: 12px 20px 12px 40px;
        /* Add some padding */
        border: 1px solid #ddd;
        /* Add a grey border */
        margin-bottom: 12px;
        /* Add some space below the input */
    }

    #myUL {
        /* Remove default list styling */
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #myUL li a {
        border: 1px solid #ddd;
        /* Add a border to all links */
        margin-top: -1px;
        /* Prevent double borders */
        background-color: #f6f6f6;
        /* Grey background color */
        padding: 2px 6px;
        /* Add some padding */
        text-decoration: none;
        /* Remove default text underline */
        font-size: 14px;
        /* Increase the font-size */
        color: black;
        /* Add a black text color */
        display: block;
        /* Make it into a block element to fill the whole list */
    }

    #myUL li a:hover:not(.header) {
        background-color: #eee;
        /* Add a hover effect to all links, except for headers */
    }

    #care .title {
        padding-bottom: 15px;
        font-weight: 600;
    }

    #care .modal-dialog {
        min-width: 1000px
    }

    .excute .dropdown-menu i {
        width: 11px;
        margin-right: 10px;
    }

    .container-tab {
        background: #f5f5f5;
        padding-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 3px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        vertical-align: middle;
    }

    .other .input-group-addon {
        padding: 0 !important;
    }

    .input-group .input-group-addon input {
        width: 40px;
        height: 29px;
        border: unset;
    }

    .container-tab .nav-tabs {
        border: none;
    }

    .container-tab .nav-tabs>li.active>a,
    .container-tab .nav-tabs>li.active>a:focus,
    .container-tab .nav-tabs>li.active>a:hover {
        border: none;
        color: #3c8dbc;

    }

    .container-tab .nav-tabs>li>a {
        color: black;

    }

    .box {
        opacity: 0
    }
</style>


<script>
    angular.module('app', [])
        .controller('date_off', function($scope, $http, $compile) {


            var pi = $scope.pagingInfo = {
                itemsPerPage: 1,
                offset: 0,
                to: 0,
                currentPage: 1,
                totalPage: 1,
                total: 0
            };


            $scope.init = () => {
                $('.box').css('opacity', '1');
                $scope.p1 = {};
                $scope.p1 = angular.copy(pi);
                $scope.p1.itemsPerPage = 5;
                $scope.p1.id = 1;

                $scope.p = {};
                $scope.p = angular.copy(pi);
                $scope.p.itemsPerPage = 20;
                $scope.p.id = 0;

                $scope.filter = {};
                $scope.filter.is_registed = 2;
                $scope.filter.limit = $scope.p.itemsPerPage;
                $scope.filter.offset = $scope.p.offset;

                $scope.filter1 = {};
                $scope.filter1.limit = $scope.p1.itemsPerPage;
                $scope.filter1.offset = $scope.p1.offset;

                $scope.care = {};
                $scope.student = {};
                $scope.genHtml('care_data', 'p1', '#p1')
                $scope.genHtml('ajax_data', 'p', '#p')
                $scope.getDataStudent($scope.filter.is_registed);

            }

            $scope.openInforModal = (item) => {
                $scope.current_student = angular.copy(item);
                $scope.current_student.is_registed = parseInt($scope.current_student.is_registed);
                console.log(item);

                $('#infor').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            $scope.clickOutSide = () => {


                $scope.list_key = [];
            }
            $scope.clickKey = (name) => {
                $scope.care.name_care = angular.copy(name);
                $scope.list_key = [];
            }
            $scope.changeCare = () => {
                $http.get(base_url + 'admin/member/ajax_get_care_tag?filter=' + JSON.stringify($scope.care.name_care)).then(r => {
                    if (r && r.data.status == 1) {
                        $scope.list_key = r.data.data;
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }
            $scope.openCareModal = (item) => {
                $scope.current_student = angular.copy(item);

                $scope.getStudentCare($scope.current_student.id);
                $('#care').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            $scope.saveStudentCare = () => {
                $scope.care.student_id = $scope.current_student.id;
                $http.post(base_url + 'admin/member/ajax_save_student_care', JSON.stringify($scope.care)).then(r => {
                    if (r && r.data.status == 1) {
                        toastr["success"]("Tạo thành công!");
                        $scope.getStudentCare($scope.care.student_id);
                        $scope.getDataStudent();
                        $scope.care = {};
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }



            $scope.genHtml = (data_name, value_name, id) => {
                var $html = $(`<div class="dt-toolbar-footer">
                    <div class="col-sm-6 col-xs-12 hidden-xs">
                        <div ng-show="${data_name}.length > 0" class="dataTables_info" role="status" aria-live="polite">Hiển thị từ
                            {{${value_name}.offset
                        + 1}} đến {{ (${value_name}.offset + ${value_name}.itemsPerPage) > ${value_name}.total ? ${value_name}.total
                        : (${value_name}.offset
                        + ${value_name}.itemsPerPage)}} trong tổng {{${value_name}.total}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div ng-show="${data_name}.length > 0" class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li ng-disable="${value_name}.currentPage==1"><span class="previous" ng-click="Previous(${value_name}.currentPage,${value_name})">Previous</span>
                                </li>
                                <li ng-if="${value_name}.currentPage > 4"><span href="#" ng-click="go2Page(1,${value_name})">1</span></li>
                                <li class="disabled" ng-if="${value_name}.currentPage > 4"><span href="#" onclick="event.preventDefault()">…</span>
                                </li>
                                <li ng-repeat="i in getRange(${value_name})" ng-class="{active: ${value_name}.currentPage == i}"><span href="#" class="pageIndex" ng-click="go2Page(i,${value_name})">{{i}}</span>
                                </li>
                                <li class="disabled" ng-if="(${value_name}.totalPage - currentPage) > 3"><span href="#" onclick="event.preventDefault()">…</span>
                                </li>
                                <li ng-if="(${value_name}.totalPage - ${value_name}.currentPage) > 3"><span ng-click="go2Page(${value_name}.totalPage,${value_name})" class="">{{${value_name}.totalPage}}</span></li>
                                <li><span class="next" ng-click="${value_name}.currentPage != ${value_name}.totalPage && go2Page(${value_name}.currentPage + 1,${value_name})">Next</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                `).appendTo(id);

                $compile($html)($scope);
            }

            $scope.getStudentCare = (id) => {
                $scope.filter1.id = id;
                $http.get(base_url + 'admin/member/ajax_get_student_care?filter=' + JSON.stringify($scope.filter1)).then(r => {
                    if (r && r.data.status == 1) {

                        $scope.care_data = r.data.data;
                        $scope.p1.total = parseInt(r.data.count);
                        $scope.p1.totalPage = Math.ceil(r.data.count / $scope.p1.itemsPerPage);
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }

            $scope.addStudent = () => {
                $http.post(base_url + 'admin/member/ajax_save_academy_student', JSON.stringify($scope.student)).then(r => {
                    if (r && r.data.status == 1) {
                        $scope.getDataStudent();
                        $scope.student = {};
                        toastr["success"]("Tạo thành công!");
                    } else if (r && r.data.status == 0) {
                        toastr["error"]("Số điện thoại đã tồn tại!");
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }
            $scope.saveStudent = () => {
                $scope.student = $scope.current_student;
                console.log($scope.student);

                $scope.addStudent();
            }




            $scope.getDataStudent = (is_registed) => {
                $scope.filter.is_registed = is_registed;
                $http.get(base_url + 'admin/member/ajax_get_academy_student?filter=' + JSON.stringify($scope.filter)).then(r => {
                    if (r && r.data.status == 1) {
                        $scope.ajax_data = r.data.data;
                        $scope.p.total = parseInt(r.data.count);
                        $scope.p.totalPage = Math.ceil(r.data.count / $scope.p.itemsPerPage);
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }

            $scope.dateInputInit = () => {
                if ($('.date').length) {
                    //var start = $scope.start;
                    //var end = $scope.end;
                    if (typeof start === "undefined") {
                        start = end = moment().format("MM/DD/YYYY");
                    }
                    setTimeout(() => {
                        $('.date').daterangepicker({
                            opens: 'right',
                            alwaysShowCalendars: true,
                            startDate: moment(),
                            endDate: moment(),
                            ranges: {
                                'Hôm nay': [moment(), moment()],
                                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                                '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            }
                        });
                    }, 100);
                }
            }

            $scope.go2Page = function(page, item) {
                if (page < 0) return;
                var pi = item;
                pi.currentPage = page;
                pi.from = pi.offset = (pi.currentPage - 1) * pi.itemsPerPage;
                if (pi.id == 1) {
                    $scope.filter1.limit = pi.itemsPerPage;
                    $scope.filter1.offset = pi.offset;
                    $scope.getStudentCare($scope.current_student.id);
                } else {
                    $scope.filter.limit = pi.itemsPerPage;
                    $scope.filter.offset = pi.offset;
                    $scope.getDataStudent();
                }

                pi.to = pi.total < pi.itemsPerPage ? pi.total : pi.itemsPerPage
            }

            $scope.Previous = function(page, item) {
                if (page - 1 > 0) $scope.go2Page(page - 1, item);
                if (page - 1 == 0) $scope.go2Page(page, item);
            }

            $scope.getRange = function(paging) {
                var max = paging.currentPage + 3;
                var total = paging.totalPage + 1;
                if (max > total) max = total;
                var min = paging.currentPage - 2;
                if (min <= 0) min = 1;
                var tmp = [];
                return _.range(min, max);
            }

        });
</script>