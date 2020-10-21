<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_manager extends Admin_Controller {

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

		$this->mPageTitle = 'Account manager';
		$this->render('account_manager/view', 'plain');
	}

	// Create Frontend Category
	public function create($type="",$catid="")
	{
		$parent1 = array();
		$udata = $this->custom_model->my_where('admin_users_groups','*',array('user_id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		$this->mViewData['vendor'] = 0;
		if( $udata[0]['group_id'] == 5 ){
			$this->mViewData['vendor'] = 1;		
			$usrdata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","",array(),"",false);
			$catdslug = $usrdata[0]['category'];
		}
		$acategories = $this->custom_model->my_where('category','*',array('status' => 'active','parent' => '0'),array(),"parent","asc","","",array(),"object");

		$acatp = array();
		if(!empty($acategories)){
			foreach ($acategories as $ckey => $cvalue) {
				$parent = $cvalue->parent;
				$acatp[$parent][] = $cvalue;
			}
		}
		if( $udata[0]['group_id'] == 5 ){
			foreach ($acatp[0] as $ckey => $cvalue) {
				if( $catdslug != $cvalue->slug ){
					unset($acatp[0][$ckey]);
				}
			}
		}
		
		if(!empty($acatp) && !empty($acatp[0])){ 
			$parent = $acatp[0]; 
			if(!empty($parent)){
				
				foreach ($parent as $pkey => $pvalue) {
					
					$id = $pvalue->id;
					$display_name = $pvalue->display_name;
					$slug = $pvalue->slug;
					$parent1[]= array("display_name" => $display_name, "id" => $id);
					@$sparent = $acatp[$id]; 
					if(!empty($sparent)){
						
						foreach ($sparent as $skey => $svalue) {
							
							$sid = $svalue->id;
							$sdisplay_name = $svalue->display_name;
							$slug = $svalue->slug;
							$parent1[]= array("display_name" => $sdisplay_name, "id" => $sid);
						}
					}
				}
			}
		}
								
		
	
		$form = $this->form_builder->create_form();

		$post_data = $this->input->post();
		if ( !empty($post_data) )
		{
			$post_data['slug'] = $this->generate_slug($post_data['display_name'],'category');

			$count = $this->custom_model->record_count('category',array('display_name' => $post_data['display_name']));
			
			if ($count)
			{
				// failed
				$this->system_message->set_error('Category Already present<br>Unable to Create Category');
			}
			else
			{
				$check = $this->custom_model->my_where('category','*',array('parent' => 0, 'id' => @$post_data['parent']));
				
				if (empty($check)) {
					$post_data['has_product'] = 1;
				}
				else{
					$post_data['has_product'] = 0;
				}
				$response = $this->custom_model->my_insert($post_data,'category');
							$this->custom_model->my_insert($post_data,'category_trans');
				if ($response)
				{
					$this->system_message->set_success('Category created successfully');
				}
				else
				{
					$this->system_message->set_error('Something went wrong');
				}
			}
		}
		
		$select_parent = array();
		foreach ($parent1 as $key => $value) {
			$select_parent[$value['id']] =  $value['display_name'];
		}
		$this->mViewData['type'] = $type;
		$this->mViewData['parent'] = $select_parent;

		$this->mViewData['catid'] = $catid;
		$this->mPageTitle = 'Create Category';
		if($type == "vendor"){
			$this->mPageTitle = 'Create Category';
		}
		$this->mViewData['form'] = $form;
		$this->render('category/create');
	}

	// Edit Frontend Category
	public function edit($cate_id)
	{	$parent1 = array();
		$udata = $this->custom_model->my_where('admin_users_groups','*',array('user_id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		$this->mViewData['vendor'] = 0;
		if( $udata[0]['group_id'] == 5 ){
			$this->mViewData['vendor'] = 1;		
			$usrdata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","",array(),"",false);
			$catdslug = $usrdata[0]['category'];
			$acategories = $this->custom_model->my_where('category','*',array('status' => 'active'),array(),"parent","asc","","",array(),"object");

			$acatp = array();
			if(!empty($acategories)){
				foreach ($acategories as $ckey => $cvalue) {
					$parent = $cvalue->parent;
					$acatp[$parent][] = $cvalue;
				}
			}

			foreach ($acatp[0] as $ckey => $cvalue) {
				if( $catdslug != $cvalue->slug ){
					unset($acatp[0][$ckey]);
				}
			}
		}	
		if(!empty($acatp)){
			foreach ($acatp as $kcsey => $vacslue) {
				foreach ($vacslue as $ksdey => $vsdalue) {
					$parent1[]= array("display_name" => $vsdalue->display_name, "id" => $vsdalue->id);
				}
			}
		}	
	
		$form = $this->form_builder->create_form();

		$post_data = $this->input->post();
		
		if ( !empty($post_data) )
		{
			$cate_data = $this->custom_model->my_where('category','*',array('id' => $cate_id));
			if($post_data['display_name'] != $cate_data[0]['display_name']){
				//$post_data['slug'] = $this->generate_slug($post_data['display_name'],'category');
			}
			
			$count = $this->custom_model->record_count('category',array('display_name' => $post_data['display_name'], 'id !=' => $cate_id));
			// $count = 0;
			if ($count)
			{
				// failed 
				$this->system_message->set_error('Category Already present<br>Unable to Create Category');
			}
			else
			{
				// proceed to create Category
				$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'category');
				
				if ($response)
				{
					// success
					$this->system_message->set_success('Category Edited successfully');
				}
				else
				{
					// failed
					$this->system_message->set_error('Something went wrong');
				}
			}
			
			refresh();
		}

		// Parent category 
		/*$parent = $this->category_model->get_parent_category();
		$select_parent = array(0 => 'Select parent category');
		foreach ($parent as $key => $value) {
			$select_parent[] = array($value->id => $value->display_name);
		}*/
		if( $udata[0]['group_id'] != 5 ){
			$parent1 = $this->custom_model->my_where('category','*',array('status' => 'active','parent' => '0'));
		}
		$select_parent = array();
		foreach ($parent1 as $key => $value) {
			$select_parent[$value['id']] =  $value['display_name'];
			// $select_parent[] = array($value->id => $value->display_name);
		}
		$this->mViewData['parent'] = $select_parent;

		$cate_data = $this->custom_model->my_where('category','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];

		$this->mPageTitle = 'Edit Category';

		$this->mViewData['form'] = $form;
		$this->render('category/create');
	}

	public function tedit($cate_id)
	{
		ini_set('default_charset', 'UTF-8');
		$parent1 = array();
		$udata = $this->custom_model->my_where('admin_users_groups','*',array('user_id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		$this->mViewData['vendor'] = 0;
		if( $udata[0]['group_id'] == 5 ){
			$this->mViewData['vendor'] = 1;		
			$usrdata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","",array(),"",false);
			$catdslug = $usrdata[0]['category'];
			$acategories = $this->custom_model->my_where('category','*',array('status' => 'active'),array(),"parent","asc","","",array(),"object");

			$acatp = array();
			if(!empty($acategories)){
				foreach ($acategories as $ckey => $cvalue) {
					$parent = $cvalue->parent;
					$acatp[$parent][] = $cvalue;
				}
			}

			foreach ($acatp[0] as $ckey => $cvalue) {
				if( $catdslug != $cvalue->slug ){
					unset($acatp[0][$ckey]);
				}
			}
		}	
		if(!empty($acatp)){
			foreach ($acatp as $kcsey => $vacslue) {
				foreach ($vacslue as $ksdey => $vsdalue) {
					$parent1[]= array("display_name" => $vsdalue->display_name, "id" => $vsdalue->id);
				}
			}
		}	

		$form = $this->form_builder->create_form();
		$cate_data = $this->custom_model->my_where('category_trans','*',array('id' => $cate_id));
		if(!isset($cate_data[0]['display_name'])){
			$cate_data = $this->custom_model->my_where('category','*',array('id' => $cate_id));
			 $this->custom_model->my_insert($cate_data[0],'category_trans');
		}
		$post_data = $this->input->post();
		
		if ( !empty($post_data) )
		{
				// proceed to create Category
			$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'category_trans');
			
			if ($response)
			{
				// success
				$this->system_message->set_success('الفئة ترجمة بنجاح');
			}
			else
			{
				// failed
				$this->system_message->set_error('حدث خطأ ما');
			}
			
			refresh();
		}

		// Parent category 
		/*$parent = $this->category_model->get_parent_category();
		$select_parent = array(0 => 'Select parent category');
		foreach ($parent as $key => $value) {
			$select_parent[] = array($value->id => $value->display_name);
		}*/
		if( $udata[0]['group_id'] != 5 ){
			$parent1 = $this->custom_model->my_where('category_trans','*',array('status' => 'active','parent' => '0'));
		}
		$select_parent = array();
		foreach ($parent1 as $key => $value) {
			$select_parent[$value['id']] =  $value['display_name'];
			// $select_parent[] = array($value->id => $value->display_name);
		}
		$this->mViewData['parent'] = $select_parent;

		$cate_data = $this->custom_model->my_where('category_trans','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];

		$this->mPageTitle = 'Edit Category';

		$this->mViewData['form'] = $form;
		$this->render('category/create');
	}


	public function delete($id)
	{
		$this->custom_model->my_delete(array("id" => $id),"category",false);
		$this->custom_model->my_delete(array("id" => $id),"category_trans",false);
		header( "Location: ".base_url()."admin/category/" );die;
	}

}
