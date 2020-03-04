<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Revenue extends Admin_Controller {
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
			$this->push_breadcrumb('Doanh số', site_url('admin/revenue'));
		}
	}
	
	function index(){
		$this->mTitle = 'Doanh số học viên';
		$all_course = all_course();
		$this->mViewData['all_course'] = $all_course;
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
			update_revenue($start_date);
		}
		$this->db->select("*");
		$this->db->from('course_member as A');
		$this->db->where('A.created >=', $start_date);
		$this->db->where('A.created <=', $end_date);
		if($course_id = $this->input->get('course_id')){
			foreach ($course_id as $key => $value) {
				if($key == 0){
					$this->db->where('A.course_id', $value);
				}else{
					$this->db->or_where('A.course_id', $value);
				}
			}
		}
		$statistical = $this->db->get()->result(); 
		$this->mViewData['statistical']  = $statistical;

		//debit
		$this->db->select("A.created, A.import_id, A.price, A.amount, A.visa, A.note, A.course_member_id, B.id, B.member_id, B.course_id");
		$this->db->from('course_member_debit as A');
		$this->db->join('course_member as B', 'B.id = A.course_member_id');
		$this->db->where('A.created >=', $start_date);
		$this->db->where('A.created <=', $end_date);
		if($course_id = $this->input->get('course_id')){
			foreach ($course_id as $key => $value) {
				if($key == 0){
					$this->db->where('B.course_id', $value);
				}else{
					$this->db->or_where('B.course_id', $value);
				}
			}
		}
		$debt_collection = $this->db->get()->result(); 
		$this->mViewData['debt_collection']  = $debt_collection;


		$this->render('revenue/index');
	}
}
