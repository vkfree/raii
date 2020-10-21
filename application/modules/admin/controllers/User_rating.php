<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_rating extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('user_rating');

		$crud->columns('id','user_id','driver_id', 'created_date', 'comment','rating');

		$crud->set_relation('user_id', 'admin_users', 'first_name');
		$crud->set_relation('driver_id', 'admin_users', 'first_name');
		
		$crud->field_type('status', 'hidden');

		// $crud->field_type('office_id', 'hidden', $office_id);

		$crud->display_as('user_id','User Name');
		$crud->display_as('driver_id','Driver Name');

		$crud->set_theme('datatables');
		$crud->order_by('id','desc');
		$crud->unset_add();
		// $crud->unset_delete();
		$crud->unset_edit();
		// $crud->unset_operations();

		$this->mPageTitle = 'User Report Listing';
		$this->render_crud();
	}

}
