<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_review extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
		$this->load->model('category_model');
	}

	// Frontend Category CRUD
	public function index()
	{
		$crud = $this->generate_crud('user_rating');
		$crud->columns('id','to_id', 'comment','rating','from_id');

		// $crud->set_field_upload('image', UPLOAD_BLOG_POST);

		$crud->field_type('type1', 'hidden');
		$crud->field_type('status', 'hidden');
		$crud->where("type1","user");

		// $crud->field_type('status','dropdown', array('active' => 'Active', 'Deactive' => 'Deactive'));
		$crud->field_type('store_type','dropdown', array('KWT' => 'Active'));		

		$crud->display_as('from_id','Driver Name');
		$crud->display_as('to_id','User Name');
		$crud->set_theme('datatables');
		
		$crud->set_relation('from_id', 'admin_users', 'first_name');
		$crud->set_relation('to_id', 'admin_users', 'first_name');

		$crud->display_as('type','Type');
		// $crud->set_rules('title','Title','required');
		// $crud->set_rules('sub_tile','Sub title','required');
		// $crud->set_rules('image','Upload Image','required');

		$crud->set_rules('to_id','User Name','required');
		$crud->set_rules('comment','Comment','required');
		$crud->set_rules('rating','Rating','required');
		$crud->set_rules('from_id','Driver name','required');
		$crud->set_rules('created_date','Date & Time ','required');
		
		// $crud->unset_add();
		// $crud->unset_edit();
		
		$this->mPageTitle = 'User review';
		$this->render_crud();
	}

	public function delete($id)
	{
		$this->custom_model->my_delete(array("id" => $id),false);
	}

}
