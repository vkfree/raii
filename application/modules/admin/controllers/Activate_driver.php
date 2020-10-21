<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate_driver extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD');
		$this->load->library('form_builder');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('admin_users');
		$crud->columns('id','first_name','phone', 'email', 'type','vehicle' ,'logo');
		$this->unset_crud_fields('ip_address', 'last_login','source','slug','city','count','plan','parent','priority','category','banner','whatsapp','telephone','streat','locality','landmark','pincode','state','country','payment_mode','payment_option','start_date','end_date','amount','commision','store_type','country_code','fcm_no','last_name','social','active','group_id','category_id','otp_verify','wallet');
		$crud->set_theme('datatables');
		$crud->display_as('first_name','Name');
		$crud->display_as('logo','Image');
		$crud->set_field_upload('logo', UPLOAD_BLOG_POST);
		$crud->add_action('translate', '', 'admin/activate_driver/details', '');
		$crud->where('type','driver');
		$crud->where('active','0');
		$crud->order_by('id','desc');
		$crud->unset_add();
		// $crud->unset_delete();
		$crud->unset_edit();
		// $crud->unset_operations();
		$this->mPageTitle = 'Driver Listing';
		$this->render_crud();
	}


    // view details
	public function details($user_id)
	{
		$user_data = $this->custom_model->my_where('admin_users','*',array('id' => $user_id));
		$user_name = $user_data[0]['first_name'];
		$user_email = $user_data[0]['email'];

		$post_data = $this->input->post();
		$language = $this->uri->segments[1];
		// echo "<pre>";
		// print_r($post_data); 
		// die;
		if (!empty($post_data))
		{
			if ($post_data['status'] == 1)
			{
				$active = $post_data['status'];
				// print_r($active); die;
				$this->custom_model->my_update(['active' => $active], ['id' => $user_id], 'admin_users');

				$message = "<p style='font-size: 12px;'>Hi,$user_name</p>
					<br/><p style='font-size: 12px; color:#696969; margin-top: -15px;'>
					We activate your Driver Account. You can login in App and enjoy our service </p>
					<p style='font-size: 14px; color:#696969; margin-top: 10px;'> KHEDMA Department </p><br/>";
				// print_r($message); die;
		    	$emails = $user_email;
				$subject = "Welcome to KHEDMA ";
				send_email($emails,$subject,$message);
				$this->session->set_flashdata('success','Driver Account Activate successfully !');
			}
			else{
					$active = $post_data['status'];
					// print_r($active); die;
					$this->custom_model->my_update(['active' => $active], ['id' => $user_id], 'admin_users');
					$message = "<p style='font-size: 12px;'>Hi,$user_name</p>
						<br/><p style='font-size: 12px; color:#696969; margin-top: -15px;'>
						We deactive your Account. You cant login in App because admin Deactivate Your Account For security Purpose . </p>
						<p style='font-size: 10px; color:#696969; margin-top: 10px;'> KHEDMA Department </p><br/>";
					// print_r($message); die;
			    	$emails = $user_email;
					$subject = "Welcome to KHEDMA ";
					send_email($emails,$subject,$message);
					$this->session->set_flashdata('success','Driver Account Deactivate successfully !');
				}
		}
		
		$user_data1 = $this->custom_model->my_where('admin_users','*',array('id' => $user_id));

		// echo "<pre>";
		// print_r($user_data); die;
		$this->mViewData['user_data1'] = $user_data1[0];
		$this->mViewData['language'] = $language;
		$this->mViewData['user_id'] = $user_id;
		$this->render('activate_driver/details');
	}

	public function details1($user_id = "")
	{
		$post_data = $this->input->post();
		$language = $this->uri->segments[1];
		// echo "<pre>";
		// print_r($_FILES); 
		// die;
		$file_names = $error = '';
		$data = $info = $con_res = array();
		if (!empty($_FILES)) 
		{
			$name_array = array();
		    $count = count($_FILES['image']['size']);
            $upload_dir = ASSETS_PATH . "/uploads/";

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

		    foreach($_FILES['image']['name'] as $key=>$value)
		    {
		    	if ($_FILES['image']['error'][$key])
			    {
			        $error .= $value.',';
			        continue;
			    }
			    // $this->uploads($_FILES)
			    $newFileName = $value;
			    // print_r($newFileName); die;

			    if (isset($newFileName))
			    {
		            $random_digit = rand(00000, 99999);
		            $target_file  = $upload_dir . basename($newFileName);
		            $ext          = pathinfo($target_file, PATHINFO_EXTENSION);
		            
		            $new_file_name = $random_digit . "." . $ext;
		            $path          = $upload_dir . $new_file_name;
		            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $path)) {
		                // return $new_file_name;
		                // print_r($new_file_name);

		                $this->custom_model->my_insert(array("image"=> $new_file_name,"user_id"=>$post_data['user_id'],"first_name"=>$post_data['first_name']),'image_upload');

						$this->session->set_flashdata('success', 'You have successfully applied to this job');
		            } else {
		                return false;
		            }
		        }
		        else
		        {
		            return false;
		        }
		    }
		}

		$this->mViewData['user_id'] = $user_id;
		$this->render('activate_driver/details1');
	}
}
