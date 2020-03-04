<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('option_model', 'option');
		$this->load->model('course_model', 'course');
		$this->load->model('class_model', 'class');
		$this->load->helper("file");
	}
	public function index()
	{
		$this->mPageTitle = 'Cài đặt chung';
		if($this->input->post('submit')){
			foreach ($this->input->post() as $key => $value) {
				if($key != 'submit'){
					$check = $this->option->get_by(array('name' => $key));
					if($check){
						$this->option->update($check->id,array('value' => $value));
					}else{
						$this->option->insert(
							array(
								'name' => $key,
								'value' => $value
							)
						);
					}
				}
			}
		}
		$this->render('setting/setting');
	}

	public function sms(){
		$this->mPageTitle = 'Gửi sms';
		if($this->input->post('send')){
			$content = $this->input->post('content');
			foreach ($this->input->post('phone') as $phone) {
				send_sms($content, $phone);
			}
			redirect('setting/sms?status=success');
		}


		$this->db->select('*');
		$this->db->from('course_member');

		$all_class = $this->class->get_all();
		

		$all_course = $this->course->get_all();
		$this->mViewData['all_course'] = $all_course;


		$list_class = array();
		if($this->input->get('class_id')){
			$list_class = $this->input->get('class_id');

			$this->db->where_in('class_id', $list_class);
		}

		if($this->input->get('course_id')){
			$this->db->where_in('course_id', $list_course);
			$list_course = $this->input->get('course_id');
			$all_class = $this->class->get_many_by(
				array(
					'course_id' => $list_course
				)
			);
		}


		$this->mViewData['all_class'] = $all_class;

		$results = $this->db->get()->result();
		echo $this->db->last_query();
		echo '<pre>';print_r($results);echo '</pre>';

		/*
		die();

		$list_store = $list_group = array('');
		if($this->input->get('store_id')){
			$list_store = $this->input->get('store_id');
		}
		if($this->input->get('group_id')){
			$list_group = $this->input->get('group_id');
		}
		$this->db->select('admin_users.*');
		$this->db->from('admin_users');
		$this->db->join('admin_users_stores', 'admin_users.id = admin_users_stores.user_id');
		$this->db->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id');
		$this->db->where('admin_users.id !=', 1);
		$this->db->where('admin_users.active', 1);
		
		$this->db->where_in('admin_users_stores.store_id', $list_store);
		$this->db->where_in('admin_users_groups.group_id', $list_group);
			
		
		
		$admin_users = $this->db->get()->result();
		$this->mViewData['store_id'] = $list_store;
		$this->mViewData['group_id'] = $list_group;

		*/
		$this->mViewData['results'] = $results;

		$this->render('setting/sms');
	}
}
