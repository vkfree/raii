<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	/**
	 * Login page and submission
	 */
	public function index()
	{
		$this->load->library('form_builder');
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
				$this->load->model('custom_model');
			$identity = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');
			
			if ($this->ion_auth->login($identity, $password, $remember))
			{
				// login 
				$user_session = $this->session->all_userdata();
				$user_id = $user_session['user_id'];
				$query = "SELECT a.store_type,b.group_id FROM admin_users as a INNER JOIN admin_users_groups as b ON a.id = b.user_id WHERE a.id='$user_id' ";
				$datacheck = $this->custom_model->get_data($query);
				$group_id = $datacheck[0]->group_id;
				$store_type = $datacheck[0]->store_type;

				if($group_id != 1 && $store_type != STORE_TYPE){

					$errors = '<p>login credential is not authenticated.</p>';
					$this->system_message->set_error($errors);
					refresh();
				}else{
					$messages = $this->ion_auth->messages();
					$this->system_message->set_success($messages);
					redirect($this->mModule);
				}
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
}
