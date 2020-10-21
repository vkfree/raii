<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends Admin_Controller {

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
		$crud = $this->generate_crud('confirm_booking');

		$crud->columns('id', 'driver', 'user_id', 'vehicle');
		// $crud->display_as('editor','editor');
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


	public function list1($type = '')
	{
		//print_r($type); die;

		//$type = $this->input->post('type');
		$now = date('Y/m/d' ,strtotime('today'));

		if ($type == 'today')
		{
			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `created_on` LIKE '%$now%' ORDER BY 'id' DESC");
			// echo "<pre>";
			// print_r($response); die;
			//echo json_encode($response); die;
		}

		elseif ($type == 'week')
		{
			$last_week_listing = date("Y/m/d", strtotime($now. "-6day"));
  			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `created_on` BETWEEN '$last_week_listing'  AND '$now'   ORDER BY 'id' DESC");

  			// echo "<pre>";
			// print_r($response); die;

  			//echo json_encode($response); die;
		}

		elseif ($type == 'month')
		{
			$last_month_listing = date("Y/m/d", strtotime($now. "-1 months"));
  			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `created_on` BETWEEN '$last_month_listing'  AND '$now' ORDER BY 'id' DESC ");
  			//echo json_encode($response); die;
		}

		elseif ($type == 'year')
		{
			$last_year_listing = date("Y-m-d", strtotime($now. "-1 years"));

			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `created_on` BETWEEN '$last_year_listing'  AND '$now' ORDER BY 'id' DESC ");
		}

		elseif ($type == 'open')
		{
			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `status` = 'open' ORDER BY 'id' DESC");
			// echo "<pre>";
			// print_r($response); die;
			//echo json_encode($response); die;
		}


		elseif ($type == 'close')
		{
			$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE `status` = 'close' ORDER BY 'id' DESC");
			// echo "<pre>";
			// print_r($response); die;
			//echo json_encode($response); die;
		}


		elseif ($type == 'date')
		{
			$post_data = $this->input->post();

			if (!empty($post_data))
			{
				$post_start_date = $post_data['fromdate'];
				$post_end_date = $post_data['todate'];
			}
			else
			{
				$post_start_date 	= $_GET['fromdate'];
		        $post_end_date 		= $_GET['todate'];
			}			

			//print_r($post_data); die;
			if (!empty($post_start_date) && !empty($post_end_date))
			{
				// echo "string";
				// print_r($post_data); die;
				$response = $this->custom_model->get_data("SELECT * FROM ticket WHERE created_on BETWEEN '$post_start_date' AND '$post_end_date' ORDER BY 'id' DESC");
				$this->mViewData['post_start_date'] = $post_start_date;
				$this->mViewData['post_end_date'] = $post_end_date;

				// echo "<pre>";
				// print_r($response); die;

				//echo json_encode($response); die;
			}
		}

		elseif ($type == '')
		{
			$type = '';
			$response = $this->custom_model->my_where("ticket","*","",array(),"id","DESC","","", array(), "object",array(),true );
		}

		// echo "<pre>";
		// print_r($response); die;
		
		$this->load->library('pagination');   
        $config['base_url'] =  base_url().'admin/ticket/list1/'.$type;
        $cpage = (isset($_GET['p']) && is_numeric($_GET['p']))?$_GET['p']:1;
        $limit = 12;
        $start = ($cpage - 1) * $limit;
        $config['total_rows'] = count($response);
        $config['per_page'] = $limit;
        $response = array_slice($response,$start,$limit);
        $this->pagination->initialize($config);
        $count = count($response);
        $pagination = $this->pagination->create_links();
		$this->mViewData['pagination'] = $pagination;
		$this->mViewData['count'] = $count;
		$this->mViewData['total'] = $config['total_rows'];
		$this->mViewData['type'] = $type;
		$this->mPageTitle = 'Ticket List';
		$this->mViewData['response'] = $response;
		// echo json_encode($response);
   	 	$this->render('ticket/list1');
	   	}

	

	
	public function details($cate_id)
	{
		//print_r($cate_id); die;
		$cust_details = $this->custom_model->my_where("admin_users","*",array('id' => $cate_id));
		
		/*$response = $this->custom_model->get_data("SELECT * FROM user_rating  WHERE rating BETWEEN 1 AND 2 AND to_id = $cate_id ");*/
		$details = $this->custom_model->my_where("ticket","*",array('id' => $cate_id));
	
		if (!empty($details[0]['user_id']))
		{
			$by = $details[0]['user_id'];

			$raised_against1 = $this->custom_model->my_where("confirm_booking","*",array("id" => $by) );

			if (!empty($raised_against1[0]['driver_id'])) 
			{	
				$driver_id = $raised_against1[0]['driver_id'];
				$raised_against = $this->custom_model->my_where("admin_users","phone,logo,id,first_name,email",array("id" => $driver_id) );
				if (!empty($raised_against)) {
					$this->mViewData['raised_against'] = $raised_against[0];
				}
			}
			
		}

		elseif (!empty($details[0]['booking_id']))
		{
			$by = $details[0]['booking_id'];
			$raised_against1 = $this->custom_model->my_where("confirm_booking","*",array("id" => $by) );

			if (!empty($raised_against1[0]['driver_id'])) 
			{	
				$driver_id = $raised_against1[0]['driver_id'];
				$raised_against = $this->custom_model->my_where("admin_users","phone,logo,id,first_name,email",array("id" => $driver_id) );
				if (!empty($raised_against)) {
					$this->mViewData['raised_against'] = $raised_against[0];
				}
			}
			
		}

		if (!empty($details[0]['email']))
		{
			$by = $details[0]['email'];
			$raised_by = $this->custom_model->my_where("admin_users","phone,logo,id,first_name,email",array("email" => $by) );
			if (!empty($raised_by)) {
				$this->mViewData['raised_by'] = $raised_by[0];
			}

			// echo "<pre>";
			// print_r($raised_by); die;
		}

		elseif (empty($raised_by))
		{
			$by = $details[0]['phone'];
			$raised_by = $this->custom_model->my_where("admin_users","phone,logo,id,first_name,email",array("phone" => $by) );
			if (!empty($raised_against)) {
				$this->mViewData['raised_by'] = $raised_by[0];
			}

			
		}


		$post_data = $this->input->post();

		// echo "<pre>";
		// print_r($details); die;

		$update = $this->custom_model->my_update($post_data,array("id" => $cate_id),"ticket");

		$details = $this->custom_model->my_where("ticket","*",array("id" => $cate_id) );

		// echo "<pre>";
		// print_r($details); die;


		$this->mViewData['cate_id'] = $cate_id;
		$this->mViewData['details'] = $details[0];
		$this->mPageTitle = 'Details';
		$this->render('ticket/details');
	}


	// Create Frontend Category
	public function create()
	{
		$form = $this->form_builder->create_form();
		$post_data = $this->input->post();
		//echo "<pre>";print_r($post_data); die;
		if ( !empty($post_data))
		{
			date_default_timezone_set('Asia/Kolkata');
			$created_on = date("Y/m/d h:i:s");

			if (empty($post_data['booking_id'])) {
				$post_data['booking_id'] = '0';
			}
			if (empty($post_data['user_id'])) {
				$post_data['user_id'] = '0';
			}

			$post_data = array(
					'user_type' => $post_data['user_type'] ,
					'user_id' => $post_data['user_id'] ,
					'booking_id' => $post_data['booking_id'] ,
					'priority' => $post_data['priority'] ,
					'status' => $post_data['status'] ,
					'subject' => $post_data['subject'] ,
					'email' => $post_data['email'] ,
					'issue' => $post_data['issue'] ,
					'created_on' => $created_on
				);

			$response = $this->custom_model->my_insert($post_data,'ticket');

			//echo "<pre>";print_r($post_data); die;
			if ($response)
			{
				// success
				$this->system_message->set_success('Successfully');
			}
			else
			{
				// failed
				$this->system_message->set_error('Something went wrong');
			}
		
			refresh();
		}

		$this->mPageTitle = 'Create Ticket';

		$this->mViewData['form'] = $form;
		$this->render('ticket/create');
	}


	public function delete($cate_id)
	{
		$this->custom_model->my_delete(array("id" => $cate_id),"pages",false);
        $this->custom_model->my_delete(array("id" => $cate_id),"pages_trans",false);
        header( "Location: ".base_url()."admin/pages" );die;
	}

}