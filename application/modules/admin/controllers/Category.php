<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller {

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

		$car_list = $this->custom_model->my_where('category','*',array(),array(),"","asc","","",array(),"");
		//print_r($acatp);die;
		$this->mViewData['car_list'] = $car_list;
		$this->mPageTitle = 'Car List';
		$this->render('category/view');
	}

	// Create Frontend Category
	public function create()
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();

		// echo "<pre>";
		// print_r($post_data); die;

		if ( !empty($post_data) )
		{
			$count = $this->custom_model->record_count('category',array('display_name' => $post_data['display_name']));
			
			if ($count)
			{
				// failed
				$this->system_message->set_error('Car Name Already present<br>Unable to Create');
			}
			else
			{
				$response = $this->custom_model->my_insert([
					'display_name' => $post_data['display_name'], 
					'day_price' => $post_data['day_price'],
					'night_price' => $post_data['night_price'],
					'image' => $post_data['image'],'status' => $post_data['status']],'category');

				$response2 = $this->custom_model->my_insert(['type' => $post_data['display_name'], 'day' =>"day",'price' => $post_data['day_price'],'image' => $post_data['image']],'price');

				$response3 = $this->custom_model->my_insert(['type' => $post_data['display_name'], 'day' =>"night",'price' => $post_data['night_price'],'image' => $post_data['image']],'price');

				if ($response)
				{
					$this->system_message->set_success('Car created successfully');
				}
				else
				{
					$this->system_message->set_error('Something went wrong');
				}
			}
		}
		
		$car_list = $this->custom_model->my_where('admin_users','*',array('type' => 'driver',"active" =>"1"),array(),"","asc","vehicle","",array(),"");

		// print_r($car_list); die;
		$this->mViewData['car_list'] = $car_list;

		$this->mPageTitle = 'Create Car Type';
		$this->mViewData['form'] = $form;
		$this->render('category/create');
	}

	// Edit Frontend Category
	public function edit($cate_id)
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		// echo "<pre>";
		// print_r($post_data); die;
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
				$this->system_message->set_error('Car Name Already present<br>Unable to Create Car');
			}
			else
			{
				$this->custom_model->my_update(['display_name' => $post_data['display_name'] , 'day_price' => $post_data['day_price'],'night_price' => $post_data['night_price'] ,'image' => $post_data['image'] , 'status' => $post_data['status']],['id' => $cate_id],'category');

				$day_price = $this->custom_model->my_where('price','*',array('type' => $post_data['display_name'], 'day'=>"day"));
				if (!empty($day_price)) 
				{
					$day_id = $day_price[0]['id'];
					if (!empty($day_id)) 
					{
						$this->custom_model->my_update(['price' => $post_data['day_price']
							,'image' => $post_data['image']],['id' => $day_id],'price');
					}
				}

				$night_price = $this->custom_model->my_where('price','*',array('type' => $post_data['display_name'], 'day'=>"night"));
				if (!empty($night_price)) 
				{
					$day_id = $night_price[0]['id'];
					if (!empty($day_id)) 
					{
						$this->custom_model->my_update(['price' => $post_data['night_price']
							,'image' => $post_data['image']],['id' => $day_id],'price');
					}
				}


				// proceed to create Category
				$response = $this->custom_model->my_update($post_data,array('id' => $cate_id),'category');
				
				if ($response)
				{
					// success
					$this->system_message->set_success('Car Edited successfully');
				}
				else
				{
					// failed
					$this->system_message->set_error('Something went wrong');
				}
			}
			
			refresh();
		}

		$cate_data = $this->custom_model->my_where('category','*',array('id' => $cate_id));
		$this->mViewData['edit'] = $cate_data[0];

		$this->mPageTitle = 'Edit Car Name & Price';

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
