<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/
$config['ci_bootstrap'] = array(
	// Site name
	'site_name' => 'Admin Panel',
	// Default page title prefix
	'page_title_prefix' => '',
	// Default page title
	'page_title' => '',
	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),
	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			'assets/dist/admin/adminlte.min.js',
			'assets/dist/admin/lib.min.js',
			'assets/dist/admin/app.min.js',
			'assets/plugins/select2/select2.full.min.js',
			'assets/plugins/datatables/jquery.dataTables.min.js',
			'assets/plugins/datatables/dataTables.bootstrap.min.js',
			'assets/plugins/toastr-master/build/toastr.min.js',
			'assets/plugins/iCheck/icheck.min.js',
			'assets/plugins/sweetalert/sweetalert.min.js',
			'assets/plugins/sweetalert/sweetalert-dev.js',
			'assets/plugins/fullcalendar/moment.min.js',	
			'assets/plugins/fullcalendar/fullcalendar.js',	
			'assets/plugins/fullcalendar/lang-all.js',
			'assets/plugins/daterangepicker/daterangepicker.js',	
			'assets/plugins/jQueryUI/jquery-ui.min.js',
		),
		'foot'	=> array(
			'assets/dist/admin/binhduong.js',
		),
	),
	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/dist/admin/adminlte.min.css',
			'assets/dist/admin/lib.min.css',
			'assets/dist/admin/app.min.css',
			'assets/dist/admin/binhduong.css',
			'assets/plugins/select2/select2.min.css',
			'assets/plugins/datatables/dataTables.bootstrap.css',
			'assets/plugins/sweetalert/sweetalert.css',
			'assets/plugins/daterangepicker/daterangepicker-bs3.css',
			'assets/plugins/jQueryUI/jquery-ui.min.css',
			'assets/plugins/datatables/jquery.dataTables.min.css',
			'assets/plugins/fullcalendar/fullcalendar.min.css'
		)
	),
	// Default CSS class for <body> tag
	'body_class' => '',
	// Multilingual settings
	'languages' => array(
	),
	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Trang chủ',
			'url'		=> '',
			'icon'		=> 'fa fa-home',
		),
		'member' => array(
			'name'		=> 'Học viên',
			'url'		=> 'member',
			'icon'		=> 'fa fa-user',
			'children'  => array(
				'Danh sách'		=> 'member/lists',
				'Doanh số'		=> 'member',
			)
		),
		'course' => array(
			'name'		=> 'Khóa học',
			'url'		=> 'course',
			'icon'		=> 'fa fa-copy',
			'children'  => array(
				'Khóa học'			=> 'course',
				'Lớp học'		=> 'course/course_class',
			)
		),
		'revenue' => array(
			'name'		=> 'Doanh số',
			'url'		=> 'revenue',
			'icon'		=> 'fa fa-money',
		),
		'setting' => array(
			'name'		=> 'Cài đặt',
			'url'		=> 'setting',
			'icon'		=> 'fa fa-cogs',
			'children'  => array(
				'Cài đặt chung'	=> 'setting',
				'SMS'			=> 'setting/sms',
			)
		),
		'logout' => array(
			'name'		=> 'Đăng xuất',
			'url'		=> 'panel/logout',
			'icon'		=> 'fa fa-sign-out',
		)
	),
	// Login page
	'login_url' => 'admin/login',
	// Restricted pages
	'page_auth' => array(
		'user/create'				=> array('webmaster'),
		'user/group'				=> array('webmaster'),
		'panel'						=> array('webmaster'),
		'panel/admin_user'			=> array('webmaster'),
		'panel/admin_user_create'	=> array('webmaster'),
		'panel/admin_user_group'	=> array('webmaster'),
		'util'						=> array('webmaster', 'admin'),
		'util/list_db'				=> array('webmaster', 'admin'),
		'util/backup_db'			=> array('webmaster', 'admin'),
		'util/restore_db'			=> array('webmaster', 'admin'),
		'util/remove_db'			=> array('webmaster', 'admin'),
		//'course'					=> array('webmaster', 'admin'),
		//'member'					=> array('webmaster', 'admin'),
		//'revenue'					=> array('webmaster', 'admin'),
	),
	// AdminLTE settings
	'adminlte' => array(
		'body_class' => array(
			'webmaster'	=> 'skin-red',
			'admin'		=> 'skin-purple',
			'manager'	=> 'skin-black',
			'staff'		=> 'skin-blue',
		)
	),
	// Useful links to display at bottom of sidemenu
	'useful_links' => array(
		/*
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Trang chủ',
			'url'		=> '',
			'target'	=> '_blank',
			'color'		=> 'text-aqua'
		),
		array(
			'auth'		=> array('webmaster', 'admin'),
			'name'		=> 'API Site',
			'url'		=> 'api',
			'target'	=> '_blank',
			'color'		=> 'text-orange'
		),
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Github Repo',
			'url'		=> CI_BOOTSTRAP_REPO,
			'target'	=> '_blank',
			'color'		=> 'text-green'
		),
		*/
	),
	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);
/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';