<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rewards extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	public function list()
		{
			$udata = $this->custom_model->my_where('store','*',array(),array(),"","","","","",array(),"",false);
			$this->mViewData['udata'] = $udata;
			$this->render('rewards/list');
			
		}
	
	public function create()
		{
			$survey_data = $this->custom_model->my_where('survey','*','');
			$this->render('rewards/create');
		}

	public function store()
		{
			$genrated_id = "RIL_".time().rand(10000,99999);
			$post_data = $this->input->post();
			$config['upload_path'] = './assets/admin/store/';
			$config['allowed_types'] = '*';
            $config['max_size'] = 2000000;
		    $config['max_width'] = 1500000;
		    $config['max_height'] = 1500000;
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if($this->upload->do_upload('upload_image'))
			     {
			        $data['upload_data'] = $this->upload->data();
					$file_name_old=$data['upload_data']['file_name'];
					if(!empty(@$post_data['id']))
						{

							$update_data = array(
													'name'=>@$post_data['name'],
													'price'=>@$post_data['coupoun'],
													'image'=>@$file_name_old
									       		);
							$id = en_de_crypt(@$post_data['id'],'d');
							$update_id = $this->custom_model->my_update($update_data,array('id',$id),'store');
							if($update_id)
								{
									$return_data['status']="success";
									$return_data['msg']="Store updated successfully";
									echo json_encode($return_data);
									die();
								}
							else
								{
									$return_data['status']="error";
									$return_data['msg']="Store update failed";
									echo json_encode($return_data);		
									die();
								}	
						}
					else
						{
							$insert_data = array(
													'name'=>@$post_data['name'],
													'price'=>@$post_data['coupoun'],
													'image'=>@$file_name_old,
													'status'=>'active'
								   				);
							$insert_id = $this->custom_model->my_insert($insert_data,'store');
							if($insert_id)
								{
									$return_data['status']   = "success";
									$return_data['msg']="Store created successfully";
									echo json_encode($return_data);
									die();
								}
							else
								{
									$return_data['status']="error";
									$return_data['msg']="Store create failed";
									echo json_encode($return_data);		
									die();
								}	
						}		
				}
			else
				{
					if(!empty(@$post_data['id']))
						{
							$file_name_old = @$post_data['past'];
							$update_data = array(
													'name'=>@$post_data['name'],
													'price'=>@$post_data['coupoun'],
													'image'=>@$file_name_old
									       		);
							$id = en_de_crypt(@$post_data['id'],'d');
							$update_id = $this->custom_model->my_update($update_data,array('id',$id),'store');
							if($update_id)
								{
									$return_data['status']="success";
									$return_data['msg']="Store updated successfully";
									echo json_encode($return_data);
									die();
								}
							else
								{
									$return_data['status']="error";
									$return_data['msg']="Store update failed";
									echo json_encode($return_data);		
									die();
								}	
						}
					else
						{
							$return_data['status']="error";
							$return_data['msg']="Store update failed";
							echo json_encode($return_data);		
							die();
						}	
				}			
			
		}	


	
	public function edit($store_id)
		{
			$store_id_d = en_de_crypt($store_id,'d');
			$store_data = $this->custom_model->my_where('store','*',array('id'=>@$store_id_d));
			$this->mViewData['store_data'] = $store_data;
			$this->render('rewards/create');		
		}
	
	public function deleteSurvey($store_id)
		{
			$store_id_d = en_de_crypt($store_id,'d');
			$this->custom_model->my_delete(array('id'=>@$store_id_d),'store');
			redirect('admin/rewards/list');
		}	
}