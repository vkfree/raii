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
		
		$form = $this->form_builder->create_form('','','id="wizard_with_validation" class="wizard clearfix"');

		$driver = $this->custom_model->my_where('admin_users','*',array('type' => "driver"),array(),"","","","", array(), "",array(),false );
		$this->mViewData['driver'] = $driver;

		// $latest_booking = $this->custom_model->get_data("SELECT confirm_booking.*,admin_users.first_name FROM confirm_booking INNER JOIN admin_users ON confirm_booking.user_id = admin_users.id  ORDER BY `id` DESC LIMIT 6"); 
		// $this->mViewData['latest_booking'] = $latest_booking;

		// echo "<pre>";
		// print_r($latest_booking); die;

		$u_count = $this->custom_model->get_data("SELECT COUNT(id) as ida FROM admin_users WHERE type = 'user' ");
	    foreach($u_count as $rowa)
	    {
	   		$u_count = $rowa->ida;
	  	}
		$this->mViewData['u_count'] = $u_count;


		$d_count = $this->custom_model->get_data("SELECT COUNT(id) as ida FROM admin_users WHERE type = 'driver' ");
	    foreach($d_count as $rowa)
	    {
	   		$d_count = $rowa->ida;
	  	}
		$this->mViewData['d_count'] = $d_count;




		$now = date('Y-m-d' ,strtotime('today'));
		$month = date('Y-m' ,strtotime('today'));

		//Today's orders
		// $t_booking = $this->custom_model->get_data("SELECT COUNT(id) as ida FROM confirm_booking WHERE status = 'complete' ");
	 //    foreach($t_booking as $rowa)
	 //    {
	 //   		$t_booking = $rowa->ida;
	 //  	}
		// $this->mViewData['t_booking'] = $t_booking;


		// $pending_order = $this->custom_model->get_data("SELECT COUNT(id) as ida FROM confirm_booking WHERE status = 'pending' ");
	 //     foreach($pending_order as $rowa)
	 //    {
	 //   		$pending_order = $rowa->ida;
	 //  	}	  	
		// $this->mViewData['pending_order'] = $pending_order;



		// print_r($pending_order);die;


	    // daily job applied for todays count
		$date = date('Y-m-d');
		// print_r($date); die;




		$this->mPageTitle = 'Dashbord';
		$this->render('admin/dashbord', 'plain');
	}
}