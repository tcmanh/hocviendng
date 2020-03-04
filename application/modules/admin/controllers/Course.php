<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Course extends Admin_Controller {
	public $title_mail = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('course_model', 'course');
		$this->load->model('course_member_model', 'course_member');
		$this->load->model('course_member_checkin_model', 'course_member_checkin');
		$this->load->model('class_model', 'class');
		$this->load->helper("file");
		if ($this->mAction!='index')
		{
			$this->push_breadcrumb('Quản lý khóa học', site_url('admin/course'));
		}
	}
	public function index(){	
		$this->mTitle = "Danh sách khóa học";
		$this->db->select('*');
		if($this->input->get('filter')){
			if($this->input->get('code')){
	         	$this->db->like('code', $this->input->get('code') );
	      	}
	      	if($this->input->get('name')){
	         	$this->db->like('name', $this->input->get('name') );
	      	}
		}
		if(!$this->session->userdata('course_status')){
			$this->session->set_userdata('course_status', 'all');
		}
		if($this->input->get('course_status')){
			$this->session->set_userdata('course_status', $this->input->get('course_status'));
		}

		if($this->session->userdata('course_status') == 'wait'){
			$this->db->where('status', 1 );
			$this->db->where('date_added >=', date('Y-m-d') );
			$this->db->order_by('date_added', 'asc');

		}else if ($this->session->userdata('course_status') == 'done'){
     		$this->db->where('status', 0 );
     	}
     	else if ($this->session->userdata('course_status') == 1){
     		$this->db->where('status', 1 );
     	}

		$this->db->order_by('created', 'desc');
		$details = $this->db->get('course')->result();
		$this->mViewData['details'] = $details;
		$this->render('course/index');
	}
	function add(){
		$this->mTitle = "Thêm khóa học";
		$this->render('course/add');
		if(isset($_POST['add-course'])){
			$data = array();
			$data['code'] = $_POST['code'];
			$data['name'] = $_POST['name'];
			$data['user_id'] = $_POST['user_id'];
			$data['import_id'] = get_current_user_id();
			$data['describe'] = $_POST['describe'];
			$data['date_added'] = $_POST['date_added'];
			$data['date_end'] = $_POST['date_end'];
			$data['status'] = $_POST['status'];
			$data['note'] = $_POST['note'];
			if(isset($_POST['id'])){
				$id = (int)$_POST['id'];
				$this->course->update_by(array('id' => $id),$data);
			}
			else{
				$data['created'] = date('Y-m-d');
				$this->course->insert($data);
			}
			redirect('admin/course/');
		}
	}

	function detail($id){
		$this->mTitle = "Lịch sử điểm danh";
		$course = $this->course_member_checkin->order_by('date','asc')->get_many_by(array('course_member_id' => $id));
		$today = date('Y-m-d');
		$list_checkin = array();
		foreach ($course as $key => $value) {
			if($key == 0){
				$this->mViewData['defaultDate'] = $value->date;
			}
			$list_checkin[$key] = new stdClass();
			$list_checkin[$key]->date = '- '.abs(strtotime($today) - strtotime($value->date)) / (60 * 60 * 24);
			if($value->status == 1){
				$list_checkin[$key]->title = 'Có mặt';
				$list_checkin[$key]->color = '#00bb9c';
			}
			else{
				if($value->status == 2){
					$list_checkin[$key]->title = 'Vắng có phép: '.$value->note;
					$list_checkin[$key]->color = '#fa9b00';
				}
				else{
					$list_checkin[$key]->title = 'Vắng không phép: '.$value->note;
					$list_checkin[$key]->color = '#f37261';
				}
			}
		}

		$this->mViewData['list_checkin'] = $list_checkin;
		$this->render('course/detail');
	}

	function views($id = ''){
		$this->mTitle = "Điểm danh";
		if($id){
			$course = $this->course->get($id);
			//$course_member = $this->course_member->get_many_by(array('course_id' => $course->id ));
			$course_member = $this->db->query('SELECT * FROM course_member WHERE course_id = '.$course->id.' AND status < 2 ')->result();
		}elseif($course_id = $this->input->get('course')){
			$course_member = $this->db->query('SELECT course_member.id, course_member.member_id, course_member.status FROM course_member, member WHERE course_member.member_id = member.id AND course_id IN ('.$course_id.') AND course_member.status < 2 ORDER BY member.name asc ')->result();
		}
		$list_class = array();
		foreach ($course_member as  $value) {
			if(is_teacher()){
				if($value->class_id == 0){
					if($value->course_id == get_current_user_id()){
						$list_class[$value->class_id][] = $value;
					}

				}else{
					if($value->class_id == get_current_user_id()){
						$list_class[$value->class_id][] = $value;
					}
				}
			}else{
				$list_class[$value->class_id][] = $value;
			}
		}
		$this->mViewData['list_class'] = $list_class;
		$this->render('course/views');
		
	}
	function checkin(){
		$course_member_id = $_POST['course_member_id'];
		$note = $_POST['note'];
		$status = $_POST['status'];
		$this->course_member_checkin->delete_by(array('course_member_id'=>$course_member_id, 'date' =>date('Y-m-d')));
		$data = array(
			'date' => date('Y-m-d'),
			'status' => $status,
			'note' => $note,
			'created' => date('Y-m-d H:i:s'),
			'import_id' => get_current_user_id(),
			'course_member_id' => $course_member_id
		);
		if($this->course_member_checkin->insert($data)){
			echo 'success';
			die;
		}
		else{
			echo 'error';
			die;
		}
	}

	function edit($id){
		$this->mTitle = "Sửa khóa học";
		$course = $this->course->get($id);
		$this->mViewData['course'] = $course;
		$this->render('course/edit');
	}

	function course_class(){
		$this->mTitle = "Lớp học";
		$this->db->select('A.*');
		$this->db->from('class as A');
		$this->db->join('course as B', 'B.id = A.course_id');
		$results = $this->db->get()->result();
		$this->mViewData['results'] = $results;
		$this->render('course/class');
	}

	function add_class(){
		$this->mTitle = "Thêm lớp học";
		$this->render('course/class_add');
	}

	function edit_class($id){
		$this->mTitle = "Thêm lớp học";
		$class = $this->class->get($id);
		$this->mViewData['class'] = $class;
		$this->render('course/class_edit');
	}

	function delete_class($id){
		$class = $this->class->get($id);
		if($class->created < date('Y-m-d').' 00:00:00'){
			echo '<pre>';print_r('Không thể xóa lớp hôm trước');echo '</pre>';die();
		}
		else{
			$this->class->delete($id);
			redirect('admin/course/course_class');
		}
	}

	function save_class(){
		if(isset($_POST['add-class'])){
			$data = array();
			$data['course_id'] = $_POST['course_id'];
			$data['name'] = $_POST['name'];
			$data['user_id'] = $_POST['user_id'];
			$data['import_id'] = get_current_user_id();
			$data['note'] = $_POST['note'];
			if(isset($_POST['id'])){
				$id = (int)$_POST['id'];
				$this->class->update_by(array('id' => $id),$data);
			}
			else{
				$data['created'] = date('Y-m-d H:i:s');
				$this->class->insert($data);
			}
			redirect('admin/course/course_class');
		}else{
			redirect('admin/404');
		}
	}

	function member_class($id){

		if(isset($_POST['class_transfer'])){
			$member_id = $_POST['member_id'];
			$class_id = $_POST['class_id'];
			foreach ($_POST['member_id'] as $key => $value) {
				echo '<pre>';print_r($value);echo '</pre>';
				$this->course_member->update( $value, array('class_id' => $_POST['class_id']));
			}
			redirect($this->uri->uri_string());
		}
		$this->mTitle = "Chia lớp học";
		$class = $this->class->get($id);
		$course = $this->course->get($class->course_id);
		$list_class = $this->class->get_many_by(array('course_id' => $course->id));
		$course_member = $this->course_member->get_many_by(array('course_id' => $class->course_id, 'status' => 0));
		$this->mViewData['list_class'] = $list_class;
		$this->mViewData['course'] = $course;
		$this->mViewData['course_member'] = $course_member;
		$this->render('course/member_class');
	}

	function course_name(){

		$id = $_POST['id'];
		$course = $this->course->get($id);
		echo $course->name;die;
	}

}
