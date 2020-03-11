<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Member extends Admin_Controller
{
	public $title_mail = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('member_model', 'member');
		$this->load->model('course_member_model', 'course_member');
		$this->load->model('course_member_debit_model', 'course_member_debit');
		$this->load->model('course_member_result_model', 'course_member_result');
		$this->load->model('member_profile_model', 'member_profile');
		$this->load->helper("file");
		if ($this->mAction != 'index') {
			$this->push_breadcrumb('Quản lý học viên', site_url('admin/member'));
		}
	}
	public function index()
	{
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
		$this->mTitle = "Danh sách học viên";
		$this->db->select("member.id, member.code, member.import_id, member.created, member.avatar, member.name, member.phone, member.status ");
		$this->db->from('member');
		$this->db->join('course_member', 'member.id = course_member.member_id', 'left');
		$this->db->group_by('member.id');
		if ($course_id = $this->input->get('course_id')) {
			foreach ($course_id as $key => $value) {
				if ($key == 0) {
					$this->db->where('course_member.course_id', $value);
				} else {
					$this->db->or_where('course_member.course_id', $value);
				}
			}
		}
		if ($date_filter = $this->input->get('date_filter')) {
			$date = explode('-', $date_filter);
			$date_1 = explode('/', $date[0]);
			$date_2 = explode('/', $date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if ($date[0] == $date[1]) {
				$end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
			} else {
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->db->where('member.created >=', $start_date);
			$this->db->where('member.created <=', $end_date);
		}
		$this->db->order_by('member.created', 'desc');
		if (!$this->session->userdata('member_status')) {
			$this->session->set_userdata('member_status', 'all');
		}
		if ($this->input->get('member_status')) {
			$this->session->set_userdata('member_status', $this->input->get('member_status'));
		}
		if ($this->session->userdata('member_status') == 'all') {
			$details = $this->db->get()->result();
		} else if ($this->session->userdata('member_status') == 'debit') {
			$result = $this->db->get()->result();
			$details = array();
			foreach ($result as $key => $package) {
				$course_member = $this->course_member->get_many_by(array('member_id' => $package->id));
				$debit = 0;
				foreach ($course_member as $value) {
					$debit += $value->debit - get_course_member_debit($value->id);
				}
				if ($debit > 0) {
					$details[$key] = new stdClass();
					$details[$key] = $package;
					$details[$key]->debit = $debit;
				}
			}
		} else if ($this->session->userdata('member_status') == 'done') {
			$result = $this->db->get()->result();
			$details = array();
			foreach ($result as $key => $package) {
				$course_member = $this->course_member->get_many_by(array('member_id' => $package->id));
				$debit = 0;
				foreach ($course_member as $value) {
					$debit += $value->debit - get_course_member_debit($value->id);
				}
				if ($debit == 0) {
					$details[$key] = new stdClass();
					$details[$key] = $package;
					$details[$key]->debit = $debit;
				}
			}
		} else if ($this->session->userdata('member_status') == 'reserve') {
			//echo '<pre>';print_r('Reserve');echo '</pre>';die();
			$this->db->where('course_member.status', 2);
			$details = $this->db->get()->result();
		} else if ($this->session->userdata('member_status') == 'off') {
			//echo '<pre>';print_r('off');echo '</pre>';die();
			$this->db->where('course_member.status', 3);
			$details = $this->db->get()->result();
		}

		$this->mViewData['details'] = $details;
		$this->render('member/index');
	}

	function add()
	{
		$this->mTitle = "Thêm học viên";
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
		$this->render('member/add');
		if (isset($_POST['add-member'])) {
			$data = array();
			$data['name'] = $_POST['name'];
			$data['phone'] = $_POST['phone'];
			$data['birthday'] = $_POST['birthday'];
			$data['gender'] = $_POST['gender'];
			$data['mail'] = $_POST['mail'];
			$data['address'] = $_POST['address'];
			$data['import_id'] = get_current_user_id();

			$data['phone_contact'] = $_POST['phone_contact'];
			$data['address_contact'] = $_POST['address_contact'];
			$data['id_card'] = $_POST['id_card'];
			$data['id_date'] = $_POST['id_date'];
			$data['area'] = $_POST['area'];

			//$data['describe'] = $_POST['describe'];
			//$data['note'] = $_POST['note'];
			if ($_FILES['avatar']['size'] != 0) {
				if (isset($_POST['picture'])) {
					@unlink(base_url("assets/uploads/member/" . $_POST['picture']));
					@unlink(base_url("assets/uploads/member_thumbs/" . $_POST['picture']));
				}
				$data['avatar'] = $this->member->upload_image('avatar');
			}
			if ($this->input->post('password') != '') {
				$data['password'] = $this->ion_auth->hash_password($this->input->post('password'));
			}



			if (isset($_POST['id'])) {
				$id = (int) $_POST['id'];
				$this->member->update_by(array('id' => $id), $data);
				$insert_id = $id;
			} else {
				$data['created'] = date('Y-m-d');
				$this->member->insert($data);
				$insert_id = $this->db->insert_id();
			}

			if (isset($_FILES['file']) && isset($_FILES['file']['name']) && $_FILES['file']['size'] != 0) {
				$uploads = $this->member->upload_multi_file('file', 'user_infos');
				foreach ($uploads as $f) {
					$this->member_profile->insert(
						array(
							'user_id' 	=> $insert_id,
							'file'		=> $f['file_name'],
							'created'	=> date('Y-m-d H:i:s')
						)
					);
				}
			}
			$this->member->update_by(array('id' => $insert_id), array('code' => $_POST['area'] . $insert_id));
			redirect('admin/member/edit/' . $insert_id);
		}
	}
	function lists()
	{
		$this->mTitle = "Danh sách";
		$member = $this->member->get_all();
		$this->mViewData['member'] = $member;
		$this->render('member/lists');
	}
	function edit($id)
	{
		$this->mTitle = "Sửa học viên";
		$member = $this->member->get_by(array('id' => $id));
		$member->profiles = $this->member_profile->get_many_by(array('user_id' => $id));
		$this->mViewData['member'] = $member;
		$this->render('member/edit');
	}
	function views($id)
	{
		if (is_teacher()) {
			redirect('admin/permission');
		}
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
		$member_info = $this->member->get_many($id);
		$this->mViewData['member_info'] = $member_info;
		$this->mViewData['id'] = $id;
		$array_service_id[] = '';
		$this->mTitle = "Thông tin học viên: " . $member_info[0]->name;
		$member_package = $this->course_member->get_bd_by(array('member_id' => $id));
		foreach ($member_package as $key => $value) {
			$member_package[$key]->result = $this->course_member_result->get_bd_by(array('course_member_id' => $value->id));
		}
		$this->mViewData['details'] = $member_package;
		$this->render('member/views');
		if (isset($_POST['add-package'])) {
			$insert_id = $id;
			if (isset($_POST['service_id'])) {
				for ($i = 0; $i < count($_POST['service_id']); $i++) {
					if (!in_array($_POST['service_id'][$i], $array_service_id)) {
						$array_service_id[] = $_POST['service_id'][$i];
						$data_package['member_id'] = $insert_id;
						$data_package['course_id'] = $_POST['service_id'][$i];
						$data_package['import_id'] = get_current_user_id();
						$data_package['debit'] = str_replace(array(',', '.'), '', $_POST['debit'][$i]);
						$data_package['total'] = str_replace(array(',', '.'), '', $_POST['total'][$i]);
						$data_package['pay'] = str_replace(array(',', '.'), '', $_POST['pay'][$i]);
						$data_package['visa'] = str_replace(array(',', '.'), '', $_POST['visa'][$i]);
						$data_package['amount'] = $data_package['pay'] - $data_package['visa'];
						$data_package['note'] = $_POST['note'][$i];
						$data_package['created'] = date('Y-m-d');
						$this->db->insert('course_member', $data_package);
					}
				}
			}
			redirect('admin/member/views/' . $id . '');
		}
		if (isset($_POST['transfer'])) {
			if (isset($_POST['course_member_id'])) {
				$course_member_id = $_POST['course_member_id'];
				$course_transfer_id = $_POST['course_transfer_id'];
				$this->course_member->update($course_member_id, array('course_id' => $course_transfer_id));
			}
			redirect('admin/member/views/' . $id . '');
		}
	}
	function debit($id)
	{
		$details = $this->course_member->get_bd_by(array('id' => $id));
		$this->mTitle = "Nợ: " . number_format($details[0]->debit) . ' vnđ';
		$this->mViewData['debit'] = $details[0]->debit;
		$this->mViewData['details'] = $details;
		$info = $this->course_member_debit->get_bd_by(array('course_member_id' => $id));
		$this->mViewData['info'] = $info;
		$this->render('member/debit');
		if (isset($_POST['add-debit'])) {
			if ($_POST['price'] > 0) {
				$data['course_member_id'] = $id;
				$data['created'] = date('Y-m-d');
				$data['price'] = str_replace(array(',', '.'), '', $_POST['price']);
				$data['visa'] = str_replace(array(',', '.'), '', $_POST['visa']);
				$data['amount'] = $data['price'] - $data['visa'];
				$data['note'] = $_POST['note'];
				$data['import_id'] = get_current_user_id();
				$this->db->insert('course_member_debit', $data);
			}
			redirect('admin/member/debit/' . $id);
		}
	}
	function delete_debit($id)
	{
		$course_member_debit = $this->course_member_debit->get($id);
		if ($course_member_debit->created == date('Y-m-d')) {
			$this->course_member_debit->delete($id);
			redirect('admin/member/debit/' . $course_member_debit->course_member_id);
		} else {
			echo '<pre>';
			print_r('Không thể xóa từ hôm trước');
			echo '</pre>';
			die();
		}
	}
	function revenue()
	{
		$this->mTitle = 'Doanh số học viên';
		if ($date_filter = $this->input->get('date_filter')) {
			$date = explode('-', $date_filter);
			$date_1 = explode('/', $date[0]);
			$date_2 = explode('/', $date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if ($date[0] == $date[1]) {
				$end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
			} else {
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
		} else {
			$start_date = $end_date = date('Y-m-d');
		}
		$this->db->select("*");
		$this->db->from('course_member as A');
		$this->db->where('A.created >=', $start_date);
		$this->db->where('A.created <=', $end_date);
		if ($this->input->get('user_id')) {
			$user_id = $this->input->get('user_id');
			$this->db->where('G.user_id', $user_id);
		}
		$statistical = $this->db->get()->result();
		$this->mViewData['statistical']  = $statistical;
		$this->render('member/revenue');
	}
	function upload()
	{
		if (isset($_FILES['avatar'])) {
			$data = array();
			$data['import_id'] = get_current_user_id();
			$data['created'] = date('Y-m-d');
			$data['course_member_id'] = $_POST['id'];
			$data['link'] = $this->member->upload_image('avatar');
			$this->course_member_result->insert($data);
			redirect('admin/member/views/' . $_POST['parent_id']);
		}
	}
	function delete($id)
	{
		$course_member = $this->course_member->get($id);
		if ($course_member->created == date('Y-m-d')) {
			$this->course_member->delete($id);
			redirect('admin/member');
		} else {
			echo '<pre>';
			print_r('<h3>Không xóa được của ngày hôm trước</h3>');
			echo '</pre>';
			die();
		}
	}
	function del($id)
	{
		$this->course_member->delete($id);
	}
	function invoice($id)
	{
		$this->mTitle = 'In phiếu thu';
		$course_member = $this->course_member->get($id);
		$this->mViewData['member']  = get_member_name($course_member->member_id);
		$this->mViewData['code'] = $course_member->member_id;
		$this->mViewData['import_id'] = get_user_fullname($course_member->import_id);
		$this->mViewData['date']  = $course_member->created;
		$result[0] = new stdClass();
		$result[0]->name = get_course_name($course_member->course_id) . '<br>(' . number_format($course_member->total) . ')';
		$result[0]->price = $course_member->pay;
		$result[0]->content = 'Thanh toán lần đầu';
		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function list_invoice($member_id)
	{
		$this->mTitle = 'In phiếu thu';
		$member = $this->member->get($member_id);
		$this->mViewData['member']  = $member->name;
		$this->mViewData['code'] = $member->id;
		$this->mViewData['date']  = date('d-m-Y');
		$this->mViewData['import_id'] = 'Nhiều nhân viên';
		$print = $this->input->get('print');
		$course_member = $this->db->query('SELECT * FROM course_member WHERE id IN (' . $print . ') ORDER BY id asc ')->result();
		$result = array();
		$key = 0;
		foreach ($course_member as $value) {
			$result[$key] = new stdClass();
			$result[$key]->name = get_course_name($value->course_id) . '<br>(' . number_format($value->total) . ')';
			$result[$key]->price = $value->pay;
			$result[$key]->content = 'Thanh toán lần đầu<br>' . $value->created;
			$course_member_debit = $this->course_member_debit->get_many_by(array('course_member_id' => $value->id));
			foreach ($course_member_debit as $val) {
				$key++;
				$result[$key] = new stdClass();
				$result[$key]->name = get_course_name($value->course_id) . '<br>(' . number_format($value->total) . ')';
				$result[$key]->price = $val->price;
				$result[$key]->content = 'Thanh toán lần sau<br>' . $value->created;
			}
			$key++;
		}

		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function invoice_debit($id)
	{
		$this->mTitle = 'In phiếu thu';
		$course_member_debit = $this->course_member_debit->get($id);
		$course_member = $this->course_member->get($course_member_debit->course_member_id);
		$this->mViewData['member']  = get_member_name($course_member->member_id);
		$this->mViewData['code'] = $course_member->member_id;
		$this->mViewData['import_id'] = get_user_fullname($course_member_debit->import_id);
		$this->mViewData['date'] = $course_member_debit->created;
		$result[0] = new stdClass();
		$result[0]->name = get_course_name($course_member->course_id) . '<br>(' . number_format($course_member->total) . ')';
		$result[0]->price = $course_member_debit->price;
		$result[0]->content = 'Thanh toán lần sau';
		$this->mViewData['result'] = $result;
		$this->render('member/invoice');
	}
	function invoice_print()
	{
		$this->load->view('member/print');
	}
	function status($id)
	{
		$result = $this->course_member->get($id);
		$this->mViewData['result'] = $result;
		$this->render('member/status');
		if (isset($_POST['save'])) {
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
	public function remove_img($id)
	{
		$profiles = $this->db->query("SELECT * FROM member_profiles WHERE id = " . $id)->row();
		$img = base_url('assets/uploads/user_infos/' . $profiles->file);
		@@unlink($img);
		$this->db->delete('member_profiles', array('id' => $id));
		redirect('admin/member/edit/' . $profiles->user_id);
	}
	//manh

	public function academy_student_care()
	{
		$this->mTitle = 'Chăm sóc học viên chưa đăng ký';
		$this->render('admin/member/academy_student_care');
	}


	public function ajax_get_academy_student()
	{
		$filter = (object) json_decode($this->input->get('filter'));

		if (isset($filter->date) && $filter->date != '') {
			$date = explode('-', $filter->date);
			$date_1 = explode('/', $date[0]);
			$date_2 = explode('/', $date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if ($date[0] == $date[1]) {
				$end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
			} else {
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
		}


		$this->db->select('ast.*,count(asc.id) as total, DATE_FORMAT(max(asc.created),"%d-%m-%Y %h:%i") as recent')
			->from('academy_student as ast')
			->join('academy_student_care as asc', 'ast.id=asc.student_id', 'left');

		if (isset($filter->is_registed) && $filter->is_registed == 0) {
			$this->db->where('ast.is_registed', 0);
		} elseif (isset($filter->is_registed) && $filter->is_registed == 1) {
			$this->db->where('ast.is_registed', 1);
		}

		if (isset($filter->key) && $filter->key != '') {
			$this->db->where('(ast.phone like "%' . $filter->key . '%" or ast.name like "%' . $filter->key . '%")');
		}

		if (isset($filter->date) && $filter->date != '') {
			$this->db->where('asc.created >=', $start_date . ' 00:00:00');
			$this->db->where('asc.created <=', $end_date . ' 23:59:59');
		}
		// if (isset($filter->status_care)) {

		// }




		$this->db->group_by('ast.id');

		if (!empty($filter->limit)) $this->db->limit($filter->limit, $filter->offset);

		$sort = '';
		if (isset($filter->option) && $filter->option == 1) {
			$sort = 'total';
		} else {
			$sort = 'asc.created';
		}
		if (isset($filter->sort) && $filter->sort == 1) {
			$sort = $sort . ' asc';
		} else {
			$sort = $sort . ' desc';
		}
		if (isset($filter->sort) && isset($filter->option)) {
			$this->db->order_by($sort);
		}
		$rs = $this->db->get()->result();

		$this->db->select('count(*) as total')
			->from('academy_student as ast')
			->join('academy_student_care as asc', 'ast.id=asc.student_id', 'left');

		if (isset($filter->is_registed) && $filter->is_registed == 0) {
			$this->db->where('ast.is_registed', 0);
		} elseif (isset($filter->is_registed) && $filter->is_registed == 1) {
			$this->db->where('ast.is_registed', 1);
		}
		if (isset($filter->date) && $filter->date != '') {
			$this->db->where('asc.created >=', $start_date . ' 00:00:00');
			$this->db->where('asc.created <=', $end_date . ' 23:59:59');
		}

		if (isset($filter->key) && $filter->key != '') {
			$this->db->where('(ast.phone like "%' . $filter->key . '%" or ast.name like "%' . $filter->key . '%")');
		}
		$this->db->group_by('ast.id');

		$count = $this->db->get()->result();
		$qr = $this->db->last_query();


		echo json_encode(array('status' => 1, 'count' => count($count), 'data' => $rs, $qr));
	}


	public function ajax_save_academy_student()
	{
		$_POST = (object) json_decode(file_get_contents('php://input'), true);

		$data = array(
			'phone'				 => $_POST->phone,
			'name' 				 => isset($_POST->name) ? $_POST->name : null,
			'date' 				 => isset($_POST->date) ? $_POST->date : null,
			'address' 			 => isset($_POST->address) ? $_POST->address : null,
			'identity_number'    => isset($_POST->identity_number) ? $_POST->identity_number : null,
			'is_registed'        => isset($_POST->is_registed) ? $_POST->is_registed : 0,
			'id_date'            => isset($_POST->id_date) ? $_POST->id_date : null,
			'gender'             => isset($_POST->gender) ? $_POST->gender : 0,
			'area'              => isset($_POST->area) ? $_POST->area : null,
		);

		if (isset($_POST->id)) {
			$this->db->where('id', $_POST->id);
			$rs =	$this->db->update('academy_student', $data);
		} else {
			$data['created'] = date('Y-m-d H:i:s');

			$count = $this->db->select('count(*) as total')->from('academy_student')->where('phone', $_POST->phone)->get()->row();

			if ($count->total > 0) {
				echo json_encode(array('status' => 0));
				die;
			}

			$rs = $this->db->insert('academy_student', $data);
		}

		echo json_encode(array('status' => 1, 'data' => $rs, $this->db->last_query()));
	}

	public function ajax_get_student_care($type)
	{
		$filter = (object) json_decode($this->input->get('filter'));

		$this->db->select('asc.id,DATE_FORMAT(asc.created,"%d-%m-%Y %h:%i") as created,ast.name as name_care,asc.import_id,DATE_FORMAT(asc.arrival_time,"%d-%m-%Y %h:%i") as arrival_time,arrival_status')
			->from('academy_student_care as  asc')
			->join('academy_care_tag as ast', 'asc.care_id=ast.id')
			->where('asc.student_id', $filter->id);
		if ($type == 1) {
			$this->db->where('ast.id!=', 1);
		} else {
			$this->db->where('ast.id=', 1);
		}

		if (!empty($filter->limit)) $this->db->limit($filter->limit, $filter->offset);
		if ($type == 1) {
			$this->db->order_by('asc.id', 'desc');
		} else {
			$this->db->order_by('asc.arrival_time', 'asc');
		}
		$rs = $this->db->get()->result();
		$qr = $this->db->last_query();
		foreach ($rs as $key => $value) {
			$user =	get_user($value->import_id);

			$value->import_name = $user->last_name . ' ' . $user->first_name;
		}
		$this->db->select('count(*) as total')
			->from('academy_student_care as  asc')
			->join('academy_care_tag as ast', 'asc.care_id=ast.id')
			->where('asc.student_id', $filter->id);
		if ($type == 1) {
			$this->db->where('ast.id!=', 1);
		} else {
			$this->db->where('ast.id=', 1);
		}
		$count = $this->db->get()->row();
		echo json_encode(array('status' => 1, 'count' => $count->total, 'data' => $rs, $qr));
	}

	public function ajax_get_care_tag()
	{
		$filter =  json_decode($this->input->get('filter'));

		$this->db->select('*')->from('academy_care_tag')
			->limit(5);
		if (isset($filter)) {
			$this->db->where('name like "%' . $filter . '%"');
		}
		$rs = $this->db->get()->result();
		echo json_encode(array('status' => 1, 'data' => $rs, $this->db->last_query()));
	}

	public function ajax_save_student_care()
	{
		$_POST = (object) json_decode(file_get_contents('php://input'), true);


		$check = $this->db->select('id')->from('academy_care_tag')->where('name', trim($_POST->name_care))->get()->row();

		if (isset($check) && $check->id) {

			$id_care =	$check->id;
		} else {
			$array = array(
				'name' => trim($_POST->name_care)
			);

			$this->db->set($array);
			$this->db->insert('academy_care_tag');
			$id_care = $this->db->insert_id();
		}

		$id = get_current_user_id();
		$data = array(
			'student_id' => $_POST->student_id,
			'import_id'  => $id,
			'care_id'    => $id_care,
			'created'    => date('Y-m-d H:i:s')
		);

		if ($id_care == 1) {
			$data['arrival_time'] = $_POST->date . ' ' . $_POST->time . ':00';
		}
		$this->db->set($data);
		$rs = $this->db->insert('academy_student_care');

		echo json_encode(array('status' => 1, 'data' => $rs, $this->db->last_query()));
	}

	public function ajax_register()
	{
		$_POST =  json_decode(file_get_contents('php://input'), true);

		$check = $this->db->select('count(*) as total')->from('member')
			->where('phone', $_POST['phone'])->get()->row();
		if (isset($check) && $check->total > 0) {
			echo json_encode(array('status' => 0));
			die;
		}
		$data = array();
		$data['name'] = $_POST['name'];
		$data['phone'] = $_POST['phone'];
		$data['birthday'] = $_POST['date'];
		$data['gender'] = $_POST['gender'];
		$data['address_contact'] = $_POST['address'];
		$data['import_id'] = get_current_user_id();
		$data['id_card'] = $_POST['identity_number'];
		$data['id_date'] = $_POST['id_date'];
		$data['area'] = $_POST['area'];

		$data['password'] = $this->ion_auth->hash_password($this->input->post('phone'));

		$data['created'] = date('Y-m-d');
		$in = $this->member->insert($data);
		$insert_id = $this->db->insert_id();
		if ($in) {
			$update = array();
			$update['name'] = $_POST['name'];
			$update['phone'] = $_POST['phone'];
			$update['date'] = $_POST['date'];
			$update['gender'] = $_POST['gender'];
			$update['address'] = $_POST['address'];
			$update['identity_number'] = $_POST['identity_number'];
			$update['id_date'] = $_POST['id_date'];
			$update['area'] = $_POST['area'];
			$update['is_registed'] = 1;

			$this->db->set($update);
			$this->db->where('id', 	$_POST['id']);
			$this->db->update('academy_student');

			$this->member->update_by(array('id' => $insert_id), array('code' => $_POST['area'] . $insert_id));
		}

		echo json_encode(array('status' => 1, 'data' => $insert_id, $this->db->last_query()));
	}
	public function ajax_delete_student_care()
	{
		$_POST = (object)  json_decode(file_get_contents('php://input'), true);

		$user = get_user();
		if ($_POST->import_id != $user->id) {
			echo json_encode(array('status' => 0));
			die;
		}

		$this->db->where('id', $_POST->id);
		$rs = $this->db->delete('academy_student_care');

		echo json_encode(array('status' => 1, 'data' => $rs, $this->db->last_query()));
	}

	public function ajax_change_status_app()
	{
		$_POST =  json_decode(file_get_contents('php://input'), true);
		$this->db->where('id', $_POST['id']);
		$rs = $this->db->update('academy_student_care', $_POST);
		echo json_encode(array('status' => 1, 'data' => $rs, $this->db->last_query()));
	}
}
