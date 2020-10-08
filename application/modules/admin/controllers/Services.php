<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Admin_Controller {

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
		$crud = $this->generate_crud('services');
		$crud->columns('id', 'title', 'sub_title','image');

		$crud->set_field_upload('image', UPLOAD_BLOG_POST);

		$crud->display_as('title','Service Name');
		$crud->display_as('sub_title','Short Description');

		// $crud->field_type('store_type', 'hidden');

		$crud->set_theme('datatables');

		$crud->set_rules('title','Title','required');
		$crud->set_rules('sub_title','Sub title','required');
		$crud->set_rules('image','Upload Image','required');
		$crud->set_rules('description','Description','required');

		// $crud->unset_add();
		// $crud->unset_edit();
		
		$this->mPageTitle = 'Services';
		$this->render_crud();
	}

	public function delete($id)
	{
		$this->custom_model->my_delete(array("id" => $id),"help",false);
		header( "Location: ".base_url()."admin/help/" );die;
	}

}
