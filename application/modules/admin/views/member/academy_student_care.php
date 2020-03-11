<link href="../assets/plugins/checkbox/icheck-material.min.css" rel="stylesheet" type="text/css">
<link href="../assets/plugins/toastr-master/build/toastr.min.css" rel="stylesheet" type="text/css">
<link href="../assets/plugins/timepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css">

<script src="../assets/plugins/angularjs/angularjs.min.js"></script>
<script src="../assets/plugins/lodash/lodash.js"></script>
<script src="../assets/plugins/toastr-master/build/toastr.min.js"></script>
<script src="../assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>


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
                                        <div class="flex flex-bt">
                                            <div style="width: 80%">
                                                <select name="" class="form-control" id="" ng-model="care.name_care">
                                                    <option ng-repeat="(index,value) in list_key" value="{{value.name}}">{{value.name}}</option>
                                                </select>
                                            </div>
                                            <div style="width: 20%" class="text-right">
                                                <div class="btn btn-success">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- <div tabindex="-1" class="input-dropdown">
                                            <input type="text" class="form-control" ng-blur="clickOutSide()" ng-model="care.name_care" ng-change="changeCare()" ng-focus="changeCare()">
                                            <ul id="myUL">
                                                <li class="cursor" ng-repeat="(index,value) in list_key" ng-mousedown="clickKey(value.name,value.id)">
                                                    <a>{{value.name}}</a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="form-group" ng-class="{'hidden':care.name_care!='Chốt lịch hẹn'}">
                                        <strong>
                                            Ngày hẹn:
                                        </strong>
                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control datepicker" ng-model="care.date" name="date_start" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'hidden':care.name_care!='Chốt lịch hẹn'}">
                                        <strong>
                                            Giờ:
                                        </strong>
                                        <div class="input-group bootstrap-timepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" class="form-control timepicker" ng-model="care.time" name="time" value="">
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
                                                <td class="text-center">
                                                    <div class="label label-danger" ng-click="deleteCare(value)">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="p1"></div>
                            </div>
                            <div class="wrap-appoinment">
                                <h4 class="title" style="padding-bottom: 0">
                                    Lịch sử hẹn
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="padding-top: 30px">
                                        <thead style="background: white">
                                            <tr>
                                                <th class="text-center">
                                                    Ngày hẹn
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
                                            <tr ng-repeat="(index,value) in app_data">
                                                <td class="text-center">
                                                    {{value.arrival_time}}
                                                </td>
                                                <td>
                                                    {{value.import_name}}
                                                </td>
                                                <td class="text-center">
                                                    <span ng-if="value.arrival_status==0" style="width: 70px;display: inline-block" class="label label-warning text-center"> Chưa tới </span>
                                                    <span ng-if="value.arrival_status==1" style="width: 70px;display: inline-block" class="label label-success text-center"> Đã tới </span>
                                                    <span ng-if="value.arrival_status==-1" style="width: 70px;display: inline-block" class="label label-danger text-center">Không tới </span>
                                                </td>
                                                <td class="text-center">
                                                    <!-- <div class="label label-danger" ng-click="deleteCare(value)">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div> -->
                                                    <div class="excute">
                                                        <div class="dropdown" style="display: inline-block">
                                                            <span style="width:100px;cursor: pointer;padding: 5px 8px;border:1px solid rgb(20, 20, 148);border-radius: 5px;color:rgb(20, 20, 148)" data-toggle="dropdown">
                                                                Thao tác <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                            </span>
                                                            <ul class="dropdown-menu" style="    left: unset;right: 100%; top: 50%;transform: translateY(-50%)">
                                                                <li ng-if="value.arrival_status==0">
                                                                    <a class="cursor" ng-click="changeStatusApp(value,1)">
                                                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                                        Xác nhận khách tới
                                                                    </a>
                                                                </li>
                                                                <li ng-if="value.arrival_status==0">
                                                                    <a class="cursor" ng-click="changeStatusApp(value,-1)">
                                                                        <i class="fa fa-ban text-warning" aria-hidden="true"></i>
                                                                        Xác nhận khách không tới
                                                                    </a>
                                                                </li>
                                                                <li ng-if="value.arrival_status!=0">
                                                                    <a class="cursor" ng-click="changeStatusApp(value,0)">
                                                                        <i class="fa fa-undo text-warning" aria-hidden="true"></i>
                                                                        Hoàn tác
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="cursor" ng-click="deleteCare(value)">
                                                                        <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                                        Xóa
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="p2"></div>
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
                                    <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/,'').replace(/\D/g,'')" class="form-control" ng-model="current_student.phone">
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
                                        Khu vực:
                                    </strong>
                                    <select class="form-control" ng-model="current_student.area" name="area" />
                                    <option value="HCM">Hồ Chí Minh</option>
                                    <option value="DN">Đà Nẵng</option>
                                    <option value="CT">Cần Thơ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Địa chỉ:
                                            </strong>
                                            <input type="text" class="form-control" ng-model="current_student.address">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <strong>
                                            Giới tính:
                                        </strong>
                                        <div>
                                            <label style="margin-right: 20px">
                                                <input type="radio" name="gender" ng-checked="current_student.gender" ng-model="current_student.gender" value="1" /> Nữ
                                            </label>
                                            <label>
                                                <input type="radio" name="gender" ng-checked="current_student.gender" ng-model="current_student.gender" value="0" /> Nam
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Số chứng minh:
                                            </strong>
                                            <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/,'').replace(/\D/g,'')" class="form-control" ng-model="current_student.identity_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Ngày cấp:
                                            </strong>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control datepicker" ng-model="current_student.id_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="icheck-material-green">
                                    <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-checked="current_student.is_registed" ng-model="current_student.is_registed" id="green" />
                                    <label for="green">Học viên chính thức</label>
                                </div>
                            </div> -->



                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <input type="button" class="btn btn-success" value="Chuyển thành học viên" ng-click="toRegister()">
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
                        <form role="form" ng-submit="addStudent()" style="max-width: 250px">
                            <div class="input-group other">
                                <input type="text" style="height: 32px" onkeyup="this.value=this.value.replace(/[^\d]/,'').replace(/\D/g,'')" ng-model="student.phone" class="form-control" placeholder="Nhập số điện thoại">
                                <div class="input-group-addon">
                                    <input type="submit" class="input-group-addon" value="Tạo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="line" style="border: 1px dashed #cea9a9;margin: 10px 0;"></div>
                <div class="form">
                    <div class="form-group">
                        <div class="flex flex-bt" style="display: flex;justify-content:space-between">
                            <strong class="span">
                                Ngày chăm sóc:
                            </strong>
                            <span style="color:#bf0000;margin-right: 5px;cursor: pointer" class="cursor" ng-click="setUnDate()" ng-if="filter.date">
                                <i class="fa fa-window-close" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="date text-center form-control" name="date_filter" ng-model="filter.date" class="">
                        </div>
                    </div>
                    <div class="form-group">
                        <STRONG>
                            Trạng thái chăm vừa qua:
                        </STRONG>
                        <select name="" class="form-control" id="" ng-model="filter.status_care">
                            <option ng-repeat="(index,value) in list_key" value="{{value.id}}">{{value.name}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <STRONG>
                            Lực chọn:
                        </STRONG>
                        <select name="" id="" class="form-control" ng-model="filter.option">
                            <option value="1">
                                Số lần chăm sóc
                            </option>
                            <option value="2">
                                Ngày chăm sóc
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <STRONG>
                            Sắp xếp:
                        </STRONG>
                        <select name="" id="" class="form-control" ng-model="filter.sort">
                            <option value="1">
                                Tăng dần
                            </option>
                            <option value="2">
                                Giảm dần
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div style="margin-top: 19px">

                        </div>
                        <div class="btn btn-primary" ng-click="getDataStudent(0)">
                            Tải dữ liệu
                        </div>
                    </div>

                </div>

                <ul class="nav nav-tabs">
                    <!-- <li ng-class="{'active':filter.is_registed==2}" class="cursor" ng-click="getDataStudent(2)"><a><i class="fa fa-list" aria-hidden="true"></i> Tất cả</a></li>
                    <li ng-class="{'active':filter.is_registed==1}" class="cursor" ng-click="getDataStudent(1)"><a><i class="fa fa-address-card" aria-hidden="true"></i> Đã đăng ký</a></li> -->
                    <li ng-class="{'active':filter.is_registed==0}" class="cursor" ng-click="getDataStudent(0)"><a><i class="fa fa-refresh" aria-hidden="true"></i> Chưa đăng ký</a></li>
                    <li class="pull-right" style="max-width: 250px">
                        <div class="input-group">
                            <input type="text" class="form-control " placeholder="Số điện thoại/tên" ng-model="filter.key" ng-change="getDataStudent(0)">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
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
    .flex {
        display: flex;
        flex-wrap: wrap;
    }

    .flex-bt {
        justify-content: space-between;
    }

    .content .form {
        display: flex;
        flex-wrap: wrap;
    }

    .content .form>div {
        width: 250px;
        margin-right: 15px;
        margin-bottom: 10px
    }

    .calendar.left,
    .calendar.right {
        display: block !important;
    }

    .daterangepicker_start_input,
    .daterangepicker_end_input {
        display: none;
    }

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

    .table {
        margin-bottom: 30px;
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
        .controller('date_off', function($scope, $http, $compile, $window) {


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

                $scope.p2 = {};
                $scope.p2 = angular.copy(pi);
                $scope.p2.itemsPerPage = 5;
                $scope.p2.id = 2;

                $scope.p = {};
                $scope.p = angular.copy(pi);
                $scope.p.itemsPerPage = 20;
                $scope.p.id = 0;

                $scope.filter = {};
                $scope.filter.is_registed = 0;
                $scope.filter.limit = $scope.p.itemsPerPage;
                $scope.filter.offset = $scope.p.offset;
                //  $scope.filter.date = moment().format("MM/DD/YYYY") + ' - ' + moment().format("MM/DD/YYYY");
                $scope.filter.option = '1';
                $scope.filter.sort = '1';

                $scope.filter1 = {};
                $scope.filter1.limit = $scope.p1.itemsPerPage;
                $scope.filter1.offset = $scope.p1.offset;

                $scope.filter2 = {};
                $scope.filter2.limit = $scope.p2.itemsPerPage;
                $scope.filter2.offset = $scope.p2.offset;

                $scope.care = {};
                $scope.student = {};
                $scope.dateInputInit();

                $scope.genHtml('app_data', 'p2', '#p2')
                $scope.genHtml('care_data', 'p1', '#p1')
                $scope.genHtml('ajax_data', 'p', '#p')
                $scope.getDataStudent($scope.filter.is_registed);
                $scope.changeCare();

            }

            $scope.changeStatusApp = (item, status) => {
                var data = {
                    id: item.id,
                    arrival_status: status
                }
                $http.post(base_url + 'admin/member/ajax_change_status_app', JSON.stringify(data)).then(r => {
                    if (r && r.data.status == 1) {
                        toastr["success"]("Thành công!");
                        $scope.getApp($scope.current_student.id);
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }

            $scope.setUnDate = () => {
                $scope.filter.date = undefined;
            }

            $scope.openInforModal = (item) => {
                $scope.current_student = angular.copy(item);
                $scope.current_student.is_registed = parseInt($scope.current_student.is_registed);

                $('#infor').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            $scope.clickOutSide = () => {


                $scope.list_key = [];
            }

            $scope.deleteCare = (item) => {
                $http.post(base_url + 'admin/member/ajax_delete_student_care', JSON.stringify(item)).then(
                    r => {
                        if (r && r.data.status == 1) {
                            toastr["success"]("Xóa thành công!");
                            $scope.getStudentCare($scope.current_student.id);
                            $scope.getApp($scope.current_student.id);
                        } else if (r && r.data.status == 0) {
                            toastr["error"]("Bạn không phải người tạo!");
                        } else toastr["error"]("Đã có lỗi xẩy ra!");
                    });
            }

            $scope.clickKey = (name, id) => {
                $scope.care.id = id;
                $scope.care.name_care = angular.copy(name);
                $scope.list_key = [];
            }
            $scope.changeCare = () => {
                $http.get(base_url + 'admin/member/ajax_get_care_tag?filter=' + JSON.stringify($scope.care
                    .name_care)).then(r => {
                    if (r && r.data.status == 1) {
                        $scope.list_key = r.data.data;
                    } else toastr["error"]("Đã có lỗi xẩy ra!");
                });
            }
            $scope.openCareModal = (item) => {
                $scope.current_student = angular.copy(item);

                $scope.getStudentCare($scope.current_student.id);
                $scope.getApp($scope.current_student.id);
                $('#care').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            $scope.saveStudentCare = () => {
                if (!$scope.care.name_care || $scope.care.name_care == "") {
                    toastr["error"]("Không để trống tên tag!");
                    return false;
                }
                console.log($scope.care.date, $scope.care.time);

                if ($scope.care.name_care == 'Chốt lịch hẹn' && (!$scope.care.date || $scope.care.date == '' || !$scope.care.time || $scope.care.time == '')) {
                    toastr["error"]("Nhập thời gian cho lịch hẹn!");
                    return false;
                }

                $scope.care.student_id = $scope.current_student.id;
                $http.post(base_url + 'admin/member/ajax_save_student_care', JSON.stringify($scope.care)).then(
                    r => {
                        if (r && r.data.status == 1) {
                            toastr["success"]("Tạo thành công!");
                            $scope.getStudentCare($scope.care.student_id);

                            $scope.getApp($scope.care.student_id)
                            $scope.getDataStudent(0);
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
                $http.get(base_url + 'admin/member/ajax_get_student_care/1?filter=' + JSON.stringify($scope.filter1))
                    .then(r => {
                        console.log(r);

                        if (r && r.data.status == 1) {

                            $scope.care_data = r.data.data;
                            $scope.p1.total = parseInt(r.data.count);
                            $scope.p1.totalPage = Math.ceil(r.data.count / $scope.p1.itemsPerPage);
                        } else toastr["error"]("Đã có lỗi xẩy ra!");
                    });
            }

            $scope.getApp = (id) => {
                $scope.filter2.id = id;
                $http.get(base_url + 'admin/member/ajax_get_student_care/2?filter=' + JSON.stringify($scope.filter1))
                    .then(r => {
                        console.log(r);

                        if (r && r.data.status == 1) {
                            $scope.app_data = r.data.data;
                            $scope.p2.total = parseInt(r.data.count);
                            $scope.p2.totalPage = Math.ceil(r.data.count / $scope.p2.itemsPerPage);
                        } else toastr["error"]("Đã có lỗi xẩy ra!");
                    });
            }


            $scope.addStudent = () => {
                if (!$scope.student.phone || $scope.student.phone == "") {
                    toastr["error"]("Không để trống số điện thoại!");
                    return false;
                }
                $http.post(base_url + 'admin/member/ajax_save_academy_student', JSON.stringify($scope.student))
                    .then(r => {
                        if (r && r.data.status == 1) {
                            $scope.getDataStudent(0);
                            $scope.student = {};
                            toastr["success"]("Tạo thành công!");
                        } else if (r && r.data.status == 0) {
                            toastr["error"]("Số điện thoại đã tồn tại!");
                        } else toastr["error"]("Đã có lỗi xẩy ra!");
                    });
            }
            $scope.saveStudent = () => {
                $scope.student = $scope.current_student;

                $scope.addStudent();
            }

            $scope.toRegister = () => {
                console.log($scope.current_student);

                if (!$scope.current_student.name || $scope.current_student.name == '') {
                    toastr["error"]("Thiếu tên!");
                    return false;
                }
                if (!$scope.current_student.phone || $scope.current_student.phone == '') {
                    toastr["error"]("Thiếu số điện thoại!");
                    return false;
                }
                if (!$scope.current_student.date || $scope.current_student.date == '') {
                    toastr["error"]("Thiếu ngày sinh!");
                    return false;
                }
                if (!$scope.current_student.address || $scope.current_student.address == '') {
                    toastr["error"]("Thiếu địa chỉ liên lạc!");
                    return false;
                }
                if (!$scope.current_student.gender) {
                    toastr["error"]("Thiếu giới tính!");
                    return false;
                }
                if (!$scope.current_student.area) {
                    toastr["error"]("Thiếu khu vực!");
                    return false;
                }
                if (!$scope.current_student.identity_number || $scope.current_student.identity_number == '') {
                    toastr["error"]("Thiếu số chứng minh nhân dân!");
                    return false;
                }
                if (!$scope.current_student.id_date || $scope.current_student.id_date == '') {
                    toastr["error"]("Thiếu ngày cấp!");
                    return false;
                }



                $http.post(base_url + 'admin/member/ajax_register', JSON.stringify($scope.current_student))

                    .then(r => {

                        if (r && r.data.status == 1) {
                            $scope.getDataStudent(0);

                            $scope.student = {};
                            toastr["success"]("Tạo thành công!");
                            $('#infor').modal('hide');
                            $window.open(base_url + 'admin/member/edit/' + r.data.data, '_blank');
                        } else if (r && r.data.status == 0) {
                            toastr["error"]("Số điện thoại đã tồn tại!");
                        } else toastr["error"]("Đã có lỗi xẩy ra!");
                    });
            }


            $scope.getDataStudent = (is_registed) => {
                $scope.filter.is_registed = is_registed;
                $http.get(base_url + 'admin/member/ajax_get_academy_student?filter=' + JSON.stringify($scope
                    .filter)).then(r => {
                    console.log(r);

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
                                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1,
                                    'days')],
                                '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                                '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                                'Tháng trước': [moment().subtract(1, 'month').startOf('month'),
                                    moment().subtract(1, 'month').endOf('month')
                                ]
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
                } else if (pi.id == 2) {
                    $scope.filter2.limit = pi.itemsPerPage;
                    $scope.filter2.offset = pi.offset;
                    $scope.getApp(0);
                } else {
                    $scope.filter.limit = pi.itemsPerPage;
                    $scope.filter.offset = pi.offset;
                    $scope.getDataStudent(0);
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