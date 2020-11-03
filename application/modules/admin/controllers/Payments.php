<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends Admin_Controller {


	public function __construct()
		{
			parent::__construct();
			$this->load->library('form_builder');
			$this->load->model('custom_model');
		}

	
	public function list()
		{
			$store_order = $this->custom_model->my_where('store_order','*',array(),array(),"","","","","",array(),"",false);
			if(!empty(@$store_order))
				{
					foreach ($store_order as $key => $value) 
						{
							$store = $this->custom_model->my_where('store','*',array('id'=>$value['store_id']),array(),"","","","","",array(),"",false);
							$user = $this->custom_model->my_where('users','*',array('id'=>$value['user_id']),array(),"","","","","",array(),"",false);

							$store_order[$key]['name_of_store'] = @$store[0]['name'];
							$store_order[$key]['price_of_store'] = @$store[0]['price'];
							$store_order[$key]['image'] = @$store[0]['image'];
							$store_order[$key]['name_of_user'] = @$user[0]['first_name']." ".@$user[0]['last_name'];
							$store_order[$key]['email'] = @$user[0]['email'];
							$store_order[$key]['phone'] = @$store[0]['phone'];
						}
				}
			$this->mViewData['store_order'] = $store_order;
			$this->render('payments/list');
		}		


}	