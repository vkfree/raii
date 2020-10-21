<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statement extends Admin_Controller {

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
		$udata = $this->custom_model->my_where('admin_users_groups','*',array('user_id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		$this->mViewData['vendor'] = 0;

		/* $crud = $this->generate_crud('category');
		$crud->columns('id', 'display_name', 'commission', 'status', 'parent');
		$crud->display_as('commission','Commission (%)');
		$crud->display_as('display_name','Category');
		$this->unset_crud_fields('slug', 'image');
		$crud->set_theme('datatables');
		$crud->unset_add();
		$crud->unset_edit();
		if( $udata[0]['group_id'] == 5 ){
			$crud->unset_operations();
		}else{
			$crud->add_action('translate', '', 'admin/category/tedit', '');
			$crud->add_action('edit', '', 'admin/category/edit', '');
		}
		$this->mPageTitle = 'Category';
		$this->render_crud();*/
	}

	// Create Frontend Category
	public function list1()
	{
		$response = $this->custom_model->my_where("confirm_booking","*","",array("status" =>"complete"),"id","DESC");

		$this->mPageTitle = 'Booking Statement List';
		$this->mViewData['response'] = $response;
		$this->render('statement/list1');
	}


	public function driver()
	{
		$response = $this->custom_model->my_where("admin_users","*","",array("type" =>"driver"),"id","DESC");
		foreach ($response as $key => $value)
		{
			$driver_id = $value['id'];
			$check = $this->custom_model->record_count('confirm_booking', ['driver_id' => $driver_id , "status" =>"complete"]);
			$total_payment = $this->custom_model->my_where("confirm_booking","*",array("driver_id" => $driver_id,"status"=>"complete"),array(""),"id","DESC" );
			
			if (!empty($total_payment)) 
	 		{
	 			//print_r($total_payment); 
	 			$sum = 0;
	 			foreach ($total_payment as $key1 => $value1){
	 			    if (empty($value1['final_price'])) {
	 					$value1['final_price'] = 0;
	 				}
	 				$sum+= $value1['final_price'];
	 				// print_r($sum);
	 				// $sum+= $value1['price'];

	 			}
	 		}
	 		else{
 				$sum = 0;
 			}

			$response[$key]['total_price'] = $sum ."  SAR";
			$response[$key]['total_rides'] = $check ."  Rides";
			// print_r($check); 
		}
		// echo "<pre>";
		// print_r($response);
		// die;
		$this->mPageTitle = 'Driver Statement List';
		$this->mViewData['response'] = $response;
		$this->render('statement/driver');
	}


	// Edit Frontend Category
	public function driver_details($cate_id)
	{
		$response = $this->custom_model->my_where("admin_users","*","",array("type" =>"driver","id"=> $cate_id),"id","DESC");
		foreach ($response as $key => $value)
		{
			$driver_id = $value['id'];
			$check = $this->custom_model->record_count('confirm_booking', ['driver_id' => $driver_id , "status" =>"complete"]);

			$total_payment = $this->custom_model->my_where("confirm_booking","*",array("driver_id" => $driver_id,"status"=>"complete"),array(""),"id","DESC" );
			
			if (!empty($total_payment)) 
	 		{
	 			//print_r($total_payment); 
	 			$sum = 0;
	 			foreach ($total_payment as $key1 => $value1){
	 			    if (empty($value1['final_price'])) {
 						$value1['final_price'] = 0;
 					}
	 				$sum+= $value1['final_price'];
	 				// print_r($sum);
	 				// $sum+= $value1['price'];

	 			}
	 		}
	 		else{
 				$sum = 0;
 			}

			$response[$key]['total_price'] = $sum;
			$response[$key]['total_rides'] = $check;
			// print_r($check); 
		}
		// echo "<pre>";
		// print_r($response); die;

		$date = date("Y/m/d");
 		$todays_payment = $this->custom_model->my_where("confirm_booking","*",array("driver_id" => $cate_id,"status"=>"complete"),array("book_date_time"=>$date),"id","DESC" );
 		// print_r($todays_payment); die;
 		if (!empty($todays_payment)) 
 		{
 			$t_payment = 0;
 			foreach ($todays_payment as $key => $value){
 				$t_payment+= $value['price'];
 				//print_r($sum);
 			}
 		}
 		else{
 			$t_payment = 0;
 		}
 		//print_r($t_payment); die;

		$total_payment = $this->custom_model->my_where("confirm_booking","*",array("driver_id" => $driver_id,"status"=>"complete"),array(""),"id","DESC" );
		foreach ($total_payment as $key => $value)
		{
			$user_id = $value['user_id'];
			$user_name = $this->custom_model->my_where("admin_users","*",array("id" => $user_id));
			$u_name = $user_name[0]['first_name'];
			$total_payment[$key]['user_name'] = $u_name;
		}

		$cate_data = $this->custom_model->my_where('admin_users','*',array('id' => $cate_id));

		$cancel_ride = $this->custom_model->record_count('cancel_ride', ['user_id' => $cate_id ]);
		// echo "<pre>";
		// print_r($cancel_ride); die;

        // $user_review = $this->custom_model->record_count('user_rating',array('to_id' => $cate_id));
		$user_review = $this->custom_model->my_where('user_rating','*',array('id' => $cate_id));
		//print_r($user_review); die;
		if (!empty($user_review))
		{
			$avg = 0;
			foreach ($user_review as $key => $value)
			{
				$avg += $value['rating'];
			}
			$rating_avg = round($avg/$count);
			$user_count = count($user_review);
		}
		else{
			$rating_avg = 0;
			$user_count = 0;
		}

		// echo "<pre>";
		// print_r($response);
		// print_r($rating_avg); die;

		$this->mViewData['cancel_ride'] 	= $cancel_ride;
		
		$this->mViewData['rating_avg'] 		= $rating_avg;
		$this->mViewData['user_count'] 		= $user_count;

		$this->mViewData['t_payment'] 		= $t_payment;
		$this->mViewData['response'] 		= $response[0];
		$this->mViewData['cate_data'] 		= $cate_data[0];
		$this->mViewData['total_payment'] 	= $total_payment;
		$this->mPageTitle = 'driver details';
		$this->render('statement/driver_details','plain');
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
