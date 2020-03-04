<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	public function __construct(){
		parent:: __construct();
		$this->api_key = $this->config->item('api_key');
		$this->api_url = $this->config->item('api_url');
		$this->load->model('user_model', 'admin_user');
		$this->load->model('users_group_model', 'users_group');
	}
	/**
	 * Login page and submission
	 */
	public function index()
	{	
		$this->load->library('form_builder');
		$form = $this->form_builder->create_form();
		if ($form->validate())
		{
			$identity = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');
			$data = array(
				'api_key'	=> $this->api_key,
	            'identity'	=> $identity,
	            'password'	=> $password,
			);
			
			$call_api = call_api('POST', $this->api_url.'user/login', $data); 
			if($call_api->status == 200){
				echo 'success';
				$user = $this->admin_user->get($call_api->user->id);
				if($user){
					$this->admin_user->update($user->id, $call_api->user);
					$this->users_group->delete_by(array('user_id' => $user->id));
				}else{
					$this->admin_user->insert($call_api->user);
					$user = $this->admin_user->get($call_api->user->id);
				}
			
				foreach ($call_api->groups as $value) {
					$this->users_group->insert($value);
				}

				$this->ion_auth_model->set_session($user);
				$this->ion_auth_model->update_last_login($user->id);
				$this->ion_auth_model->clear_login_attempts($user->email);
				$this->ion_auth_model->remember_user($user->id);
				redirect($this->mModule);
			}
			else{
				$this->system_message->set_error($call_api->message);
				refresh();
			}
		}
		// display form when no POST data, or validation failed
		$this->mViewData['form'] = $form;
		$this->mBodyClass = 'login-page';
		$this->render('login', 'empty');

	}
	/*
	public function index()
	{
		$this->load->library('form_builder');
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			// passed validation
			$identity = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');
			$redirect = $this->input->post('redirect');
			$a = $this->ion_auth->login($identity, $password, $remember);
			if ($this->ion_auth->login($identity, $password, $remember))
			{
				// login succeed
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
				redirect('/admin/'.base64_decode($redirect));
			}
			else
			{
				// login failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
				refresh();
			}
		}
		
		// display form when no POST data, or validation failed
		$this->mViewData['form'] = $form;
		$this->mBodyClass = 'login-page';
		$this->render('login', 'empty');
	}
	*/
}
