<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	public function index()
		{
			$udata = $this->custom_model->my_where('users','id,username,email,first_name,phone,source,last_name',array(),array(),"","","","","",array(),"",false);
			
			foreach ($udata as $key => $avalue) 
		    	{
		    		$id = $avalue['id'];
		    		$orders = $this->custom_model->my_where('order_master','*',array('user_id'=>$avalue['id']));
		    		@$last_order = $this->custom_model->my_where("order_master","order_datetime,user_id,order_master_id",array('user_id'=>$avalue['id']),array(),"order_master_id","DESC");
			    	$udata[$key]['orders_count']= count($orders);
			    	$udata[$key]['last_order']= @$last_order[0]['order_datetime'];
		    		
		    	}
			$this->mViewData['udata'] = $udata;
			$this->render('user/list');
			
		}

// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			// passed validation
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$identity = empty($username) ? $email : $username;
			$additional_data = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'phone'		=> $this->input->post('phone'),
			);

			$additional_data = store_push($additional_data);
			$groups = $this->input->post('groups');

			// [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
			$this->ion_auth_model->tables = array(
				'users'				=> 'users',
				'groups'			=> 'groups',
				'users_groups'		=> 'users_groups',
				'login_attempts'	=> 'login_attempts',
			);

			// proceed to create user
			$user_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups);			
			if ($user_id)
			{
				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);

				// directly activate user
				$this->ion_auth->activate($user_id);
			}
			else
			{
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$this->load->model('group_model', 'groups');
		$this->mViewData['groups'] = $this->groups->get_all();
		$this->mPageTitle = 'Create User';

		$this->mViewData['form'] = $form;
		$this->render('user/create');
	}


	public function _cb_col_full_name($value, $row)
		{
				$str = $row->first_name.' '.$row->last_name;
				return $str;
		}

	public function _cb_col_sourcenew($value, $row)
		{
			if($row->source=="normal")
				{
					return "Mobile";
				}
			else if($row->source=" ")
				{
					return "Missing Source";	
				}	
			else
				{
					return $row->source;
				}
		}	

    public function export_users()
    {
    	$export_data =array();
		// filename for download
	    $filename = "website_data_" . date('Ymd') . ".xlsx";
		header("Content-Disposition: attachment; filename=\"$filename\"");
	    header("Content-Type: text/xlsx");
		$out = fopen("php://output", 'w');
		$flag = false;
    	$data = $this->custom_model->my_where('users','id,email,username,first_name,last_name,phone,city,country,state',array());
    	foreach ($data as $key => $value) 
    	{
    		$orders = $this->custom_model->my_where('order_master','*',array('user_id'=>$value['id']));
    		$export_data[$key]['Orders']= count($orders);
    		$export_data[$key]['Name']= $value['first_name']." ".$value['last_name'];
    		$export_data[$key]['Email']= $value['email'];
    		$export_data[$key]['Mobile Number']= $value['phone'];
    		$export_data[$key]['City']= $value['city'];
    		$export_data[$key]['State']= $value['state'];
    		$export_data[$key]['Country']= $value['country'];
    	}
		foreach($export_data as $row) 
		{
			if(!$flag)
			    {
			      fputcsv($out, array_keys($row), ',', '"');
			      $flag = true;
			    }
			fputcsv($out, array_values($row), ',', '"');
		 }
		 fclose($out);
		 exit;
    }


    public function export_user_orders($id=0)
    {
    	$export_data =array();
	    
    	$data = $this->custom_model->my_where('users','id,email,username,first_name,last_name,phone,city,country,state',array('id'=>$id));
    	if(empty($data))
	    	{
	    		echo "User Not Found On System";
	    		redirect('admin/user?msg=user_not_found');
	    		die();
	    	}
    	foreach ($data as $key => $avalue) 
	    	{
	    		$orders = $this->custom_model->my_where('order_master','*',array('user_id'=>$avalue['id']));
	    		if(empty($orders))
			    	{
			    		echo "No Orders Yet";
			    		redirect('admin/user?msg=orders_not_found');
			    		die();
			    	}
	    		foreach ($orders as $key => $value) 
		    		{
			    		$export_data[$key]['Order Id']= $value['display_order_id'];
			    		$export_data[$key]['Email']= $avalue['email'];
			    		$export_data[$key]['Shipping Charge']= $value['shipping_charge'];
			    		$export_data[$key]['Net Total']= $value['net_total'];
			    		$export_data[$key]['Tax']= $value['tax'];
			    		$export_data[$key]['Payement Mode']= $value['payment_mode'];
			    		$export_data[$key]['Order Status']= $value['order_status'];
			    		$export_data[$key]['Order Date']= $value['order_datetime'];
		    		}
	    		
	    	}

	    $filename = "UserOrders" . date('Ymd') . ".xlsx";
		header("Content-Disposition: attachment; filename=\"$filename\"");
	    header("Content-Type: text/xlsx");
		$out = fopen("php://output", 'w');
		$flag = false;	
		foreach($export_data as $row) 
			{
				if(!$flag)
				    {
				      fputcsv($out, array_keys($row), ',', '"');
				      $flag = true;
				    }
				fputcsv($out, array_values($row), ',', '"');
			 }
		 fclose($out);
		 exit;
    }


	

	public function details_to()
	{
		$udata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		
		$user_id = $this->mUser->id;
		if($user_id != '1'){redirect('admin');}
		
		$crud = $this->generate_crud('users');
		$crud->columns('id','first_name', 'last_name','phone', 'email','source');
		$this->unset_crud_fields('ip_address', 'last_login');
		//$crud->set_relation('country_code', 'country', 'name', 'phonecode');
		$crud->set_theme('datatables');
		//$crud->display_as('country_code','Country');
		// only webmaster and admin can change member groups
		if ($crud->getState()=='list' || $this->ion_auth->in_group(array('webmaster', 'admin')))
		{
			$crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id', 'group_id', 'name');
		}

		// only webmaster and admin can reset user password
		if ($this->ion_auth->in_group(array('webmaster', 'admin')))
		{
		/*	$crud->add_action('refresh', '', 'admin/user/reset_password', 'fa fa-repeat');*/
		}
        
         $crud->where('type', 'patient');
		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		$crud->unset_operations();

		$crud->add_action('remove_red_eye', '', 'admin/user/details', '');

	/*	$crud->add_action('person', '', 'admin/user/idetails', '');*/
		
		$this->mPageTitle = 'Users';
		$this->render_crud();
	}


	

	// view details
	public function details($user_id1)
	{

		$udata = $this->custom_model->my_where('admin_users','*',array('id' => $this->mUser->id),array(),"","","","","",array(),"",false);
		$user_id = $this->mUser->id;
		if($user_id != '1'){redirect('admin');}
		$target = $this->custom_model->my_where('users','*',array('id'=>$user_id1),array(),"","","","","",array(),"",false);
		$this->mViewData['target'] = $target;
		$this->render('user/details');
	}

	public function idetails($user_id)
	{
		$this->load->model('user_model', 'user_model');
		$target = $this->user_model->get($user_id);
		$order_history = $this->custom_model->my_where('order_master','*',array('customer_id' => $user_id));
		$insurance_data = $this->custom_model->my_where('order_insurance','*',array('customer_id' => $user_id));
		$prescription_Pre = $this->custom_model->my_where('prescription','*',array('customer_id' => $user_id));
		//print_r($order_history);
		$this->mViewData['order_history'] = $order_history;
		$this->mViewData['insurance_data'] = $insurance_data;
		$this->mViewData['prescription_Pre'] = $prescription_Pre;
		$this->mViewData['target'] = $target;
		$this->render('user/idetails');
	}

	// User Groups CRUD
	public function group()
	{
		$crud = $this->generate_crud('groups');
		$this->mPageTitle = 'User Groups';
		$this->render_crud();
	}

	// Frontend User Reset Password
	public function reset_password($user_id)
	{
		// only top-level users can reset user passwords
		$this->verify_auth(array('webmaster', 'admin'));

		$form = $this->form_builder->create_form();
		if ($form->validate())
		{
			// pass validation
			$data = array('password' => $this->input->post('new_password'));
			
			// [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
			$this->ion_auth_model->tables = array(
				'users'				=> 'users',
				'groups'			=> 'groups',
				'users_groups'		=> 'users_groups',
				'login_attempts'	=> 'login_attempts',
			);

			// proceed to change user password
			if ($this->ion_auth->update($user_id, $data))
			{
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			}
			else
			{
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$this->load->model('user_model', 'users');
		$target = $this->users->get($user_id);
		$this->mViewData['target'] = $target;
		$this->mViewData['order_history'] = $order_history;
		$this->mViewData['insurance_data'] = $insurance_data;
		$this->mViewData['prescription_Pre'] = $prescription_Pre;

		$this->mViewData['form'] = $form;
		$this->mPageTitle = 'Reset User Password';
		$this->render('user/reset_password');
	}
}
