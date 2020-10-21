<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Panel management, includes: 
 * 	- Admin Users CRUD
 * 	- Admin User Groups CRUD
 * 	- Admin User Reset Password
 * 	- Account Settings (for login user)
 */
class Panel extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}
		public function index()
	{
		$crud = $this->generate_crud('admin_users');
		$crud->columns('id','fullname','phone', 'email');
		$crud->order_by('id','desc');
		$this->unset_crud_fields('ip_address', 'last_login');
		//$crud->set_relation('country_code', 'country', 'name', 'phonecode');
		$crud->set_theme('datatables');
		//$crud->display_as('country_code','Country');
		// only webmaster and admin can change member groups
		if ($crud->getState()=='list' || $this->ion_auth->in_group(array('webmaster', 'admin')))
		{
			//$crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id', 'group_id', 'name');
		}

		// only webmaster and admin can reset user password
		if ($this->ion_auth->in_group(array('webmaster', 'admin')))
		{
		//	$crud->add_action('refresh', '', 'admin/user/reset_password', 'fa fa-repeat');
		}

		// disable direct create / delete Frontend User
		$crud->where('group_id','5');
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		$crud->unset_operations();

		//$crud->add_action('remove_red_eye', '', 'admin/panel/admin_user_reset_password', '');
		
		$this->mPageTitle = 'Vender List';
		$this->render_crud();
	}
	

	/*public function vendor_user()
	{
		$where = $country = $category = $plan = '';$arr_where = array();
		$get_data = $this->input->get();
if (!empty($get_data))
		{
			if (!empty($get_data['country']))
			{$country = $get_data['country'];
			}
			if (!empty($get_data['category']))
			{
			
				$category = $get_data['category'];
			}
		
		}
		else{
	
		}
		
		$result = $this->custom_model->get_data("SELECT au.id,au.username,au.plan,au.last_name,au.email,au.first_name,au.phone,au.active,au.category,au.start_date,au.end_date,'conversion', (SELECT GROUP_CONCAT(DISTINCT admin_groups.name) FROM admin_groups LEFT JOIN admin_users_groups ON admin_users_groups.group_id = admin_groups.id WHERE admin_users_groups.user_id = `au`.id GROUP BY admin_users_groups.user_id) AS groups FROM `admin_users` AS au LEFT JOIN `admin_users_groups` as `aug` ON `aug`.`user_id` = `au`.`id` WHERE aug.group_id = '5' $where ");
		if (!empty($result))
		{
			$now = time();
			foreach ($result as $key => $value)
			{
				$arr_where['start_date <='] = $now;
				$arr_where['end_date >='] = $now;
				$arr_where['user_id'] = $value->id;

				$this_data = $this->custom_model->my_where('admin_plan','*',$arr_where);
				if (!empty($this_data))
				{
					if(!empty($plan) && $this_data[0]['plan_type'] != $plan)
					{
						unset($result[$key]);
					}
					else{
						$result[$key]->conversion = array('con_pl' => $this_data[0]['plan_type'], 'con_st' => $this_data[0]['start_date'], 'con_ed' => $this_data[0]['end_date']);
					}
					
				}
				elseif($plan != 'silver' && $plan != '')
				{
					unset($result[$key]);
				}
			}
		}

		$this->mViewData['data_list'] = $result;
		$this->mViewData['country'] = $country;
		$this->mViewData['category'] = $category;
		$this->mViewData['plan'] = $plan;

		$this->mViewData['category_data'] = $this->custom_model->my_where('category','*',array('parent' => 0,'status'=>'active'));

		$this->mPageTitle = 'Vendor Users';
		$this->render('panel/vendor_user');
	}
*/
	public function edit($admin_id)
	{
		$form = $this->form_builder->create_form();

		$post_data = $this->input->post();

		//echo $post_data;
		
		if ( !empty($post_data) )
		{
			// echo "<pre>";print_r($post_data);die;

			$cate_data = $this->custom_model->my_where('admin_users','*',array('id' => $admin_id));

			// update commission
			$vendor_comm_type = $this->input->post('vendor_comm_type');
			if ($vendor_comm_type == 'default')
			{
				$post_data['commision'] = $this->input->post('default_commission');
				unset($post_data['default_commission']);
			}
			else if ($vendor_comm_type == 'perCategory')
			{
				$post_data['commision'] = 'yes';
				$ven_per_cat = $this->input->post('ven_per_cat');
				unset($post_data['ven_per_cat']);
			}

			unset($post_data['photo_url']);
			unset($post_data['img_url']);
			unset($post_data['file']);
			unset($post_data['vendor_comm_type']);
			unset($post_data['file_gold']);


			$count = $this->custom_model->record_count('admin_users',array('email' => $post_data['email'], 'id !=' => $admin_id, 'group_id' => '5'));

				// insert commission
				if (isset($ven_per_cat) && !empty($ven_per_cat))
				{
					foreach ($ven_per_cat as $key => $value)
					{
						$comm_data = $this->custom_model->my_where('admin_commission','*', array('admin_id' => $admin_id, 'category_id' => $key, 'status' => 1));

						if (empty($comm_data))
						{
							$this->custom_model->my_insert(array('category_id' => $key, 'admin_id' => $admin_id, 'commission' => $value, 'status' => 1),'admin_commission');
						}
						else{
							$this->custom_model->my_update(array('commission' => $value),array('admin_id' => $admin_id, 'category_id' => $key, 'status' => 1),'admin_commission');
						}
					}
				}

			// $count = 0;
			if ($count)
			{
				// failed 
				$this->system_message->set_error('Email already present<br>Unable to update user');
			}
			else
			{
				// proceed to create Category
				$response = $this->custom_model->my_update($post_data,array('id' => $admin_id),'admin_users');
				
				if ($response)
				{
					// success
					$this->system_message->set_success('Admin edited successfully');
				}
				else
				{
					$this->system_message->set_error('Something went wrong');
				}
			}
			
			redirect(current_url());
		}

		$cate_data = $this->custom_model->my_where('admin_users','*',array('id' => $admin_id));
		if ($cate_data[0]['commision'])
		{
			$all_com = $this->custom_model->my_where('admin_commission','*', array('admin_id' => $cate_data[0]['id'],'status' => 1));

			foreach ($all_com as $key => $value)
			{
				$cate_data[0]['all_com'][$value['category_id']] = $value['commission'];
			}
			
		}

		$cate_data[0]['sub_category'] = $this->custom_model->my_where('category','*', array('parent' => $cate_data[0]['category_id'],'status' => 'active'));

		$this->mViewData['edit'] = $cate_data[0];

		$this->mPageTitle = 'Edit User';

		$this->mViewData['form'] = $form;
		$this->render('panel/admin_user_edit');
	}


	public function tedit($admin_id)
	{	ini_set('default_charset', 'UTF-8');
		$form = $this->form_builder->create_form();
		$cate_data = $this->custom_model->my_where('admin_users_trans', '*', array('id' => $admin_id), array(), "", "","", "", array(), "", array(), false );

		if(!isset($cate_data[0]['id'])){
			$cate_data = $this->custom_model->my_where('admin_users','*',array('id' => $admin_id), array(), "", "","", "", array(), "", array(), false );
			 $this->custom_model->my_insert($cate_data[0],'admin_users_trans');
		}
		$post_data = $this->input->post();
		
		if ( !empty($post_data) )
		{	unset($post_data['photo_url']);
			unset($post_data['img_url']);
			unset($post_data['file']);

			$response = $this->custom_model->my_update($post_data,array('id' => $admin_id),'admin_users_trans');
			if ($response)
			{
				$this->system_message->set_success('User Translate successfully');
			}
			else
			{
				$this->system_message->set_error('Something went wrong');
			}
			refresh();
		}

		$cate_data = $this->custom_model->my_where('admin_users_trans','*',array('id' => $admin_id));
		$this->mViewData['edit'] = $cate_data[0];
		$this->mPageTitle = 'Translate User';
		$this->mViewData['form'] = $form;
		$this->mViewData['type'] = 'trans';
		$this->render('panel/admin_user_edit');
	}


	// Admin Users image CRUD
	public function admin_user_image()
	{
		$crud = $this->generate_image_crud('seller_images','name','assets/uploads','name','name');

		$this->mPageTitle = 'Admin Users Image Upload';
		$this->render_crud();
	}

	// Create Admin User
	public function admin_user_create()
	{
		// (optional) only top-level admin user groups can create Admin User
		//$this->verify_auth(array('webmaster'));

		$form = $this->form_builder->create_form('','','id="wizard_with_validation" class="wizard clearfix"');

		/*if (!empty($this->input->post())) {
			print_r($this->input->post());die;
		}*/
		if ($form->validate())
		{
			// passed validation
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$first_name = $this->input->post('first_name');

			$slug = $this->generate_slug($first_name,'admin_users');

		/*	$categories = '';
			$cate = $this->input->post('category');
			foreach ($cate as $key => $value) {
				$categories .= $value.',';
			}
			$categories = trim($categories,',');*/
			$categories = $this->input->post('category');
			$plan =  $this->input->post('plan');
			$start_date = strtotime($this->input->post('start_date'));
			// $end_date = strtotime($this->input->post('end_date'));
			$end_date1 = date('d M Y 23:59:59',strtotime($this->input->post('end_date')));
			$end_date = strtotime($end_date1);
			$datediff = $end_date - $start_date;
			$datediff = floor($datediff / (60 * 60 * 24));
			$amount = 0;
			if($datediff > 0){
				switch ($plan) {
					case 'gold':
						$amount = $datediff * 10;
						break;
					case 'platinum':
						$amount = $datediff * 5;
						break;
					case 'silver':
						$amount = $datediff * 2;
						break;
					default:
						$amount = $datediff * 1;
						break;
				}
			}

			$branch = $this->input->post('branch');
			$branch_name = $this->input->post('branch_name_save');

			if ($branch)
			{
				$parent = 'yes';
			}
			else{
				$parent = 'no';
			}

			$payment_option = '';
			if (!empty($this->input->post('payment_option')))
			{
				$payment_option = implode(",",$this->input->post('payment_option'));
			}

			// insert commission
			$vendor_comm_type = $this->input->post('vendor_comm_type');
			if ($vendor_comm_type == 'default')
			{
				$commision = $this->input->post('default_commission');
			}
			else if ($vendor_comm_type == 'perCategory')
			{
				$commision = 'yes';
				$ven_per_cat = $this->input->post('ven_per_cat');
			}

			$additional_data = array(
				'first_name'		=> $first_name,
				'phone'				=> $this->input->post('phone'),
				'whatsapp'			=> $this->input->post('whatsapp'),
				'telephone'			=> $this->input->post('telephone'),
				'plan'				=> $this->input->post('plan'),
				'category_id'		=> $this->input->post('category_id'),
				'category'			=> $categories,
				'streat'			=> $this->input->post('streat'),
				'locality'			=> $this->input->post('locality'),
				'landmark'			=> $this->input->post('landmark'),
				'pincode'			=> $this->input->post('pincode'),
				'state'				=> $this->input->post('state'),
				'country'			=> $this->input->post('country'),
				'active'			=> $this->input->post('active'),
				'logo'				=> $this->input->post('file_name_gold'),
				'banner'			=> $this->input->post('file_name'),
				'commision'			=> $commision,
				'slug'				=> $slug,
				'payment_mode'		=> $this->input->post('payment_mode'),
				'debit_card_fee'	=> $this->input->post('vendor_debit_card_fee'),
				'credit_card_fee'	=> $this->input->post('vendor_credit_card_fee'),
				'amount'			=> $this->input->post('vendor_annual_fee'),
				'start_date'		=> strtotime($this->input->post('start_date')),
				'end_date'			=> strtotime($this->input->post('end_date')),
				'parent'			=> $parent,
				'payment_option'	=> $payment_option,
				'group_id'			=> '5'
			);
			$additional_data = store_push($additional_data);
			$groups = $this->input->post('groups');

			// create user (default group as "members")
			$user = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);
			if ($user)
			{
				// insert initial fee
				$vendor_initial_due_date = date('Y-m-d',strtotime($this->input->post('vendor_initial_due_date')));
				$this->custom_model->my_insert(array('admin_id' => $user, 'type' => 'initial', 'amount' => $this->input->post('vendor_initial_fee'), 'due_date' => $vendor_initial_due_date, 'status' => 1),'admin_fee');

				// insert annual fee
				$vendor_annual_due_date = date('Y-m-d',strtotime($this->input->post('vendor_annual_due_date')));
				$this->custom_model->my_insert(array('admin_id' => $user, 'type' => 'annual', 'amount' => $this->input->post('vendor_annual_fee'), 'due_date' => $vendor_annual_due_date, 'status' => 1),'admin_fee');

				// insert commission
				if (isset($ven_per_cat) && !empty($ven_per_cat))
				{
					foreach ($ven_per_cat as $key => $value)
					{
						$this->custom_model->my_insert(array('category_id' => $key, 'admin_id' => $user, 'commission' => $value, 'status' => 1),'admin_commission');
					}
				}

				$branch_count = $this->input->post('branch_count');
				if ($branch && $branch_count)
				{

					if($branch_name)
					{

						$branch_code = $this->custom_model->my_where('admin_groups','*',array('name' => 'vendor'));
							
						// Branch array
						$branch_debit_card_fee 		= $this->input->post('branch_debit_card_fee');
						$branch_credit_card_fee		= $this->input->post('branch_credit_card_fee');
						$branch_initial_fee 		= $this->input->post('branch_initial_fee');
						$branch_initial_due_date 	= $this->input->post('branch_initial_due_date');
						$branch_annual_fee 			= $this->input->post('branch_annual_fee');
						$branch_annual_due_date 	= $this->input->post('branch_annual_due_date');
						$branch_payment_option 		= $this->input->post('branch_payment_option');
						$branch_comm_type 			= $this->input->post('branch_comm_type');
						$branch_default_commission	= $this->input->post('branch_default_commission');
						$bra_per_cat 				= $this->input->post('bra_per_cat');

					}
					else{
						$branch_code = $this->custom_model->my_where('admin_groups','*',array('name' => 'branch'));
					}

					for ($i=1; $i <= $branch_count; $i++)
					{ 
						if (!isset($_POST['st'.$i]))
						{
							break;
						}

						if ($branch_name)
						{
							// insert commission
							$this_commision = '';
							$this_ven_per_cat = array();
							if ($branch_comm_type[$i] == 'default')
							{
								$this_commision = $branch_default_commission[$i];
							}
							else if ($branch_comm_type[$i] == 'perCategory')
							{
								$this_commision = 'yes';
								$this_ven_per_cat = $bra_per_cat[$i];
							}
							else if ($branch_comm_type[$i] == 'perVendor')
							{
								if ($vendor_comm_type == 'default')
								{
									$this_commision = $this->input->post('default_commission');
								}
								else if ($vendor_comm_type == 'perCategory')
								{
									$this_commision = 'yes';
									$this_ven_per_cat = $this->input->post('ven_per_cat');
								}
							}

							$username = $this->input->post('uname'.$i);
							$pass = password_hash($this->input->post('pass'.$i), PASSWORD_BCRYPT);
							$firstname = $this->input->post('ufirstname'.$i);
							$bemail = $this->input->post('bemail'.$i);
							$amount = $branch_annual_fee[$i];
							$debit_card = $branch_debit_card_fee[$i];
							$credit_card = $branch_credit_card_fee[$i];
							$payment_option = implode(",",$branch_payment_option[$i]);
							$slug = $this->generate_slug($firstname,'admin_users');
							$banner = $this->input->post('br_file_name'.$i);
							$logo = $this->input->post('br_file_name_gold'.$i);
						}
						else{
							$username = $username.'_branch_'.$i;
							$pass = password_hash($password, PASSWORD_BCRYPT);
							$firstname = $username.' branch '.$i;
							$bemail = $email;
							$amount = '0';
							$debit_card = $this->input->post('vendor_debit_card_fee');
							$credit_card = $this->input->post('vendor_credit_card_fee');
							$slug = $this->generate_slug($firstname,'admin_users');
							$banner = $logo = '';
							if ($vendor_comm_type == 'default')
							{
								$this_commision = $this->input->post('default_commission');
							}
							else if ($vendor_comm_type == 'perCategory')
							{
								$this_commision = 'yes';
								$this_ven_per_cat = $this->input->post('ven_per_cat');
							}
						}
						
						$today = date('d F Y');
						if ($today == $this->input->post('startdate'.$i))
						{
							$act = 1;
						}
						else{
							$act = 0;
						}

						$end_date1 = date('d M Y 23:59:59',strtotime($this->input->post('expdate'.$i)));
						$end_date = strtotime($end_date1);
						$admin_branch = array(
							'parent' 			=> $user,
							'username' 			=> $username,
							'first_name'		=> $firstname,
							'password' 			=> $pass,
							'email' 			=> $bemail,
							'logo'				=> $logo,
							'banner'			=> $banner,
							'plan'				=> 'silver',
							'streat' 			=> $this->input->post('st'.$i),
							'locality' 			=> $this->input->post('lty'.$i),
							'landmark' 			=> $this->input->post('ldmk'.$i),
							'pincode' 			=> $this->input->post('pc'.$i),
							'start_date'		=> strtotime($this->input->post('startdate'.$i)),
							'end_date' 			=> $end_date,
							'phone' 			=> $this->input->post('phone'.$i),
							'whatsapp'			=> $this->input->post('whatsapp'.$i),
							'telephone'			=> $this->input->post('telephone'.$i),
							'commision'			=> $this_commision,
							'created_on'		=> time(),
							'amount'			=> $amount,
							'category_id'		=> $this->input->post('bcategory_id'.$i),
							'category'			=> $this->input->post('bcategory'.$i),
							'active'			=> $act,
							'slug'				=> $slug,
							'debit_card_fee'	=> $debit_card,
							'credit_card_fee'	=> $credit_card,
							'payment_option'	=> $payment_option,
							'group_id' 			=> $branch_code[0]['id']
							);
						$branch_id = $this->custom_model->my_insert($admin_branch,'admin_users');

						$branch_group = array(
							'user_id' => $branch_id,
							'group_id' => $branch_code[0]['id']
							);
						$this->custom_model->my_insert($branch_group,'admin_users_groups');

						// insert commission
						if (!empty($this_ven_per_cat))
						{
							foreach ($this_ven_per_cat as $ckey => $cvalue)
							{
								$this->custom_model->my_insert(array('category_id' => $ckey, 'admin_id' => $branch_id, 'commission' => $cvalue, 'status' => 1),'admin_commission');
							}
						}

						if ($branch_name)
						{
							// insert branch initial fee
							$branch_initial_dd = date('Y-m-d',strtotime($branch_initial_due_date[$i]));

							$this->custom_model->my_insert(array('admin_id' => $branch_id, 'type' => 'initial', 'amount' => $branch_initial_fee[$i], 'due_date' => $branch_initial_dd, 'status' => 1),'admin_fee');

							// insert branch annual fee
							$branch_annual_dd = date('Y-m-d',strtotime($branch_annual_due_date[$i]));

							$this->custom_model->my_insert(array('admin_id' => $branch_id, 'type' => 'annual', 'amount' => $branch_annual_fee[$i], 'due_date' => $branch_annual_dd, 'status' => 1),'admin_fee');
						}

					}
				}

				$message = '<h5 style="font-size: 12px; margin-top: -16px;"> Hi '.$first_name.',</h5><br/>
        <p style="font-size: 11px; color:#696969;">
                Thank you for creating a My_en seller account. You’re all ready to go!<br/><br/>
                My_en is market place for all health related products. My_en <br/>
                makes the consumer easy to purchase the items from different seller
                in best price.<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                Get the benefits of selling the items and making maximum business profits 
                from My_en market place.<br/><br/>
                Make the payment to active your account<br/>
              </p>
                <a href="'.base_url('wsapp/makemypaymeny/pay/annual?key=').en_de_crypt($user).'" style="margin-left: 104px; margin-top: 20px; width: 100% !important;padding: 10px 0px;background: #9bc03c;border: none;color: #fff;font-size: 14px;text-transform: uppercase;text-decoration: none;border-radius: 3px;margin: 15px 0 15px 0; cursor: pointer;clear: both; 
		overflow: hidden;margin: auto;display: inline-block;font-weight: 500;text-align: center;">Pay Now</a>';

                	$emails = $email.",vjkulkarni11771@gmail.com";
                	// $emails = "vjkulkarni11771@gmail.com";
					$subject = "Welcome to My_en";
					send_email($emails,$subject,$message);

				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			}
			else
			{
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			//refresh();
			
		}
		// upload image
		//$crud = $this->generate_image_crud('seller_images','name','assets/uploads','name','name');
		//$this->mViewData['crud_output'] = $this->render_img_crud();


		$this->mViewData['categories'] = $this->custom_model->get_all_categories();

		$this->mViewData['payment_option'] = $this->custom_model->my_where('payment_option','*',array('status' => 1),array(), "","", "", "", array(), "", array(), false);

		$this->mViewData['default_commission'] = $this->custom_model->my_where('admin_option','meta_value',array('meta_key' => 'default_commission'));

		$this->mViewData['transaction_creadit_fee'] = $this->custom_model->my_where('admin_option','meta_value',array('meta_key' => 'transaction_creadit_fee'));

		$this->mViewData['transaction_debit_fee'] = $this->custom_model->my_where('admin_option','meta_value',array('meta_key' => 'transaction_debit_fee'));

		$groups = $this->ion_auth->groups()->result();
		unset($groups[0]);	// disable creation of "webmaster" account
		$this->mViewData['groups'] = $groups;
		$this->mPageTitle = 'Create Vendor';

		$this->mViewData['form'] = $form;
		$this->render('panel/admin_user_create');
	}

	// Admin User Groups CRUD
	public function admin_user_group()
	{
		$crud = $this->generate_crud('admin_groups');
		$crud->set_theme('datatables');
		$this->mPageTitle = 'Admin User Groups';
		$this->render_crud();
	}

	// Admin User Reset password
	public function admin_user_reset_password($user_id)
	{
		// only top-level users can reset Admin User passwords
		$this->verify_auth(array('webmaster'));

		$form = $this->form_builder->create_form();
		if ($form->validate())
		{
			// pass validation
			$data = array('password' => $this->input->post('new_password'));
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

		$this->load->model('admin_user_model', 'admin_users');
		$target = $this->admin_users->get($user_id);
		$this->mViewData['target'] = $target;

		$this->mViewData['form'] = $form;
		$this->mPageTitle = 'Reset Admin User Password';
		$this->render('panel/admin_user_reset_password');
	}

	// Account Settings
	public function account()
	{
		// Update Info form
		$form1 = $this->form_builder->create_form($this->mModule.'/panel/account_update_info');
		$form1->set_rule_group('panel/account_update_info');
		$this->mViewData['form1'] = $form1;

		// Change Password form
		$form2 = $this->form_builder->create_form($this->mModule.'/panel/account_change_password');
		$form1->set_rule_group('panel/account_change_password');
		$this->mViewData['form2'] = $form2;

		$this->mPageTitle = "Account Settings";
		$this->render('panel/account');
	}

	// Submission of Update Info form
	public function account_update_info()
	{
		$data = $this->input->post();
		if ($this->ion_auth->update($this->mUser->id, $data))
		{
			$messages = $this->ion_auth->messages();
			$this->system_message->set_success($messages);
		}
		else
		{
			$errors = $this->ion_auth->errors();
			$this->system_message->set_error($errors);
		}

		redirect($this->mModule.'/panel/account');
	}

	// Submission of Change Password form
	public function account_change_password()
	{
		$new_password = $this->input->post('new_password');
		$retype_password = $this->input->post('retype_password');

		if ($new_password != $retype_password)
		{
			$this->system_message->set_error("Password Miss Match");

		}
		else{
			$data = array('password' => $this->input->post('new_password'));
			if (!empty($new_password) && !empty($retype_password))
			{
				if ($this->ion_auth->update($this->mUser->id, $data))
				{
					$messages = $this->ion_auth->messages();
					$this->system_message->set_success($messages);
				}
				else
				{
					$errors = $this->ion_auth->errors();
					$this->system_message->set_error($errors);
				}
			}
			else
			{
				$this->system_message->set_error('All fields are required');
			}
		}
		
		

		redirect($this->mModule.'/panel/account');
	}
	
	/**
	 * Logout user
	 */
	public function logout()
	{
		$this->ion_auth->logout();
		redirect($this->mConfig['login_url']);
	}

	public function get_sub_category()
	{
		$category = $this->input->post('category');

		$sub_category = array();
		if (!empty($category))
		{
			$sub_category = $this->custom_model->my_where('category','*', array('parent' => $category,'status' => 'active'));
		}
		
		echo json_encode($sub_category);
	}

	public function check_user()
	{
		$username = $this->input->post('username');
		$parameter = $this->input->post('parameter');

		if (!empty($username) && !empty($username))
		{
			$records = $this->custom_model->my_where('admin_users','*',array($parameter=>$username));
			if (!empty($records))
			{
				echo false;
			}
			else{
				echo true;
			}
		}
		else{
			echo '-1';
		}
	}

	public function delete($id)
	{
		$this->custom_model->my_delete(array("id" => $id),"admin_users",false);
		$this->custom_model->my_delete(array("id" => $id),"admin_users_trans",false);
		header( "Location: ".base_url()."admin/panel/vendor_user" );die;
	}

}