<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharmacy Medicine 
 */
class User extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->library('form_builder');
		$this->load->model('custom_model');
		$this->load->model('category_model');
	}

	/* Medicine Create*/

	public function user()
	{
		$post_data=$this->input->post();
		$created_date = date("Y-m-d");
		if(!empty($post_data))
		{

  
            	 if(isset($_GET['id']))
				     {
				         $users = array(
				             'name' =>  $post_data['name'],
				             'phone' =>  $post_data['phone'],
				             'address' =>  $post_data['address'],
				             'city' =>  $post_data['city'],
				             'country' =>  $post_data['country'],
				             'state' =>  $post_data['state'],				    
				             'type' =>  $post_data['type'],				    
				             'created_date'=> $created_date
				             );

				         $ins_id = $this->custom_model->my_update($users,array('id' => $_GET['id']),'users'); 
				         $this->session->set_flashdata('msg_text','User '.$post_data['name'].' updated successfully');          
				     }
			     else
				     {
				         $users = array(
				             'name' =>  $post_data['name'],
				             'phone' =>  $post_data['phone'],
				             'address' =>  $post_data['address'],
				             'city' =>  $post_data['city'],
				             'country' =>  $post_data['country'],
				             'state' =>  $post_data['state'],				    
				             'type' =>  $post_data['type'],				    
				             'created_date'=> $created_date
				             );
				 		$ins_id = $this->custom_model->my_insert($users,'users');
				 		$this->session->set_flashdata('msg_text','User '.$post_data['name'].' added successfully');
				     }
			         
			    if($ins_id)
				 {
				 	$this->session->set_flashdata('msg','success');
				 	redirect('admin/user/user');
				 }
			 	else 
			 	 {
			 	 	$this->session->set_flashdata('msg_text','Error while adding category');
			 	 	$this->session->set_flashdata('msg','error'); 
			 		redirect('admin/user/user');
			 	 }
			 	
			  
		 }
		 if(isset($_GET['id'])){
		     $id  =  $_GET['id'];
		     $users  = $this->custom_model->get_data("select * from users where id='$id'");
		 }
		 else{
			 $users= $this->custom_model->get_data("select * from users where isDelete=0 order by id ASC");
		 }

		$this->mViewData['title'] = "All Users";	
		$this->mViewData['users'] = $users;	 
		$this->render('admin/user/user');
	}

	public function delete_medicine_category($id)
	{
		$response = $this->custom_model->my_update(array('isDelete'=>1,'isActive'=>1),array('id' => $id),'medicine_category_master');
		redirect('admin/medicine/category');
	}

	public function medicinetype()
	{
		$post_data=$this->input->post();
		if(!empty($post_data))
			 {
			 	if(strlen(trim($post_data['type_name'])) == 0)
				{
	    			$this->session->set_flashdata('msg_text','Type is empty !'); 
	    			$this->session->set_flashdata('msg','error');
	    			redirect('admin/medicine/medicinetype','refresh');
				}
			 	if($this->custom_model->check_if_exist(array('type_name'=>$post_data['type_name'],'type_id!='=>$_GET['id']),'medicine_type_master'))
						{
							$this->session->set_flashdata('msg_text','Duplicate entry for Medicine type '.$post_data['type_name'].' already added');
							$this->session->set_flashdata('msg','error'); 
							redirect('admin/medicine/medicinetype');
						}

			 	if(isset($_GET['id']))
				 	{
				 	    $medicine_type=array(
				 			'type_name'	=> $this->input->post('type_name')
				 						);
				 	    $ins_id = $this->custom_model->my_update($medicine_type,array('type_id' => $post_data['id']),'medicine_type_master');
				 	    $this->session->set_flashdata('msg_text','Medicine type updated successfully');
				 	}
			 	else
				 	{
				 	    $medicine_type=array(
				 			'type_name'	=> $this->input->post('type_name'),
				 			'type_id'	=> rand(1000000000,9999999999)
				 						);
					    $ins_id = $this->custom_model->my_insert($medicine_type,'medicine_type_master');
					    $this->session->set_flashdata('msg_text','Medicine type added successfully');
				 	}
			 	
				    if($ins_id){

				    	
				    	$this->session->set_flashdata('msg','success');
			 			redirect('admin/medicine/medicinetype');
			 		}
			 		else{

			 			$this->session->set_flashdata('msg_text','Error adding medicine type');
			 			$this->session->set_flashdata('msg','error'); 
			 			redirect('admin/medicine/medicinetype');
			 		}

			 }
		if(isset($_GET['id']))
		    {
			     $id=$_GET['id'];
			     $medicine_type  = $this->custom_model->get_data("select *from medicine_type_master where type_id='$id'");
			     $this->mPageTitle = 'Edit Medicine Type';
		    }
		else
		    {
		        $medicine_type= $this->custom_model->get_data("select *from medicine_type_master where isDelete=0");
		        $this->mPageTitle = 'Medicine Type';
		    }


		$product_type= $this->custom_model->get_data_array("select distinct medicine_type from medicine_master where isDelete=0");
		$type_array=array();
		foreach ($product_type as $key => $value) {
			$type_array[$key]=$value['medicine_type'];
		}
		$this->mViewData['product_type'] = $type_array;        


		$this->mViewData['medicine_type'] = $medicine_type;	 
		$this->render('admin/medicine/medicinetype');
	}

	public function delete_medicine_type($id)
	{
		$response = $this->custom_model->my_update(array('isDelete'=>1,'isActive'=>1),array('id' => $id),'medicine_type_master');
		redirect('admin/medicine/medicinetype');
	}

	// Medicine Unit Module
	public function medicineunit()
	{
		$post_data=$this->input->post();

		if(!empty($post_data))
			{	
				if(strlen(trim($post_data['unit_name'])) == 0)
				{
	    			$this->session->set_flashdata('msg_text','Unit is empty !'); 
	    			$this->session->set_flashdata('msg','error');
	    			redirect('admin/medicine/medicineunit','refresh');
				}
				if($this->custom_model->check_if_exist(array('unit_name'=>$post_data['unit_name'],'unit_id!='=>$_GET['id']),'medicine_unit_master'))
						{
							$this->session->set_flashdata('msg_text','Duplicate entry for medicine unit  '.$post_data['unit_name'].' already added');
							$this->session->set_flashdata('msg','error'); 
							redirect('admin/medicine/medicineunit');
						}

				if(!empty($post_data['id'])) 
					{
						$medicine_unit_master=array(
    								'unit_name'=>$post_data['unit_name'],
    							);
						$ins_id = $this->custom_model->my_update($medicine_unit_master,array('unit_id' => $post_data['id']),'medicine_unit_master');
						$this->session->set_flashdata('msg_text','Medicine unit '.$post_data['unit_name'].'  updated successfully !');
					}
				else
					{
						$medicine_unit_master=array(
    								'unit_id'=>rand(1000000000,9999999999),
    								'unit_name'=>$post_data['unit_name']
    							);
						$ins_id = $this->custom_model->my_insert($medicine_unit_master,'medicine_unit_master');
						$this->session->set_flashdata('msg_text','Medicine unit '.$post_data['unit_name'].'   added successfully !');
							    
					}
					if($ins_id)
						{
							$this->session->set_flashdata('msg','success');
				 			redirect('admin/medicine/medicineunit');
				 		}
				 	else
				 		{
				 			$this->session->set_flashdata('msg_text','Error adding medicine unit  '.$post_data['unit_name'].' already added');
				 			$this->session->set_flashdata('msg','error');
				 			redirect('admin/medicine/medicineunit');
				 		}
			}
        if(isset($_GET['id']))
		    {
			     $id=$_GET['id'];
			     $medicine_unit_master  = $this->custom_model->get_data("select *from medicine_unit_master where unit_id='$id'");
			     $this->mPageTitle = 'Edit Medicine Unit';
		    }
		else
		    {
		        $medicine_unit_master= $this->custom_model->get_data("select *from medicine_unit_master where isDelete=0");
		        $this->mPageTitle = 'Medicine Unit';
		    }

		$product_unit= $this->custom_model->get_data_array("select distinct unit from medicine_master where isDelete=0");
		$unit_array=array();
		foreach ($product_unit as $key => $value){
			$unit_array[$key]=$value['unit'];
		}
		$this->mViewData['product_unit'] = $unit_array;  


		$this->mViewData['medicine_unit_master'] = $medicine_unit_master; 
		$this->render('admin/medicine/medicineunit');
	}

	public function deleteMedicineUnit($id)
	{
		$response = $this->custom_model->my_update(array('isDelete'=>1,'isActive'=>1),array('id' => $id),'medicine_unit_master');
		redirect('admin/medicine/medicineunit');
	}

   //Medicine Module
    public function medicine()
	{
		$group_id = $this->session->userdata('group_id');
		$user_id  = ($this->session->all_userdata())['user_id'];
		$this->mViewData['user_id'] = $user_id;
		$this->mViewData['group_id'] = $group_id;

		$condition=array();
		if($group_id!=1)
			{
				$condition=array(
							'mm.added_by'=>$user_id,
							'mm.isDelete'=>'0'
								);
			}
		else{
				$condition=array(
							'mm.isDelete'=>'0'
								);
			}

        
		$medicine_master= $this->custom_model->getOnlyMedicineData($condition);
		//echo "<pre>";print_r($condition);print_r($medicine_master);die();
		$this->mViewData['medicine_master'] = $medicine_master;
		$this->render('admin/medicine/medicine');
	}
    
    public function AddMedicine()
	{

		$group_id = $this->session->userdata('group_id');
		$user_id  = ($this->session->all_userdata())['user_id'];

		$this->mViewData['user_id'] = $user_id;
		$this->mViewData['group_id'] = $group_id;

		$simlar_medicine="";
        $composition_sorted="";
        $composition=array();
		$post_data=$this->input->post();
		
		if(!empty($post_data)){
			//echo $post_data['isprescription'];die();

			$seller_id=$post_data['seller_id'];
			
			$composition = explode(',',$post_data['composition']);
            sort($composition);
            $composition_sorted = implode(',',$composition); 

		    			$image = $post_data['images'];
						if(!empty($post_data['medicine_id'])){
						    $medicine_id=$post_data['medicine_id'];
						}
						else{
						    $medicine_id=rand(1000000000,9999999999);
						}
						
						$name_v="";
						
						$configVideo['upload_path'] = './assets/frontend/medicine/'; # check path is correct
                        $configVideo['max_size'] = '102400';
                        $configVideo['allowed_types'] = '*'; # add video extenstion on here
                        $configVideo['overwrite'] = FALSE;
                        $configVideo['remove_spaces'] = TRUE;
                        $video_name = random_string('numeric', 5);
                        $configVideo['file_name'] = $video_name;
                        $this->load->library('upload', $configVideo);
                        $this->upload->initialize($configVideo);
						
						
						if($this->upload->do_upload('product_video'))
							{
							    $meta_data = $this->upload->data();
							    $name_v=$meta_data['file_name'];
							}
						else
    						{
    						    $name_v="";
    						    if(isset($_GET['id'])){
    						    	$name_v=$post_data['old_video'];
    						    }
    						}	
						
						$medicine_master = array(
							'medicine_id'=>$medicine_id,
							'medicine_name'=>$post_data['medicine_name'],
							'generic_name'=>$post_data['generic_name'],
							'box_size'=>$post_data['box_size'],
							'unit'=>$post_data['unit'],
							'medicine_type'=>$post_data['medicine_type'],
							'medicine_category'=>$post_data['medicine_category'],
							'manufacturer'=>$post_data['manufacturer'],
							'medicine_details'=>$post_data['medicine_details'],
							'medicine_Image'=>$image,
							'store_price'=>$post_data['store_price'],
							'sale_price'=>$post_data['sale_price'],
							'price'=>$post_data['price'],
							'purchase_quantity'=>$post_data['purchase_quantity'],
							'composition'=>$composition_sorted,
							'recommended_dosage'=>$post_data['recommended_dosage'],
							'benifites'=>$post_data['benifites'],
							'side_effects'=>$post_data['side_effects'],
							'medicine_video'=>$name_v,
							'link'=>$post_data['link'],
							'strip'=>$post_data['strip'],
							'isPrescriptionOrder'=>$post_data['isprescription'],
							'tax'=>$post_data['tax']
						);
						if(!empty($post_data['id'])){
							$update_medicine_master=array();
							if($group_id==1)
								{
									$update_medicine_master=array_merge($medicine_master,array('updated_at'=>date("Y-m-d H:i:s"),'updated_by'=>$user_id,'added_by'=>$seller_id));
								}
							else
								{
									$update_medicine_master=array_merge($medicine_master,array('updated_at'=>date("Y-m-d H:i:s"),'updated_by'=>$user_id));

								}		
						    $ins_id = $this->custom_model->my_update($update_medicine_master,array('medicine_id' => $post_data['medicine_id']),'medicine_master');
						    $this->session->set_flashdata('msg_text','Medicine  '.$post_data['medicine_name'].'   updated successfully !');
						    
						}
						else{
							$add_medicine_master=array();

							if($group_id==1)
								{
									$add_medicine_master=array_merge($medicine_master,array('added_by'=>$seller_id));
								}
							else
								{
									$add_medicine_master=array_merge($medicine_master,array('added_by'=>$user_id));
								}
							

						    $ins_id = $this->custom_model->my_insert($add_medicine_master,'medicine_master');
						    $this->session->set_flashdata('msg_text','Medicine  '.$post_data['medicine_name'].'   added successfully !');
						}
						// echo $ins_id;
						// echo "<pre>";print_r($post_data);
						// die();
						if($ins_id)
							{
								$this->countUpdateCrone();
							    if(!empty($post_data['add-product']))
								    {
								    	
								    	$this->session->set_flashdata('msg','success');
								        redirect('admin/medicine/medicine');
								    }
							    else
								    {
										$this->session->set_flashdata('msg','error'); 
								        redirect('admin/medicine/addmedicine');
								    }
							 	
							}
						else
							{
								$this->session->set_flashdata('msg_text','Error uploading image');
								$this->session->set_flashdata('msg','image_error'); 
								redirect('admin/medicine/addmedicine?msg=Error Uploading Data');
							}
								
		}
		

		$this->mViewData['vendors'] = $this->custom_model->get_data("SELECT a.id,a.first_name,a.last_name FROM admin_users AS a  WHERE a.active= 1");


		$medicine_type= $this->custom_model->get_data("select *from medicine_type_master where isDelete=0 AND isActive=1");
		$medicine_category= $this->custom_model->get_data("select *from medicine_category_master where isDelete=0 AND isActive=1");
		$medicine_unit_master= $this->custom_model->get_data("select *from medicine_unit_master where isDelete=0 AND isActive=1");
        $manufacturer_master= $this->custom_model->get_data("select *from manufacturer_master where isDelete=0 AND isActive=1");
        $medicines= $this->custom_model->get_data("select *from medicine_master where isDelete=0 AND isActive=1");

		$this->mViewData['medicine_category'] = $medicine_category;
		$this->mViewData['medicine_type'] = $medicine_type;	 
		$this->mViewData['medicine_unit_master'] = $medicine_unit_master;
		$this->mViewData['manufacturer_master'] = $manufacturer_master;
		$this->mViewData['medicines'] = $medicines;
		if(isset($_GET['id']))
			{   
				
			    $id=$_GET['id'];   
			    if($group_id!=1)
    			    {

    			    	$medicine_master= $this->custom_model->getSingleMedicine(array('mm.medicine_id'=>$id,'mm.added_by'=>$user_id));
	    			    if(empty($medicine_master))
		    			    {
					    		redirect('admin/medicine/medicine');
					        }
    			    }
			    else
    			    {
    			    	
    			    	$medicine_master= $this->custom_model->getSingleMedicine(array('mm.medicine_id'=>$id));
    			    	//print_r($medicine_master);
    			    }
    			    //die;

			    $this->mViewData['medicine_master'] = $medicine_master;
			    $this->mPageTitle = 'Edit Medicine';
			}
		else{
			$this->mPageTitle = 'Add Medicine';
		}	

		$this->render('admin/medicine/addmedicine');
	}
        
		
	public function delete_medicine($id)
	{
		$response = $this->custom_model->my_update(array('isDelete'=>1,'isActive'=>1),array('medicine_id' => $id),' medicine_master');
		redirect('admin/medicine/medicine');
	}

	public function viewMedicine()
    {
        $id=$_GET['id'];
        $medicine_master=$this->custom_model->getSingleMedicine(array('mm.medicine_id'=>$id));
        $composition = $medicine_master->composition;
        if(!empty($composition))
        {
    		$condition=array('mm.composition LIKE'=>$composition,'mm.isDelete'=>0);
       		$similar_medicine=$this->custom_model->getMedicines($condition);    	
        }
        $this->mViewData['medicines'] = $similar_medicine;
		$this->mViewData['medicine_master'] = $medicine_master;
		$this->mPageTitle = 'View Medicine';
		$this->render('admin/medicine/viewmedicine');
    }

    public function import_medicine()
    {
		$group_id = $this->session->userdata('group_id');
		$user_id  = ($this->session->all_userdata())['user_id'];

        if (isset($_POST["import"]))
        {
            
            $post_data=$this->input->post();
            $seller_id = $post_data['seller_id'];
            if($this->session->userdata('group_id')!=1){
            	$seller_id=$user_id;
            }
            mkdir('./assets/frontend/medicine/');
			$config['upload_path'] = './assets/frontend/csv/';
			$config['allowed_types'] = '*';
            $config['max_size'] = 2000000;
		    $config['max_width'] = 1500000;
		    $config['max_height'] = 1500000;
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if($this->upload->do_upload('upload_csv_file'))
		     {
		        $data['upload_data'] = $this->upload->data();
				$file_name_old=$data['upload_data']['file_name'];
				$file_name=site_url('assets/frontend/csv/').$file_name_old;
				
				
                
                        $file = fopen($file_name, "r");$i=0;
                        while (($column = fgetcsv($file, 10000, ",")) !== FALSE)
                            { 
                            	if($i == 0){ $i++;continue; }
                                $medicine_id = rand(1000000000,9999999999);
                                $medicine_master = array(
    								'medicine_id'=>$medicine_id,
    								'medicine_name'=>$column[0],
    								'generic_name'=>$column[1],
    								'composition'=>$column[2],
    								'box_size'=>$column[3],
    								'purchase_quantity'=>$column[4],
    								'price'=>$column[5],
    								'sale_price'=>$column[6],
    								'store_price'=>$column[7],
    								'tax'=>$column[8],
    								'benifites'=>$column[9],
    								'medicine_details'=>$column[10],
    								'side_effects'=>$column[11],
    								'recommended_dosage'=>$column[12],
									'unit'=>$post_data['unit'],
    								'medicine_type'=>$post_data['medicine_type'],
    								'medicine_category'=>$post_data['medicine_category'],
    								'manufacturer'=>$post_data['manufacturer'],
    								'added_by'=>$seller_id
    							);
                                $ins_id = $this->custom_model->my_insert($medicine_master,'medicine_master');
                            }
                            
                             $this->session->set_flashdata('msg_text','Medicine imported successfully');

                             $this->session->set_flashdata('msg','success');
                             redirect('admin/medicine/medicine');
		     }
            
        }
        
        $medicine_type= $this->custom_model->get_data("select *from medicine_type_master where isDelete=0 AND isActive=1");
		$medicine_category= $this->custom_model->get_data("select *from medicine_category_master where isDelete=0 AND isActive=1");
		$medicine_unit_master= $this->custom_model->get_data("select *from medicine_unit_master where isDelete=0 AND isActive=1");
        $manufacturer_master= $this->custom_model->get_data("select *from manufacturer_master where isDelete=0 AND isActive=1");

        $this->mViewData['vendors'] = $this->custom_model->get_data("SELECT a.id,a.first_name,a.last_name FROM admin_users AS a  WHERE a.active= 1");
        $this->mPageTitle = 'Import Medicine';
		$this->mViewData['medicine_category'] = $medicine_category;
		$this->mViewData['medicine_type'] = $medicine_type;	 
		$this->mViewData['medicine_unit_master'] = $medicine_unit_master;
		$this->mViewData['manufacturer_master'] = $manufacturer_master;
        $this->render('admin/medicine/importmedicine');
    }

    public function change_status()
    {
    	$id=$_POST['id'];
    	$type=$_POST['type'];
    	$value=$_POST['value'];
        if($type=="unit")
            {
                echo $this->custom_model->my_update(array('isActive'=>$value),array('unit_id' => $id),'medicine_unit_master');
            }
        else if($type=="category")
            {

                echo $this->custom_model->my_update(array('isActive'=>$value),array('medicine_category_id' => $id),'	medicine_category_master');
            }
        else if($type=="type")
            {
                echo $this->custom_model->my_update(array('isActive'=>$value),array('type_id' => $id),'medicine_type_master');
            }
        else if($type=="manufacturer")
            {
                echo $this->custom_model->my_update(array('isActive'=>$value),array('manufacturer_id' => $id),'manufacturer_master');
            }
        else if($type=="medicine")
            {
            	$this->countUpdateCrone();
                echo $this->custom_model->my_update(array('isActive'=>$value),array('medicine_id' => $id),'medicine_master');
            }
    }
            
    public function import()
    {

        $group_id = $this->session->userdata('group_id');
        $user_id  = ($this->session->all_userdata())['user_id'];
    	if (isset($_POST["import"]))
        {
        	$post_data = $this->input->post();
        	$type      = $post_data['type'];

        	mkdir('./assets/frontend/medicine/');
			$config['upload_path'] = './assets/frontend/csv/';
			$config['allowed_types'] = '*';
            $config['max_size'] = 2000000;
		    $config['max_width'] = 1500000;
		    $config['max_height'] = 1500000;
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if($this->upload->do_upload('upload_csv_file'))
			     {
			        $data['upload_data'] = $this->upload->data();
					$file_name_old=$data['upload_data']['file_name'];
					$file_name=site_url('assets/frontend/csv/').$file_name_old;
					$flag="";
					$file = fopen($file_name, "r");$i=0;
                    while (($column = fgetcsv($file, 10000, ",")) !== FALSE)
                        { 
                        	
                        	if($i == 0){ $i++;continue; }
                        	if($type=="unit")
	                        	{
	                        	 	if(!$this->custom_model->check_if_exist(array('unit_name'=>$column[0]),'medicine_unit_master')){
		                            $medicine_unit_master = array(
		        								'unit_id'=>rand(1000000000,9999999999),
		        								'unit_name'=>$column[0]
		        							);

		             		
		                            $ins_id = $this->custom_model->my_insert($medicine_unit_master,'medicine_unit_master');
		                        	}
	                        	}
                        	else if($type=="type")
	                        	{
	                        		if(!$this->custom_model->check_if_exist(array('type_name'=>$column[0]),'medicine_type_master')){
	                        		$medicine_type_master = array(
	        								'type_id'=>rand(1000000000,9999999999),
	        								'type_name'=>$column[0]
	        							);
	                            	$ins_id = $this->custom_model->my_insert($medicine_type_master,'medicine_type_master');
	                            	}
	                        	}
	                        else if($type=="category")
		                        {
		                        	
		                        	if(!$this->custom_model->check_if_exist(array('medicine_category_name'=>$column[0]),'medicine_category_master')){
				                        	$medicine_category = array(
		        								'medicine_category_id'=>rand(1000000000,9999999999),
		        								'medicine_category_name'=>$column[0]
		        							);
		                            		$ins_id = $this->custom_model->my_insert($medicine_category,'medicine_category_master');
                            		   }
		                        }
		                    else if($type=="manufacturer"){

		                    	
		                    	 $manufacturer_master=array(
	        				        'firm_name'=>$column[0],
	        				        'manufacturer_details'=>$column[1],
	        				        'owner_name'=>$column[2],
	        				        'email'=>$column[3],
	        				        'contact'=>$column[4],
	        				        'gstn'=>$column[5],
	        				        'esablishment_date'=>$column[6],
	        				        'address_1'=>$column[7],
	        				        'address_2'=>$column[8],
	        				        'city'=>$column[9],
	        				        'state'=>$column[10],
	        				        'country'=>$column[11],
	        				        'balnce'=>$column[12],
	        				        'manufacturer_id'=>rand(1000000000,9999999999),
	        				        'added_by'=>$user_id
				                );
				    			$ins_id = $this->custom_model->my_insert($manufacturer_master,'manufacturer_master');
		                    }    	
                            
                        }
                        
                    if($type=="unit"){
                        $this->session->set_flashdata('msg_text','Unit imported successfully');
                    	$this->session->set_flashdata('msg','success');
                    	redirect('admin/medicine/medicineunit');
                    }
                    else if($type=="category"){
                        $this->session->set_flashdata('msg_text','Category imported successfully');
                    	$this->session->set_flashdata('msg','success');
                    	//header("Location:admin/medicine/category");
                    	redirect('admin/medicine/category');
                    } 
                    else if($type=="type"){
                        $this->session->set_flashdata('msg_text','Type imported successfully');
                    	$this->session->set_flashdata('msg','success');
                    	redirect('admin/medicine/medicinetype');
                    }  
                    else if($type=="manufacturer"){
                        $this->session->set_flashdata('msg_text','Manufacturer imported successfully');
                        $this->session->set_flashdata('msg','success');
                    	redirect('admin/manufacturer/manufacturer');
                    }
                    
			     }
        }
    }
     
   	public function getMedicineOfCategory()
  	{
   		 $postData = $this->input->post();
    	 $data = $this->custom_model->getMedicineOfCategory($postData);
   		 echo json_encode($data); 
  	}  


    public function insert_manufacturer()
    {
    	$group_id = $this->session->userdata('group_id');
		$user_id  = ($this->session->all_userdata())['user_id'];

    	$post_data=$this->input->post();
    	$manufacturer_master = array(
    				        'firm_name'=>$post_data['firm_name'],
    				        'manufacturer_details'=>$post_data['manufacturer_details'],
    				        'owner_name'=>$post_data['owner_name'],
    				        'email'=>$post_data['email'],
    				        'contact'=>$post_data['contact'],
    				        'gstn'=>$post_data['gstn'],
    				        'esablishment_date'=>$post_data['esablishment_date'],
    				        'address_1'=>$post_data['address_1'],
    				        'address_2'=>$post_data['address_2'],
    				        'city'=>$post_data['city'],
    				        'state'=>$post_data['state'],
    				        'country'=>$post_data['country'],
    				        'balnce'=>$post_data['balnce'],
    				        'manufacturer_id'=>rand(1000000000,9999999999),
    				        'isActive'=>1,
    				        'added_by'=>$user_id
    				            );
    	$ins_id = $this->custom_model->my_insert($manufacturer_master,'manufacturer_master');

    	$manufacturer_master_data= $this->custom_model->get_data("select *from manufacturer_master");
    	echo json_encode($manufacturer_master_data);
    }

	public function RemoveVideo()
	{
		$pid=$_POST['id'];
		$type=$_POST['type'];
		if($type=="pharmacy")
			{
				$data=array('medicine_video'=>'');
				$condition=array('medicine_id'=>$pid);
				echo $this->custom_model->my_update($data,$condition,'medicine_master');
			}
		else
			{
				$data=array('video'=>'');
				$condition=array('product_id'=>$pid);
				echo $this->custom_model->my_update($data,$condition,'health_product');
			}
	}
}
?>