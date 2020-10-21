<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Admin_Controller {

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
		$crud = $this->generate_crud('pages');

		$crud->columns('id', 'title', 'status', 'editor');
		$crud->display_as('editor','editor');
		$crud->display_as('title','Pages');
		
		$this->unset_crud_fields('slug');
		$crud->set_theme('datatables');
		// disable direct create / delete Category
		$crud->unset_add();
		$crud->unset_edit();

		$crud->add_action('translate', '', 'admin/pages/tedit', '');
		$crud->add_action('edit', '', 'admin/pages/edit', '');
		
		$this->mPageTitle = 'Pages';
		$this->render_crud();
	}

	// Create Frontend Category
	public function create()
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		if ( !empty($post_data) )
		{	
			$post_data['slug'] = $this->generate_slug($post_data['title'],'pages');
			$post_data['editor'] = $post_data['editor'];

			$count = $this->custom_model->record_count('pages',array('title' => $post_data['title']));
				// proceed to create Category
			if ($count)
				{
					// failed 
					$this->system_message->set_error('pages Already present<br>Unable to Create pages');
				}
				else
				{
					//echo "<pre>";print_r($post_data); die;
					$response = $this->custom_model->my_insert($post_data,'pages');
								$this->custom_model->my_insert($post_data,'pages_trans');
					if ($response)
					{
						// success
						$this->system_message->set_success('pages created successfully');
					}
					else
					{
						// failed
						$this->system_message->set_error('Something went wrong');
					}
				}
		
			refresh();
		}

		$this->mPageTitle = 'Create Pages';

		$this->mViewData['form'] = $form;
		$this->render('pages/create');
	}

	// Edit Frontend Category
	public function edit($cate_id)
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		if ( !empty($post_data) )
		{	
			$post_data['editor'] = $post_data['editor'];
			$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'pages');
			
			if ($response)
			{
				$this->system_message->set_success('pages Edited successfully');
			}
			else
			{
				$this->system_message->set_error('Something went wrong');
			}
			refresh();
		}
		$cate_data = $this->custom_model->my_where('pages','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];
		$this->mPageTitle = 'Edit Pages';
		$this->mViewData['form'] = $form;
		$this->render('pages/create');
	}

	public function tedit($cate_id)
	{	
		ini_set('default_charset', 'UTF-8');
		$form = $this->form_builder->create_form();
		$cate_data = $this->custom_model->my_where('pages_trans','*',array('id' => $cate_id));
		if(!isset($cate_data[0]['title'])){
			$cate_data = $this->custom_model->my_where('pages','*',array('id' => $cate_id));
			 $this->custom_model->my_insert($cate_data[0],'pages_trans');
		}
		$post_data = $this->input->post();
		if ( !empty($post_data) )
		{
			$post_data['editor'] = $post_data['editor'];
			$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'pages_trans');
			
			if ($response)
			{
				// success
				$this->system_message->set_success('الصفحة ترجمة بنجاح');
			}
			else
			{
				// failed
				$this->system_message->set_error('حدث خطأ ما');
			}
			
			refresh();
		}

		$cate_data = $this->custom_model->my_where('pages_trans','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];
		$this->mPageTitle = 'ترجمة الصفحات';
		$this->mViewData['form'] = $form;
		$this->render('pages/create');
	}



	public function delete($cate_id)
	{
		$this->custom_model->my_delete(array("id" => $cate_id),"pages",false);
        $this->custom_model->my_delete(array("id" => $cate_id),"pages_trans",false);
        header( "Location: ".base_url()."admin/pages" );die;
	}

}