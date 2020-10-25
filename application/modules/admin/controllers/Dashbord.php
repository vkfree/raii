<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashbord extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	public function index()
	{
		$store_order = array();
		
		$form = $this->form_builder->create_form('','','id="wizard_with_validation" class="wizard clearfix"');

		$users = $this->custom_model->my_where('users','*',array(),array(),"","DESC","id","", array(), "",array(),false );
		$rewards = $this->custom_model->my_where('store','*',array(),array(),"","DESC","id","", array(), "",array(),false );
		$survey = $this->custom_model->my_where('survey','*',array(),array(),"","DESC","id","", array(), "",array(),false );
		$orders = $this->custom_model->my_where('order_table','*',array(),array(),"","DESC","id","", array(), "",array(),false );

		$this->mViewData['user_count'] 	 = count($users);	
		$this->mViewData['reward_count'] = count($rewards);	
		$this->mViewData['store_count']  = count($survey);	
		$this->mViewData['orders_count'] = count($orders);	


		$this->mViewData['orders']  = array_slice($orders,0,10);	
		$this->mViewData['users']   = array_slice($users,0,10);	
		$this->mViewData['survey']  = array_slice($survey,0,10);	
		$this->mViewData['rewards'] = array_slice($rewards,0,10);	

		$store_order = $this->custom_model->my_where('store_order','*',array(),array(),"","","","", array(), "",array(),false );
		if(!empty($store_order))
			{
				foreach ($store_order as $key => $value) 
					{
						$user = $this->custom_model->my_where('users','*',array('id'=>@$value['user_id']),array(),"","","","", array(), "",array(),false );
						$store = $this->custom_model->my_where('store','*',array('id'=>@$value['store_id']),array(),"","","","", array(), "",array(),false );
						$store_order[$key]['user_name'] = @$user[0]['first_name']." ".@$user[0]['last_name'];
						$store_order[$key]['email'] 	  = @$user[0]['email'];
						$store_order[$key]['source'] 	  = @$user[0]['source'];
						$store_order[$key]['phone']     = @$user[0]['phone'];
						$store_order[$key]['store_name']  = @$store[0]['name'];
						$store_order[$key]['image']     	= @$store[0]['image'];
						$store_order[$key]['price']     	= @$store[0]['price'];
					}				
			}
		$this->mViewData['store_order'] = $store_order;

		
		$now = date('Y-m-d' ,strtotime('today'));
		$month = date('Y-m' ,strtotime('today'));
		$date = date('Y-m-d');
		$this->mPageTitle = 'Dashbord';
		$this->render('admin/dashbord', 'plain');
	}

	public function get_chart_data()
		{
			
		}



}