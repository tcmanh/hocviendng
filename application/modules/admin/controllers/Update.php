<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Update extends Admin_Controller {
   public function __construct()
   {
      parent::__construct();
      $this->load->library('form_builder');
      $this->load->model('teachers_model', 'teachers');
      $this->load->model('user_model', 'user');
      $this->load->model('users_group_model', 'users_group');

      $this->api_key = $this->config->item('api_key');
      $this->api_url = $this->config->item('api_url');

   }

   public function index(){
      $this->db->empty_table('teachers');

      $data_teacher = array(
         'api_key'   => $this->api_key,
      );
      $list_teachers = call_api('POST', $this->api_url.'user/list_teachers', $data_teacher);

      if($list_teachers->status == 200){
         foreach ($list_teachers->teachers as $value) {
            $this->teachers->insert($value);
         }
      }

      $this->db->empty_table('users');
      $this->db->empty_table('users_groups');

      $data_user = array(
         'api_key'   => $this->api_key,
      );
      $results = call_api('POST', $this->api_url.'user/list_users', $data_user);
      if($results->status == 200){
         foreach ($results->users as $value) {
            $this->user->insert($value);
         }
         foreach ($results->users_groups as $value) {
            foreach ($value as $val) {
               $this->users_group->insert($val);
            }  
         }
      }
      echo '<pre>';print_r('Cập nhật thành công');echo '</pre>';die();
   }
}
