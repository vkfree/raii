<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_send extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
		$this->load->model('category_model');
	}

	// Frontend Category CRUD

	public function create()
	{
		    $form = $this->form_builder->create_form();
       	$subject = $this->input->post('subject',true);
       	$message = $this->input->post('message',true);
        $data = $this->custom_model->my_where("email_info_offer","*",array(''));
        foreach($data as $row)
        {
          $email = $row['email'];
       	  if(!empty($subject) && !empty($message) && !empty($email)){
            //send_email($email,$subject,$message);
          }
        }
    $this->mPageTitle = 'Send Email';
    $this->mViewData['form'] = $form;
		$this->render('email_send/create');
  }

	// Edit Frontend Category
	

	

	

}