<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller {

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
		$crud = $this->generate_crud('banner');
		$crud->columns('id', 'title', 'sub_title', 'status');		

		// $this->unset_crud_fields('image');
		$crud->set_theme('datatables');
		// disable direct create / delete Category
		$crud->unset_add();
		// $crud->unset_delete();
		$crud->unset_edit();
		// $crud->unset_operations();
		// $crud->add_action('Ar', '', 'admin/banner/tedit', 'translate_view');
		$crud->add_action('edit', '', 'admin/banner/edit', '');
		// $crud->add_action('remove_red_eye', '', 'admin/category/view_details', '');
	   // $crud->add_action('delete', '', 'admin/category/delete', 'js-sweetalert" data-type="cancel" on-submit="dialogs_box()');
		
		$this->mPageTitle = 'Banner';
		$this->render_crud();
	}

	// Create Frontend Category
	public function create()
	{
		$udata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		
		$user_id = $this->mUser->id;
		if($user_id != '1'){redirect('admin');}
		
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		// print_r($post_data['image']); die;
        
        if ( !empty($post_data) )
		{
			if ( !empty($post_data['image']) )
			{
				// proceed to create Category
				$response = $this->custom_model->my_insert($post_data,'banner');
				
				if ($response)
				{
					// success
					$this->system_message->set_success('Banner created successfully');
				}
				else
				{
					// failed
					$this->system_message->set_error('Something went wrong');
				}			
				refresh();

			}
			else{
				$this->system_message->set_error('Please Upload Banner Image');
			}
		}


		$this->mPageTitle = 'Create Banner';

		$this->mViewData['form'] = $form;
		$this->render('banner/create');
	}

	// Edit Frontend Category
	public function edit($cate_id)
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		
		if ( !empty($post_data) )
		{
			$cate_data = $this->custom_model->my_where('banner','*',array('id' => $cate_id));
			
			// proceed to create Category
			$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'banner');
			
			if ($response)
			{
				// success
				$this->system_message->set_success('Banner Edited successfully');
			}
			else
			{
				// failed
				$this->system_message->set_error('Something went wrong');
			}
			
			refresh();
		}

		$cate_data = $this->custom_model->my_where('banner','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];
		$this->mPageTitle = 'Edit Banner';
		$this->mViewData['form'] = $form;
		$this->render('banner/create');
	}

	public function tedit($cate_id)
	{	ini_set('default_charset', 'UTF-8');
		$form = $this->form_builder->create_form();
		$cate_data = $this->custom_model->my_where('banner_trans','*',array('id' => $cate_id));
		if(!isset($cate_data[0]['banner_name'])){
			$cate_data = $this->custom_model->my_where('banner','*',array('id' => $cate_id));
			 $this->custom_model->my_insert($cate_data[0],'banner_trans');
		}
		$post_data = $this->input->post();
		
		if ( !empty($post_data) )
		{
			// proceed to create Category
			$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'banner_trans');
			
			if ($response)
			{
				// success
				$this->system_message->set_success('Banner Translate successfully');
			}
			else
			{
				$this->system_message->set_error('Something went wrong');
			}
			refresh();
		}
		$cate_data = $this->custom_model->my_where('banner_trans','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];

		$this->mPageTitle = 'Translate Banner';

		$this->mViewData['form'] = $form;
		$this->render('banner/create');
	}
	
	public function delete($cate_id)
	{
		echo $cate_id;
	}
}
