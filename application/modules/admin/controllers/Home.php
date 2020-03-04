<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Admin_Controller {
	public function index()
	{
		$this->load->model('user_model', 'users');
		$this->load->model('course_model', 'course');
		$this->load->model('revenue_model', 'revenue');
		$course = $this->course->get_all();
		$course_wait = $course_study = 0;
		foreach ($course as $value) {
			if($value->status == 1 && $value->date_added > date('Y-m-d')){
				$course_wait ++;
			}
			if($value->status == 1 && $value->date_added < date('Y-m-d')){
				$course_study ++;
			}
		}
		$this->mViewData['course_wait'] = $course_wait;
		$this->mViewData['course_study'] = $course_study;
		update_revenue(date('Y-m-d'));
		$revenue_today = $this->revenue->get_by(array('date' => date('Y-m-d')));
		$this->mViewData['revenue_today'] = $revenue_today->revenue;
		$month = date('Y-m');
		$start_date = $month.'-01';
		$end_date = date('Y-m-d');
		$revenue_month = $this->db->query("SELECT SUM(amount+visa) as total FROM revenues WHERE `date` >= '".$start_date."' AND `date` <= '".$end_date."' ")->row();
		$this->mViewData['revenue_month'] = $revenue_month->total;
		$this->render('home');
	}
}
