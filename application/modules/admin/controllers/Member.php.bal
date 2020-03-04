<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends Admin_Controller {
	public $title_mail = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('member_model', 'member');
		$this->load->model('course_member_model', 'course_member');
		$this->load->model('course_member_debit_model', 'course_member_debit');
		$this->load->model('course_member_result_model', 'course_member_result');
		$this->load->helper("file");
		if ($this->mAction!='index')
		{
			$this->push_breadcrumb('Quản lý học viên', site_url('admin/member'));
		}
	}
	public function index(){
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
		$this->mTitle = "Danh sách học viên";
		$this->db->select("member.id, member.import_id, member.created, member.avatar, member.code, member.name, member.phone, member.status ");
      	$this->db->from('member');
      	$this->db->join('course_member', 'member.id = course_member.member_id', 'left');
      	$this->db->group_by('member.id');
      	if($course_id = $this->input->get('course_id')){
			foreach ($course_id as $key => $value) {
				if($key == 0){
					$this->db->where('course_member.course_id', $value);
				}else{
					$this->db->or_where('course_member.course_id', $value);
				}
			}
		}
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->db->where('member.created >=', $start_date);
			$this->db->where('member.created <=', $end_date);
		}
		$this->db->order_by('member.created', 'desc');
      	if(!$this->session->userdata('member_status')){
			$this->session->set_userdata('member_status', 'all');
		}
		if($this->input->get('member_status')){
			$this->session->set_userdata('member_status', $this->input->get('member_status'));
		}
		if($this->session->userdata('member_status') == 'all'){
			$details = $this->db->get()->result();
		}else if ($this->session->userdata('member_status') == 'debit'){
			$result = $this->db->get()->result();
			$details = array();
			foreach ($result as $key => $package) {
				$course_member = $this->course_member->get_many_by(array('member_id' => $package->id));
                $debit = 0;
                foreach ($course_member as $value) {
                   $debit += $value->debit - get_course_member_debit($value->id);
                }
                if($debit > 0){
                	$details[$key] = new stdClass();
                	$details[$key] = $package;
                	$details[$key]->debit = $debit;
                }
			}
     	}
     	else if ($this->session->userdata('member_status') == 'done'){
     		$result = $this->db->get()->result();
			$details = array();
			foreach ($result as $key => $package) {
				$course_member = $this->course_member->get_many_by(array('member_id' => $package->id));
                $debit = 0;
                foreach ($course_member as $value) {
                   $debit += $value->debit - get_course_member_debit($value->id);
                }
                if($debit == 0){
                	$details[$key] = new stdClass();
                	$details[$key] = $package;
                	$details[$key]->debit = $debit;
                }
			}
     	}
     	else if ($this->session->userdata('member_status') == 'reserve'){
     		//echo '<pre>';print_r('Reserve');echo '</pre>';die();
     		$this->db->where('course_member.status', 2);
     		$details = $this->db->get()->result();
     	}
     	else if ($this->session->userdata('member_status') == 'off'){
     		//echo '<pre>';print_r('off');echo '</pre>';die();
     		$this->db->where('course_member.status', 3);
     		$details = $this->db->get()->result();
     	}
      	/*
      	$member_debit = $member_done = array();
      	foreach ($details as $key => $value) {
      		echo '<pre>';print_r($value);echo '</pre>';//die();	
      		$course_member = $this->course_member->get_many_by(array('member_id' => $value->id));
			$debit_total = $debit_visa = 0;
			foreach ($course_member as $course_mb) {
				$debit_total += get_course_member_debit($course_mb->id);
				$debit_visa += get_course_member_debit_visa($course_mb->id);
			}
			if($debit_total > 0){
				$member_debit[$key] = new stdClass();
				$member_debit[$key] = $value;
				$member_debit[$key]->debit_total = $debit_total;
				$member_debit[$key]->debit_visa = $debit_visa;
			}else{
				$member_done[$key] = new stdClass();
				$member_done[$key] = $value;
			}
      	}
      	echo '<pre>member_debit ';print_r($member_debit);echo '</pre>';
      	echo '<pre>member_done ';print_r($member_done);echo '</pre>';
		*/
      	//echo '<pre>';print_r($details);echo '</pre>';die();
      	$this->mViewData['details'] = $details;
		$this->render('member/index');
	}
	function add(){
		$this->mTitle = "Thêm học viên";
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
		$this->render('member/add');
		if(isset($_POST['add-member'])){
			$data = array();
			$data['code'] = $_POST['code'];
			$data['name'] = $_POST['name'];
			$data['phone'] = $_POST['phone'];
			$data['birthday'] = $_POST['birthday'];
			$data['gender'] = $_POST['gender'];
			$data['mail'] = $_POST['code'];
			$data['address'] = $_POST['address'];
			$data['import_id'] = get_current_user_id();
			$data['describe'] = $_POST['describe'];
			$data['note'] = $_POST['note'];
			if($_FILES['avatar']['size'] != 0){
				if(isset($_POST['picture'])){
					@unlink(base_url("assets/uploads/member/".$_POST['picture']));
	            	@unlink(base_url("assets/uploads/member_thumbs/".$_POST['picture']));
	        	}
	            $data['avatar'] = $this->member->upload_image('avatar'); 
	        }
			if(isset($_POST['id'])){
				$id = (int)$_POST['id'];
				$this->member->update_by(array('id' => $id),$data);
				$insert_id = $id;
			}
			else{
				$data['created'] = date('Y-m-d');
				$this->member->insert($data);
				$insert_id = $this->db->insert_id();
			}
			/*
			if($_POST['service_id'] != ''){
				$inser_course['member_id'] = $insert_id;
				$inser_course['course_id'] = $_POST['service_id'];
				$inser_course['import_id'] = get_current_user_id();
				$inser_course['debit'] = str_replace(array(',','.'), '', $_POST['debit'] );
				$inser_course['total'] = str_replace(array(',','.'), '', $_POST['total'] );
				$inser_course['pay'] = str_replace(array(',','.'), '', $_POST['pay'] );
				$inser_course['visa'] = str_replace(array(',','.'), '', $_POST['visa'] );
				$inser_course['amount'] = $inser_course['pay'] - $inser_course['visa'];
				$inser_course['created'] = date('Y-m-d');
				$inser_course['note'] = $_POST['note_course'];
				$this->db->insert('course_member', $inser_course);
			}
			*/
			redirect('admin/member/');
		}
	}
	function edit($id){
		$this->mTitle = "Sửa học viên";
		$member = $this->member->get_by(array('id' => $id));
		$this->mViewData['member'] = $member;
		$this->render('member/edit');
	}
	function views($id){
		if(is_teacher()){
			redirect('admin/permission');
		}
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;	
		$member_info = $this->member->get_many($id);
		$this->mViewData['member_info'] = $member_info;	
		$this->mViewData['id'] = $id;
		$array_service_id[] = '';
		$this->mTitle = "Thông tin học viên: ".$member_info[0]->name;
		$member_package = $this->course_member->get_bd_by(array('member_id' => $id));
		foreach ($member_package as $key => $value) {
			$member_package[$key]->result = $this->course_member_result->get_bd_by(array('course_member_id' => $value->id));
		}
		$this->mViewData['details'] = $member_package;
		$this->render('member/views');
		if(isset($_POST['add-package'])){
			$insert_id = $id;
			if(isset($_POST['service_id'])){
				for($i = 0; $i < count($_POST['service_id']); $i++){
					if(!in_array($_POST['service_id'][$i], $array_service_id) ) {
						$array_service_id[] = $_POST['service_id'][$i];
					    $data_package['member_id'] = $insert_id;
						$data_package['course_id'] = $_POST['service_id'][$i];
						$data_package['import_id'] = get_current_user_id();
						$data_package['debit'] = str_replace(array(',','.'), '', $_POST['debit'][$i] );
						$data_package['total'] = str_replace(array(',','.'), '', $_POST['total'][$i] );
						$data_package['pay'] = str_replace(array(',','.'), '', $_POST['pay'][$i] );
						$data_package['visa'] = str_replace(array(',','.'), '', $_POST['visa'][$i] );
						$data_package['amount'] = $data_package['pay'] - $data_package['visa'];
						$data_package['note'] = $_POST['note'][$i];
						$data_package['created'] = date('Y-m-d');
						$this->db->insert('course_member', $data_package);
					}
				}
			}
			redirect('admin/member/views/'.$id.'');
		}
		if(isset($_POST['transfer'])){
			if(isset($_POST['course_member_id'])){
				$course_member_id = $_POST['course_member_id'];
				$course_transfer_id = $_POST['course_transfer_id'];
				$this->course_member->update($course_member_id, array('course_id' => $course_transfer_id));
			}
			redirect('admin/member/views/'.$id.'');
		}
	}
	function debit($id){
		$details = $this->course_member->get_bd_by(array('id' => $id));
		$this->mTitle = "Nợ: ".number_format($details[0]->debit).' vnđ';
		$this->mViewData['debit'] = $details[0]->debit;
		$this->mViewData['details'] = $details;
		$info = $this->course_member_debit->get_bd_by(array('course_member_id' => $id));
		$this->mViewData['info'] = $info;
		$this->render('member/debit');
		if(isset($_POST['add-debit'])){
			if($_POST['price'] > 0){
				$data['course_member_id'] = $id;
				$data['created'] = date('Y-m-d');
				$data['price'] = str_replace(array(',','.'), '', $_POST['price'] );
				$data['visa'] = str_replace(array(',','.'), '', $_POST['visa'] );
				$data['amount'] = $data['price'] - $data['visa'];
				$data['note'] = $_POST['note'];
				$data['import_id'] = get_current_user_id();
				$this->db->insert('course_member_debit', $data);	
			}
			redirect('admin/member/debit/'.$id);
		}
	}
	function delete_debit($id){
		$course_member_debit = $this->course_member_debit->get($id);
		if($course_member_debit->created == date('Y-m-d') ){
			$this->course_member_debit->delete($id);
			redirect('admin/member/debit/'.$course_member_debit->course_member_id);
		}else{
			echo '<pre>';print_r('Không thể xóa từ hôm trước');echo '</pre>';die();
		}
	}
	function revenue(){
		$this->mTitle = 'Doanh số học viên';
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
		}else{
			$start_date = $end_date = date('Y-m-d');
		}
		$this->db->select("*");
		$this->db->from('course_member as A');
		$this->db->where('A.created >=', $start_date);
		$this->db->where('A.created <=', $end_date);
	 	if($this->input->get('user_id')){
			$user_id = $this->input->get('user_id');
			$this->db->where('G.user_id',$user_id);
		}
		$statistical = $this->db->get()->result(); 
		$this->mViewData['statistical']  = $statistical;
		$this->render('member/revenue');
	}
	function upload(){
		if(isset($_FILES['avatar'])){
			$data = array();
			$data['import_id'] = get_current_user_id();
			$data['created'] = date('Y-m-d');
			$data['course_member_id'] = $_POST['id'];
            $data['link'] = $this->member->upload_image('avatar'); 
			$this->course_member_result->insert($data);
			redirect('admin/member/views/'.$_POST['parent_id']);
		}
	}
	function delete($id){
		$course_member = $this->course_member->get($id);
		if($course_member->created == date('Y-m-d')){
			$this->course_member->delete($id);
			redirect('admin/member');
		}else{
			echo '<pre>';print_r('<h3>Không xóa được của ngày hôm trước</h3>');echo '</pre>';die();
		}
	}
	function del($id){
		$this->course_member->delete($id);
	}
	function invoice($id){
		$this->mTitle = 'In phiếu thu';
		$course_member = $this->course_member->get($id);
		$this->mViewData['member']  = get_member_name($course_member->member_id);
		$this->mViewData['code'] = $course_member->member_id;
		$this->mViewData['import_id'] = get_user_fullname($course_member->import_id);
		$this->mViewData['date']  = $course_member->created;
		$result[0] = new stdClass();
		$result[0]->name = get_course_name($course_member->course_id).'<br>('.number_format($course_member->total).')';
		$result[0]->price = $course_member->pay;
		$result[0]->content = 'Thanh toán lần đầu';
		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function list_invoice($member_id){
		$this->mTitle = 'In phiếu thu';
		$member = $this->member->get($member_id);
		$this->mViewData['member']  = $member->name;
		$this->mViewData['code'] = $member->code;
		$this->mViewData['date']  = date('d-m-Y');
		$this->mViewData['import_id'] = 'Nhiều nhân viên';
		$print = $this->input->get('print');
		$course_member = $this->db->query('SELECT * FROM course_member WHERE id IN ('.$print.') ORDER BY id asc ')->result();
		$result = array();
		$key = 0;
		foreach ($course_member as $value) {
			$result[$key] = new stdClass();
			$result[$key]->name = get_course_name($value->course_id).'<br>('.number_format($value->total).')';
			$result[$key]->price = $value->pay;
			$result[$key]->content = 'Thanh toán lần đầu<br>'.$value->created;
			$course_member_debit = $this->course_member_debit->get_many_by(array('course_member_id' => $value->id));
			foreach ($course_member_debit as $val) {
				$key++;
				$result[$key] = new stdClass();
				$result[$key]->name = get_course_name($value->course_id).'<br>('.number_format($value->total).')';
				$result[$key]->price = $val->price;
				$result[$key]->content = 'Thanh toán lần sau<br>'.$value->created;
			}
			$key++;
		}
		//echo '<pre>';print_r($result);echo '</pre>';die();
		/*
		$result = new stdClass();
		$result->name = get_course_name($course_member->course_id).'<br>('.number_format($course_member->total).')';
		$result->price = $course_member->pay;
		$result->content = 'Cọc học phí';
		*/
		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function invoice_debit($id){
		$this->mTitle = 'In phiếu thu';
		$course_member_debit = $this->course_member_debit->get($id);
		$course_member = $this->course_member->get($course_member_debit->course_member_id);
		$this->mViewData['member']  = get_member_name($course_member->member_id);
		$this->mViewData['code'] = $course_member->member_id;
		$this->mViewData['import_id'] = get_user_fullname($course_member_debit->import_id);
		$this->mViewData['date'] = $course_member_debit->created;
		$result[0] = new stdClass();
		$result[0]->name = get_course_name($course_member->course_id).'<br>('.number_format($course_member->total).')';
		$result[0]->price = $course_member_debit->price;
		$result[0]->content = 'Thanh toán lần sau';
		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function invoice_print(){
		$this->load->view('member/print');
		//$this->render('member/print');
	}
	function status($id){
		$result = $this->course_member->get($id);
		$this->mViewData['result'] = $result;
		$this->render('member/status');
		if(isset($_POST['save'])){
			$data = array(
				'status' => $_POST['status'],
				'status_date' => $_POST['status_date'],
				'status_note' => $_POST['status_note'],
				'status_created' => date('Y-m-d'),
				'status_import_id' => get_current_user_id(),
			);
			$this->course_member->update($id, $data);
			redirect($this->uri->uri_string());
		}
	}
}
