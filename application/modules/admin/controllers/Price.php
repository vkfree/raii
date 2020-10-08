<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price extends Admin_Controller {

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
		$crud = $this->generate_crud('price');
		$crud->columns('id', 'type', 'day','price');

		// $crud->set_field_upload('image', UPLOAD_BLOG_POST);


		$crud->field_type('time_to', 'hidden');
		$crud->field_type('time_from', 'hidden');
		$crud->field_type('city', 'hidden');
		$crud->field_type('image', 'hidden');

		$crud->field_type('status','dropdown', array('active' => 'Active', 'Deactive' => 'Deactive'));
		$crud->field_type('day','dropdown', array('day' => 'Day', 'night' => 'night'));

		$crud->display_as('display_name','Category');
		$crud->set_theme('datatables');

		$crud->set_rules('day','Day','required');
		$crud->set_rules('type','Car type','required');
		// $crud->set_rules('status','Select Status','required');
		// $crud->set_rules('image','Upload Image','required');

		$crud->callback_column('price',array($this,'price'));

		$crud->unset_add();
		$crud->unset_delete();
		// $crud->unset_edit();
		
		$this->mPageTitle = 'Car Price';
		$this->render_crud();
	}

	public function price($value, $row)
	{
		$str = $row->price.' SAR / KM';
		return $str;
	}

	public function delete($id)
	{
		$this->custom_model->my_delete(array("id" => $id),"category",false);
		// $this->custom_model->my_delete(array("id" => $id),"category_trans",false);
		header( "Location: ".base_url()."admin/category/" );die;
	}

}
