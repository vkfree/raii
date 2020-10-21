<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecommerce extends Admin_Controller {

	public function __construct()
	{
		$this->load->model('default_model');
		$this->load->model('admin/custom_model');
		$this->load->library("Jwt_client");
	    $this->token_id = "s56by73212343289fdsfitdsdne";
	}

	public function healthCategory()
		{

					$data = $this->custom_model->my_where("health_and_wellness_category","*",array('isActive'=>1,'isDelete'=>0),array(),'id','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value){
								$response[$key]['image_url']=base_url('assets/frontend/images/category/').$value['category_image'];
								$response[$key]['category_id']=$value['health_category_id'];
								$response[$key]['category_name']=$value['catgory_name'];

							}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given category') )); die;
						}	
		}



	public function healthProducts()
		{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
			$category 	= @$jsonobj->category;
			if(empty($category))
				{
					echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
				}
			else
				{
					$data = $this->custom_model->my_where("health_product","*",array('category' => $category,'isActive'=>1,'isDelete'=>0),array(),'rating_point','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value)
								{
									$response[$key]['product_id']=$value['product_id'];
									$response[$key]['product_name']=$value['product_name'];
									$response[$key]['generic_name']=$value['generic_name'];
									$response[$key]['composition']=$value['composition'];
									$response[$key]['price']=$value['price'];
									$response[$key]['sale_price']=$value['sale_price'];
									$response[$key]['store_price']=$value['store_price'];
									$response[$key]['tax']=$value['tax'];
									$response[$key]['rating_point']=$value['rating_point'];
									$response[$key]['stock']=$value['purchase_quantity'];

									$images=explode(',',trim($value['images']));
									foreach ($images as $key1 => $value1){
										$response[$key]['image'][$key1]=base_url('assets/admin/usersdata/prescription/').$value1;		
									}
									$category_data=$this->custom_model->my_where('health_and_wellness_category','catgory_name,health_category_id,category_image',array('health_category_id'=>$value['category']));
									$response[$key]['category_name']=$category_data[0]['catgory_name'];

									$type_data=$this->custom_model->my_where('health_type','type_id,type_name',array('type_id'=>$value['type']));
									$response[$key]['type_name']=$type_data[0]['type_name'];

									$unit_data=$this->custom_model->my_where('health_unit','unit_id,unit_name',array('unit_id'=>$value['unit']));
									$response[$key]['unit_name']=$unit_data[0]['unit_name'];

									$provider_data=$this->custom_model->my_where('admin_users','id,first_name,last_name,company_name',array('id'=>$value['added_by']));
									$response[$key]['first_name']=$provider_data[0]['first_name'];
									$response[$key]['last_name']=$provider_data[0]['last_name'];
									$response[$key]['company_name']=$provider_data[0]['company_name'];

									$brand_data=$this->custom_model->my_where('manufacturer_master','manufacturer_id,firm_name',array('manufacturer_id'=>$value['manufacturer']));
									$response[$key]['brand_name']=$brand_data[0]['firm_name'];
								}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given category') )); die;
						}	
				}
		}

	public function healthDetails()
		{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
			$product_id 	= @$jsonobj->product_id;
			if(empty($product_id))
				{
					echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
				}
			else
				{
					$data = $this->custom_model->my_where("health_product","*",array('product_id' => $product_id,'isActive'=>1,'isDelete'=>0),array(),'rating_point','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value)
								{
									$response[$key]['product_id']=$value['product_id'];
									$response[$key]['product_name']=$value['product_name'];
									$response[$key]['generic_name']=$value['generic_name'];
									$response[$key]['composition']=$value['composition'];
									$response[$key]['price']=$value['price'];
									$response[$key]['sale_price']=$value['sale_price'];
									$response[$key]['store_price']=$value['store_price'];
									$response[$key]['tax']=$value['tax'];
									$response[$key]['rating_point']=$value['rating_point'];
									$response[$key]['stock']=$value['purchase_quantity'];


									$response[$key]['box_size']=$value['box_size'];
									$response[$key]['details']=$value['key_information'];
									$response[$key]['benifites']=$value['key_benifites'];
									$response[$key]['side_effects']=$value['side_effects'];
									$response[$key]['recommended_dosage']=$value['recommended_dosage'];
									$response[$key]['prescription']=$value['isPrescription'];
									$response[$key]['video']=$value['video'];


									$images=explode(',',trim($value['images']));
									foreach ($images as $key1 => $value1){
										$response[$key]['image'][$key1]=base_url('assets/admin/usersdata/prescription/').$value1;		
									}
									$category_data=$this->custom_model->my_where('health_and_wellness_category','catgory_name,health_category_id,category_image',array('health_category_id'=>$value['category']));
									$response[$key]['category_name']=$category_data[0]['catgory_name'];

									$type_data=$this->custom_model->my_where('health_type','type_id,type_name',array('type_id'=>$value['type']));
									$response[$key]['type_name']=$type_data[0]['type_name'];

									$unit_data=$this->custom_model->my_where('health_unit','unit_id,unit_name',array('unit_id'=>$value['unit']));
									$response[$key]['unit_name']=$unit_data[0]['unit_name'];

									$provider_data=$this->custom_model->my_where('admin_users','id,first_name,last_name,company_name',array('id'=>$value['added_by']));
									$response[$key]['first_name']=$provider_data[0]['first_name'];
									$response[$key]['last_name']=$provider_data[0]['last_name'];
									$response[$key]['company_name']=$provider_data[0]['company_name'];

									$brand_data=$this->custom_model->my_where('manufacturer_master','manufacturer_id,firm_name',array('manufacturer_id'=>$value['manufacturer']));
									$response[$key]['brand_name']=$brand_data[0]['firm_name'];
								}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given product id') )); die;
						}	
				}
		}


	public function pharmacyCategory()
		{

					$data = $this->custom_model->my_where("medicine_category_master","*",array('isActive'=>1,'isDelete'=>0),array(),'id','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value){
								$response[$key]['image_url']=base_url('assets/frontend/images/category/').$value['category_image'];
								$response[$key]['category_id']=$value['medicine_category_id'];
								$response[$key]['category_name']=$value['medicine_category_name'];

							}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given category') )); die;
						}	
		}


	public function pharmacyProducts()
		{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
			$category 	= @$jsonobj->category;
			if(empty($category))
				{
					echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
				}
			else
				{
					$data = $this->custom_model->my_where("medicine_master","*",array('medicine_category' => $category,'isActive'=>1,'isDelete'=>0),array(),'rating_point','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value)
								{
									$response[$key]['product_id']=$value['medicine_id'];
									$response[$key]['product_name']=$value['medicine_name'];
									$response[$key]['generic_name']=$value['generic_name'];
									$response[$key]['composition']=$value['composition'];
									$response[$key]['price']=$value['price'];
									$response[$key]['sale_price']=$value['sale_price'];
									$response[$key]['store_price']=$value['store_price'];
									$response[$key]['tax']=$value['tax'];
									$response[$key]['rating_point']=$value['rating_point'];
									$response[$key]['stock']=$value['purchase_quantity'];
									$images=explode(',',trim($value['medicine_Image']));
									foreach ($images as $key1 => $value1){
										$response[$key]['image'][$key1]=base_url('assets/admin/usersdata/prescription/').$value1;		
									}

									$category_data=$this->custom_model->my_where('medicine_category_master','medicine_category_name,medicine_category_id,category_image',array('medicine_category_id'=>$value['medicine_category']));
									$response[$key]['category_name']=$category_data[0]['medicine_category_name'];

									$type_data=$this->custom_model->my_where('medicine_type_master','type_id,type_name',array('type_id'=>$value['medicine_type']));
									$response[$key]['type_name']=$type_data[0]['type_name'];

									$unit_data=$this->custom_model->my_where('medicine_unit_master','unit_id,unit_name',array('unit_id'=>$value['unit']));
									$response[$key]['unit_name']=$unit_data[0]['unit_name'];

									$provider_data=$this->custom_model->my_where('admin_users','id,first_name,last_name,company_name',array('id'=>$value['added_by']));
									$response[$key]['first_name']=$provider_data[0]['first_name'];
									$response[$key]['last_name']=$provider_data[0]['last_name'];
									$response[$key]['company_name']=$provider_data[0]['company_name'];

									$brand_data=$this->custom_model->my_where('manufacturer_master','manufacturer_id,firm_name',array('manufacturer_id'=>$value['manufacturer']));
									$response[$key]['brand_name']=$brand_data[0]['firm_name'];
								}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given category') )); die;
						}	
				}
		}



	public function pharmacyDetails()
		{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
			$product_id 	= @$jsonobj->product_id;
			if(empty($product_id))
				{
					echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
				}
			else
				{
					$data = $this->custom_model->my_where("medicine_master","*",array('medicine_id' => $product_id,'isActive'=>1,'isDelete'=>0),array(),'rating_point','DESC');
					if(!empty($data))
						{
							foreach ($data as $key => $value)
								{
									$response[$key]['product_id']=$value['medicine_id'];
									$response[$key]['product_name']=$value['medicine_name'];
									$response[$key]['generic_name']=$value['generic_name'];
									$response[$key]['composition']=$value['composition'];
									$response[$key]['price']=$value['price'];
									$response[$key]['sale_price']=$value['sale_price'];
									$response[$key]['store_price']=$value['store_price'];
									$response[$key]['tax']=$value['tax'];
									$response[$key]['rating_point']=$value['rating_point'];
									$response[$key]['stock']=$value['purchase_quantity'];

									$response[$key]['box_size']=$value['box_size'];
									$response[$key]['details']=$value['medicine_details'];
									$response[$key]['benifites']=$value['benifites'];
									$response[$key]['side_effects']=$value['side_effects'];
									$response[$key]['recommended_dosage']=$value['recommended_dosage'];
									$response[$key]['prescription']=$value['isPrescriptionOrder'];
									$response[$key]['video']=$value['medicine_video'];

									$images=explode(',',trim($value['medicine_Image']));
									foreach ($images as $key1 => $value1){
										$response[$key]['image'][$key1]=base_url('assets/admin/usersdata/prescription/').$value1;		
									}

									$category_data=$this->custom_model->my_where('medicine_category_master','medicine_category_name,medicine_category_id,category_image',array('medicine_category_id'=>$value['medicine_category']));
									$response[$key]['category_name']=$category_data[0]['medicine_category_name'];

									$type_data=$this->custom_model->my_where('medicine_type_master','type_id,type_name',array('type_id'=>$value['medicine_type']));
									$response[$key]['type_name']=$type_data[0]['type_name'];

									$unit_data=$this->custom_model->my_where('medicine_unit_master','unit_id,unit_name',array('unit_id'=>$value['unit']));
									$response[$key]['unit_name']=$unit_data[0]['unit_name'];

									$provider_data=$this->custom_model->my_where('admin_users','id,first_name,last_name,company_name',array('id'=>$value['added_by']));
									$response[$key]['first_name']=$provider_data[0]['first_name'];
									$response[$key]['last_name']=$provider_data[0]['last_name'];
									$response[$key]['company_name']=$provider_data[0]['company_name'];

									$brand_data=$this->custom_model->my_where('manufacturer_master','manufacturer_id,firm_name',array('manufacturer_id'=>$value['manufacturer']));
									$response[$key]['brand_name']=$brand_data[0]['firm_name'];
								}
							echo json_encode(array("status" => true,"data" => $response ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
						}
					else
						{
							echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No product found for given product id') )); die;
						}	
				}				
		}


	public function view_user_cart()
	{
		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$user_id 	= @$jsonobj->user_id;
		$type 	= @$jsonobj->type;

		$user_id_1  = "h_".$user_id;
		$user_id_2  = "p_".$user_id;

		if(empty($user_id))
			{
				echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request Please pass User ID') )); 
				die;
			}
		else if($type=="cart")
			{
				$sql="SELECT *from my_cart where (user_id='$user_id' OR user_id='$user_id_1' OR user_id='$user_id_2' AND meta_key='cart')";
				$user_cart =$this->custom_model->get_data_array($sql);
				
				foreach ($user_cart as $key => $value){
					if($value['store_type']=="pharmacy"){
						$contentp = unserialize($value['content']);

						foreach ($contentp as $key1 => $value){
							$content[$key][$key1]['pid']=$value['product_id'];
							$content[$key][$key1]['qty']=$value['qty'];
							$product = $this->custom_model->my_where('medicine_master','*',array('medicine_id'=>$value['product_id']));
							$manufacturer = $this->custom_model->my_where('manufacturer_master','*',array('manufacturer_id'=>$product[0]['manufacturer']));
							$content[$key][$key1]['product_name']=$product[0]['medicine_name'];
							$content[$key][$key1]['generic_name']=$product[0]['generic_name'];
							$content[$key][$key1]['brand_name']=$manufacturer[0]['firm_name'];
							$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
							$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
							$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
							$content[$key][$key1]['prescription']=$product[0]['isPrescriptionOrder'];
							$content[$key][$key1]['image']=base_url('assets/admin/usersdata/prescription/').explode(',',trim($product[0]['medicine_Image']))[0];
						}
					}
					else if($value['store_type']=="health"){
						$contenth = unserialize($value['content']);						
						foreach ($contenth as $key1 => $value){
							$content[$key][$key1]['pid']=$value['product_id'];
							$content[$key][$key1]['qty']=$value['qty'];
							$product = $this->custom_model->my_where('health_product','*',array('product_id'=>$value['product_id']));
							$manufacturer = $this->custom_model->my_where('manufacturer_master','*',array('manufacturer_id'=>$product[0]['manufacturer']));
							$content[$key][$key1]['product_name']=$product[0]['product_name'];
							$content[$key][$key1]['generic_name']=$product[0]['generic_name'];
							$content[$key][$key1]['brand_name']=$manufacturer[0]['firm_name'];
							$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
							$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
							$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
							$content[$key][$key1]['prescription']=$product[0]['isPrescription'];
							$content[$key][$key1]['image']=base_url('assets/admin/usersdata/prescription/').explode(',',trim($product[0]['images']))[0];
						}
						
					}
					else if($value['store_type']=="equipment"){
						$content_e=unserialize($value['content']);
						
						foreach ($content_e as $key1 => $value){
							$content[$key][$key1]['pid']=$value['pid'];
							$content[$key][$key1]['qty']=$value['qty'];
							$product = $this->custom_model->my_where('product','*',array('id'=>$value['pid']));
							$content[$key][$key1]['product_name']=$product[0]['product_name'];
							$content[$key][$key1]['meta_data']=$value['metadata'];
							$content[$key][$key1]['brand_name']=$product[0]['product_brand'];
							$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
							$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
							$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
							$content[$key][$key1]['prescription']=$product[0]['prescription'];
							$content[$key][$key1]['image']=base_url('assets/admin/products/').$product[0]['product_image'];
						}
						
					}
				}
				//print_r($content);
				if(!empty($content)){
					echo json_encode(array("status" => true,"data" => $content ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
				}
				else{
					echo json_encode(array("status" => false ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Empty Cart') )); die;
				}
				

			}
		else if($type=="wishlist")
			{
				$sql="SELECT *from my_cart where (user_id='$user_id' OR user_id='$user_id_1' OR user_id='$user_id_2' AND meta_key='wish_list')";
				$user_cart =$this->custom_model->get_data_array($sql);
								foreach ($user_cart as $key => $value){
					if($value['store_type']=="pharmacy")
					{
						$contentp = unserialize($value['content']);
						if(!empty($contentp))
							{
								foreach ($contentp as $key1 => $value)
									{
										$content[$key][$key1]['pid']=$value;
										$product = $this->custom_model->my_where('medicine_master','*',array('medicine_id'=>$value));
										$manufacturer = $this->custom_model->my_where('manufacturer_master','*',array('manufacturer_id'=>$product[0]['manufacturer']));
										$content[$key][$key1]['product_name']=$product[0]['medicine_name'];
										$content[$key][$key1]['generic_name']=$product[0]['generic_name'];
										$content[$key][$key1]['brand_name']=$manufacturer[0]['firm_name'];
										$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
										$content[$key][$key1]['price']=$product[0]['price'];
										$content[$key][$key1]['store_price']=$product[0]['store_price'];
										$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
										$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
										$content[$key][$key1]['prescription']=$product[0]['isPrescriptionOrder'];
										$content[$key][$key1]['image']=base_url('assets/admin/usersdata/prescription/').explode(',',trim($product[0]['medicine_Image']))[0];
									}
							}	
					}
					else if($value['store_type']=="health")
					{
						$contenth = unserialize($value['content']);		
						if(!empty($contenth))
							{				
								foreach ($contenth as $key1 => $value){
									$content[$key][$key1]['pid']=$value;
									$product = $this->custom_model->my_where('health_product','*',array('product_id'=>$value));
									$manufacturer = $this->custom_model->my_where('manufacturer_master','*',array('manufacturer_id'=>$product[0]['manufacturer']));
									$content[$key][$key1]['product_name']=$product[0]['product_name'];
									$content[$key][$key1]['generic_name']=$product[0]['generic_name'];
									$content[$key][$key1]['brand_name']=$manufacturer[0]['firm_name'];
									$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
									$content[$key][$key1]['price']=$product[0]['price'];
									$content[$key][$key1]['store_price']=$product[0]['store_price'];
									$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
									$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
									$content[$key][$key1]['prescription']=$product[0]['isPrescription'];
									$content[$key][$key1]['image']=base_url('assets/admin/usersdata/prescription/').explode(',',trim($product[0]['images']))[0];
								}
							}
						
					}
					else
					{
						$content_e=unserialize($value['content']);
						if(!empty($content_e))
							{
								foreach ($content_e as $key1 => $value)
									{
										$content[$key][$key1]['pid']=$value;
										$product = $this->custom_model->my_where('product','*',array('id'=>$value));
										$content[$key][$key1]['product_name']=$product[0]['product_name'];
										$content[$key][$key1]['meta_data']=$value['metadata'];
										$content[$key][$key1]['brand_name']=$product[0]['product_brand'];
										$content[$key][$key1]['sale_price']=$product[0]['sale_price'];
										$content[$key][$key1]['price']=$product[0]['price'];
										$content[$key][$key1]['store_price']=$product[0]['storeprice'];
										$content[$key][$key1]['rating_point']=$product[0]['rating_point'];
										$content[$key][$key1]['rating_users']=$product[0]['rating_users'];
										$content[$key][$key1]['prescription']=$product[0]['prescription'];
										$content[$key][$key1]['image']=base_url('assets/admin/products/').$product[0]['product_image'];
									}
							}
					}
				}			
			}	
			if(!empty($content)){
					echo json_encode(array("status" => true,"data" => $content ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
				}
				else{
					echo json_encode(array("status" => false ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Empty Cart') )); die;
				}
	}





	/**
	 * product details, vendor details and sub category
	 */
	public function card_count()
	{
		// $json 		= '{"category":"61" }';
		
        $json = file_get_contents('php://input');
        $jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'card_count':$ws;
		
	    $user_id = $this->validate_token($language ,$ws);

	    // print_r($user_id);
		// $user_id = 627;

		if ($user_id)
		{
			$cart = $this->custom_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));

			if(!empty($cart)) $content = unserialize($cart[0]['content']);
	   	 	$cart_qty = '';
	   	 	if ($cart[0]['content'])
	   	 	{
	   	 		foreach ($content as $unkey => $unvalue)
				{
					$cart_qty += $unvalue['qty'];
				}
				
	   	 	}
	   	 	
			echo json_encode(array("status" => true, "ws" => $ws,"data" => $cart_qty ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
		}
		else
		{
			echo json_encode(array("status" => true, "ws" => $ws ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Empty cart') )); die;
		}
		
   	 	


		// echo "<pre>";
        // print_r($cart_qty);
        // print_r($content);
        // die;
	}
	
	public function category_wise_product_list()
	{
		$json = file_get_contents('php://input');
		
		// $json 		= '{"category":"61" }';
		
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$string 	= @$jsonobj->string;
		
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'category_wise_product_list':$ws;
		$category 	= @$jsonobj->category;
	    // $user_id = 1;
		$user_id = $this->validate_token($language ,$ws);

   	 	if (!empty($category) && !empty($user_id))
   	 	{
   	 		if (empty($string))
   	 		{
   	 			if ($language != 'en')
   	 			{
   	 				$data =  $this->custom_model->my_where('product_trans','id,product_name,category,description,price,stock_status,product_image,image_gallery,status,insurance',array('category' => $category));
   	 			}
   	 			else{
   	 				$data =  $this->custom_model->my_where('product','id,product_name,category,description,price,stock_status,product_image,image_gallery,status,insurance',array('category' => $category));
   	 			}
   	 		}
   	 		else
   	 		{
   	 			if ($language != 'en')
   	 			{
   	 				$data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,image_gallery,status,insurance FROM product_trans WHERE product_name LIKE '%$string%' AND `category` = $category ");
   	 			}
   	 			else{
   	 				$data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,image_gallery,status,insurance FROM product WHERE product_name LIKE '%$string%' AND `category` = $category ");
   	 			}
   	 		}

   	 		// echo "<pre>";
   	 		// print_r($data);
   	 		// die;

   	 		if ($data)
   	 		{
   	 			foreach ($data as $key => $value)
   	 			{
   	 			    $product_id = $value['id'];
   	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);

					$data[$key]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
					
   	 				$data[$key]['product_image'] = $this->get_product_path($value['product_image']);
   	 			}
   	 			echo json_encode(array("status" => true,"data" => $data ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
			}
   	 		else
   	 		{
   	 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
   	 		}
 		}
 		else
 		{
 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
	}

	/**
	 * product detail
	 */
	public function product_detail()
	{
		$json = file_get_contents('php://input');
		//$json 		= '{"product_id":"58"}';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$language = empty($language)? 'en':$language;
		
		$guest 		= @$jsonobj->guest;

		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'product_detail':$ws;
		// $user_id = 627;
		//$product_id = 58;
		$product_id 	= @$jsonobj->product_id;
		$my_wish = array();

   	 	$response = array();
        
        if(empty($guest))
        {
            $user_id = $this->validate_token($language,$ws);    
        }
        
   	 	if (!empty($product_id))
   	 	{
   	 		$data = $this->custom_model->my_where("product","*",array('id' => $product_id) );

   	 		if (!empty($data))
   	 		{
   	 			/*echo "<pre>";
   	 			print_r($data);
   	 			die;*/
				$review = $this->custom_model->my_where( "user_rating","rating,comment,uid",array('uid' => @$user_id, 'pid' => $product_id ) );
				$data[0]['review'] = !empty($review)? $review[0] : new stdClass();
				$user_review = $this->custom_model->my_where("user_rating","rating,comment,uid",array('pid' => $product_id, 'status' => 'active') );
				if (!empty($user_review))
				{
					$avg = 0;
					foreach ($user_review as $key => $value)
					{
						$udata = $this->custom_model->my_where("users","first_name",array("id" => $value['uid']),array(),"","","","", array(), "",array(),false  );
						if(empty($udata)) continue;
						$user_review[$key]['user_name'] = $udata[0]['first_name'];
						$avg += $value['rating'];
					}
					$data[0]['rating1'] = round($avg/count($user_review));
					$data[0]['user_count'] = count($user_review);
					$data[0]['user_review'] = $user_review;
				}
				else{
					$data[0]['rating1'] = '0';
					$data[0]['user_count'] = '0';
					$data[0]['user_review'] = array();
				}

				//attributes
				$attribute = $this->custom_model->get_data("SELECT a.*, c.name AS aname, b.item_name AS item_name,b.attribute_code AS attribute_code, c.id AS aid  FROM product_attribute AS a LEFT JOIN attribute_item AS b ON a.item_id = b.id LEFT JOIN attribute AS c ON b.a_id = c.id WHERE a.p_id = ".$product_id);

				$attribute_item = [];
				$attribute = json_decode( json_encode($attribute), true);
				foreach ($attribute as $key => $avalue)
				{
					$aid = $avalue['aid'];
					$attribute_item[$aid]['name'] = $avalue['aname'];
					$attribute_item[$aid]['sub'][] = $avalue;
				}
				$data[0]['attribute'] = !empty($attribute_item)? $attribute_item: new stdClass();
				
   	 			$data = $data[0];
   	 			// $data['product_image'] = array($this->get_product_path($data['product_image']));
   	 			$data['product_video'] = array($this->get_product_path($data['product_video']));
   	 			$image_gallery = $data['image_gallery'];
                $aimage_gallery = explode(",", $image_gallery); 
                $aimage_gallery = array_filter($aimage_gallery);
                $data['gallery_image'] = $aimage_gallery;
   	 			if (!empty($user_id))
   	 			{
	   	 			$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);

					$response['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
   	 			}

	   	 		if ($language != 'en')
	   	 		{
	   	 			$res = $this->custom_model->my_where("product_trans","*",array('id' => $data['id']) );
	   	 			if (!empty($res))
	   	 			{
		   	 			$data['product_name'] = $res[0]['product_name'];
		   	 			$data['description'] = $res[0]['description'];
		   	 			$data['product_brand'] = $res[0]['product_brand'];
	   	 			}
	   	 		}
	   	 		
   	 			foreach ($data['gallery_image'] as $key => $value)
   	 			{
   	 				$data['gallery_image'][($key + 1)] = $this->get_product_path($value);
   	 			}
   	 			$data['gallery_image'][0] = $this->get_product_path($data['product_image']);
   	 			
   	 			// Related products
				$seller_id = $data['seller_id'];
				$category = $data['category'];

				/*$rd_data = $this->custom_model->my_where("product","*",array("status" => '1' ,'seller_id' => $seller_id, "category" => $category, "id !=" => $product_id ) );*/

				$rd_data = $this->custom_model->my_where("product","*",array("status" => '1' , "category" => $category, "id !=" => $product_id ) );				

				foreach ($rd_data as $rkey => $rdvalue)
				{
					if($language != "en")
					{
						$rd_data[$rkey] = $this->default_model->get_arabic_product($rdvalue);
					}
					$rd_data[$rkey]['product_image'] = $this->get_product_path($rd_data[$rkey]['product_image']);

   	 				if (!empty($my_wish))
   	 				{
   	 					$rd_data[$rkey]['is_in_wish_list'] = in_array($rdvalue['id'], $my_wish)? true:false;
   	 				}
   	 				else{
   	 					$rd_data[$rkey]['is_in_wish_list'] = false;
   	 				}
					
				}
   	 			unset($data['image_gallery']);
   	 			unset($data['product_image']);
	 			
	 			$response['status'] = true;
				$response['data'] = $data;
				$response['ws'] = $ws;
				$response['related_pr'] = $rd_data;
				if ($language == 'ar')
				{
					$response['message'] = 'نجاح';
				}
				else{
					$response['message'] = 'Success';
				}
   	 			echo json_encode( $response );die;
			}
   	 	}

		if ($language == 'ar')
		{
			$message = 'طلب غير صالح';
		}
		else{
			$message = 'Invalid request';
		}
   	 	echo json_encode( array("status" => false, "ws" => $ws,"message" => $message) );die;
   	}

	/**
	 * add product to cart 
	 */
	public function add_to_cart()
	{
		$json = file_get_contents('php://input');
		//$json 		= '{"product_id":"155","quantity":"5","color":"black","size":"15","type":"add"}';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		
		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'add_to_cart':$ws;
		$language = empty($language)? 'en':$language;
		//$user_id = 642;
		$user_id = $this->check_user_login($language,$ws);
		$pid 	= @$jsonobj->product_id;
		$delete_product 	= @$jsonobj->delete_product;

		$quantity 	= @$jsonobj->quantity;
		$color = @$jsonobj->color;
		$size = @$jsonobj->size;
		$weight = @$jsonobj->weight;
	

		$type 	= @$jsonobj->type;
		$type = empty($type)? 'add':$type;
		$cart_qty = 0;
        $metadata = array();
        
        $user_id = 28;

		if(!empty($pid)&&!empty($user_id)&&!empty($quantity))
				{

		            if(!empty($color)) $metadata['color'] = $color;
		            if(!empty($size))  $metadata['size'] = $size;
		            if(!empty($weight)) $metadata['weight'] = $weight;
		            
					$this->load->library('user_account');
					
					if ($type == 'add')
					{
						$pro_details = $this->custom_model->my_where('product','*', ['id' => $pid]);
						if ($pro_details)
						{
							if ($pro_details[0]['stock_status'] == 'notinstock') 
							{
								echo json_encode( array("status" => false,"ws" => $ws , "messasge" => "Product is not in stock " ) );die;
							}
						}

						$response = $this->user_account->add_remove_cart($pid,$user_id,'add',$quantity, $metadata);

						// echo "<pre>";
						// print_r($user_id);
						// die;

						if($response)
						{
							if (isset($response['cart_qty']))
							{
								$cart_qty = $response['cart_qty'];
								unset($response['cart_qty']);
							}
							echo json_encode( array("status" => true , "ws" => $ws,"cart" => $response,"count" => $cart_qty) );die;
						}
						else
						{
						    $msg = ($language == 'ar'? 'لا يوجد رصيد كاف لإضافة كمية ...':'Not enough stock to add quantity...');
							echo json_encode( array("status" => false, "ws" => $ws ,"message" => $msg) );die;
						}				
					}
					elseif ($type == 'remove' || $type == 'remove_one_by_one')
					{
					    if(!empty($metadata)){
		    				if(!empty($metadata)){
		    					foreach ($metadata as $pkey => $pvalue) {
		    						$string = str_replace(' ', '', $pvalue);

		    						$pid .= 'm'.$string;
		    					}
		    				}
		    			}
		    			
		    			// echo "<pre>";
		    			// print_r($pid);
		    			// die;

		    			
		    			if($type == 'remove')
		    			{
		    			    $response = $this->user_account->add_remove_cart($pid,$user_id,'remove',$quantity, $metadata);
		    			}
		    			else{
		    			    $response = $this->user_account->add_remove_cart($pid,$user_id,'remove_one_by_one',$quantity, $metadata);    
		    			}
						

						if ($response != '-1')
						{
							if (isset($response['cart_qty']))
							{
								$cart_qty = $response['cart_qty'];
								unset($response['cart_qty']);
							}

							if(empty($response))
							{
								$response = new stdClass();
								$count = '0';
							}

							echo json_encode( array("status" => true , "ws" => $ws , "cart" => $response,"count" => $cart_qty) );die;
						}

					}

				}
				//echo "$pid - $user_id - $quantity";
				if ($language == 'ar')
					{
						$message = 'طلب غير صالح';
					}
				else
					{
						$message = 'Invalid request';
					}
				echo json_encode( array("status" => false,"ws" => $ws , "message" => $message));die;
				die;
   	}



   	public function add_to_cart_pharmacy()
	   	{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
				
			$pid 	= @$jsonobj->product_id;
			$type 	= @$jsonobj->type;
			$quantity = $qty	= @$jsonobj->quantity;
			$metadata = array();
			$uid=$user_id = @$jsonobj->user_id;
		    $append='p'.$pid;
		    if(empty($pid)){
		    	$message = 'Product Id Cannot Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($quantity)){
		    	$message = 'Qunatity Cannot Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($uid)){
		    	$message = 'User Id Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($type)){
		    	$message = 'Please Provide Type add Or remove';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    $ck_sk = $this->custom_model->my_where('medicine_master','*',array('medicine_id' => $pid));
		    if($type=="remove")
			    {
			    	if(empty($ck_sk))
			    	{
			    		$message = 'Product Not Found To Remove From Cart ';
						echo json_encode( array("status" => false , "message" => $message));die;
			    	}
			    	else
			    	{
			    		$is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => 'p_'.$uid,'meta_key' => 'cart','store_type'=>'pharmacy'));
			    		if(empty($is_data)){
			    			$message = 'Product Not Found In Cart ';
							echo json_encode( array("status" => false , "message" => $message));die;
			    		}
			    		$id=$is_data[0]['id'];
					    $db_content = $is_data[0]['content'];
					    $uncontent = unserialize($db_content);
			    		if(array_key_exists($append,$uncontent)){
			    			$uncontent[$append]['qty'] = $uncontent[$append]['qty']-$quantity;
			    			if($uncontent[$append]['qty']==0){
			    				unset($uncontent[$append]);
			    			}
			    			$update=$this->custom_model->my_update(array('meta_key' =>'cart','content' =>serialize($uncontent),'store_type'=>'pharmacy'),array('id'=>$id),'my_cart');
			    			if($update){
			    				$message = 'Product Removed From Cart ';
								echo json_encode( array("status" => true , "message" => $message));die;
			    			}
			    			else{
			    				$message = 'Something Went Wrong ';
								echo json_encode( array("status" => false , "message" => $message));die;
			    			}
			    		}
			    		else{
			    			$message = 'Product Not Found in Cart';
							echo json_encode( array("status" => false , "message" => $message));die;
			    		}
			    	}
			    }



	        if($ck_sk)
		        {
		        	if($ck_sk[0]['purchase_quantity']< $qty)
			        	{
			        			$message = 'Quantity not available';
								echo json_encode( array("status" => false , "message" => $message));die;
			        	}
		        	else
			        	{
			        		if(!empty($uid))              
				        		{
									$is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => 'p_'.$uid,'meta_key' => 'cart','store_type'=>'pharmacy'));
				        			if($is_data)
					        			{
					        					$id=$is_data[0]['id'];
					        					$db_content = $is_data[0]['content'];
					        					$uncontent = unserialize($db_content);								
					        					if(array_key_exists($append,$uncontent)){
					        						$new_qty=$uncontent[$append]['qty']+$qty;
					        						$uncontent[$append]['qty'] = $new_qty;
					        						$update=$this->custom_model->my_update(array('content' =>serialize($uncontent)),array('id'=>$id),'my_cart');

					        						$message = 'Product Quantity Updated To Cart Successfully';
													echo json_encode( array("status" => true , "message" => $message));die;		
												}
												$updated_content[$append] = array('product_id'=>$pid,'qty'=>$qty);
												$new_content=array_merge($uncontent,$updated_content);

												$update=$this->custom_model->my_update(array('meta_key' =>'cart','content' =>serialize($new_content),'store_type'=>'pharmacy'),array('id'=>$id),'my_cart');
												
												$message = 'Product Added To Cart Successfully';
												echo json_encode( array("status" => true , "message" => $message));die;
				        				}
				        			else
					        			{
					        					$content = array('product_id'=>$pid,'qty'=>$qty);
					        					$content_new[$append]=$content;

					        					$data=array(
							        						'user_id'=>'p_'.$uid,
							        						'meta_key'=>'cart',
							        						'content'=>serialize($content_new),
							        						'store_type'=>'pharmacy'
					        								);
												$id=$this->custom_model->my_insert($data,'my_cart');
												if($id)
													{
														$message = 'Product Added To Cart Successfully';
														echo json_encode( array("status" => true , "message" => $message));die;
													}
												else
													{
														$message = 'Something Went Wrong';
														echo json_encode( array("status" => false , "message" => $message));die;
													}	
					        			}

									}
				        		else           
					        		{	
					        			$uncontent=array();
					        			$uncontent = unserialize($this->session->userdata('guest_content_p'));
					        			if(!empty($uncontent))
						        			{
						        				if(array_key_exists($append,$uncontent)){
						        					$new_qty=$uncontent[$append]['qty']+$qty;
					        						$uncontent[$append]['qty']=$new_qty;
					        						$this->session->set_userdata('guest_content_p',serialize($uncontent));
					        						$message = 'Product Quantity Updated To Cart Successfully';
													echo json_encode( array("status" => true , "message" => $message));die;		
												}
												$new_content[$append]=array('product_id'=>$pid,'qty'=>$qty);
												$upcontent=array_merge($new_content,$uncontent);
												$this->session->set_userdata('guest_content_p',serialize($upcontent));

						        			}
					        			else
						        			{
						        				$content[$append]=array('product_id'=>$pid,'qty'=>$qty);
						        				$this->session->set_userdata('guest_content_p',serialize($content));
						        			}

					        			$qty = $qty+$this->session->userdata('cart_count');
										$this->session->set_userdata('cart_count',$qty);
										$message = 'Product Added To Cart Successfully';
										echo json_encode( array("status" => true , "message" => $message));die;
					        		}	
							}
		        	}
		        else
		        {
		        	$message = 'Product Not Found To Add Cart ';
					echo json_encode( array("status" => false , "message" => $message));die;
		        }	
					

	   	}



   	public function add_to_cart_health()
	   	{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);
			$pid 	= @$jsonobj->product_id;
			$type 	= @$jsonobj->type;
			$quantity 	=$qty= @$jsonobj->quantity;
			$metadata = array();
		    $uid=$user_id =  @$jsonobj->user_id;
		    $append='h'.$pid;

		    if(empty($pid)){
		    	$message = 'Product Id Cannot Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($quantity)){
		    	$message = 'Qunatity Cannot Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($uid)){
		    	$message = 'User Id Be Blank';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    else if(empty($type)){
		    	$message = 'Please Provide Type add Or remove';
				echo json_encode( array("status" => false , "message" => $message));die;
		    }
		    $ck_sk = $this->custom_model->my_where('health_product','*',array('product_id' => $pid));
		    if($type=="remove")
			    {
			    	if(empty($ck_sk))
			    	{
			    		$message = 'Product Not Found To Remove From Cart ';
						echo json_encode( array("status" => false , "message" => $message));die;
			    	}
			    	else
			    	{
			    		$is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => 'h_'.$uid,'meta_key' => 'cart','store_type'=>'health'));
			    		if(empty($is_data)){
			    			$message = 'Product Not Found In Cart ';
							echo json_encode( array("status" => false , "message" => $message));die;
			    		}
			    		$id=$is_data[0]['id'];
					    $db_content = $is_data[0]['content'];
					    $uncontent = unserialize($db_content);
			    		if(array_key_exists($append,$uncontent)){
			    			$uncontent[$append]['qty'] = $uncontent[$append]['qty']-$quantity;
			    			if($uncontent[$append]['qty']==0){
			    				unset($uncontent[$append]);
			    			}
			    			$update=$this->custom_model->my_update(array('meta_key' =>'cart','content' =>serialize($uncontent),'store_type'=>'health'),array('id'=>$id),'my_cart');
			    			if($update){
			    				$message = 'Product Removed From Cart ';
								echo json_encode( array("status" => true , "message" => $message));die;
			    			}
			    			else{
			    				$message = 'Something Went Wrong ';
								echo json_encode( array("status" => false , "message" => $message));die;
			    			}
			    		}
			    		else{
			    			$message = 'Product Not Found in Cart';
							echo json_encode( array("status" => false , "message" => $message));die;
			    		}
			    	}
			    }
		    	
	        	if($ck_sk)
		        	{

		        		if($ck_sk[0]['purchase_quantity']< $qty){
		        			$message = 'Quantity not available';
							echo json_encode( array("status" => false , "message" => $message));die;
		        		}
		        		else
		        		{
		        			
		        			$new_content=array();
		        			if(!empty($uid))              
			        			{
			        				$is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => 'h_'.$uid,'meta_key' => 'cart','store_type'=>'health'));
			        				
			        				if($is_data)
				        				{
				        					$id=$is_data[0]['id'];
				        					$db_content = $is_data[0]['content'];
				        					$uncontent = unserialize($db_content);								
				        					if(array_key_exists($append,$uncontent)){
				        						$new_qty=$uncontent[$append]['qty']+$qty;
				        						$uncontent[$append]['qty'] = $new_qty;
				        						$this->session->set_userdata('cart_count_health',$new_qty);
				        						$update=$this->custom_model->my_update(array('content' =>serialize($uncontent)),array('id'=>$id),'my_cart');
				        						$message = 'Product Quantity Updated To Cart Successfully';
												echo json_encode( array("status" => true , "message" => $message));die;				
											}
											$updated_content[$append] = array('product_id'=>$pid,'qty'=>$qty);
											$new_content=array_merge($uncontent,$updated_content);

											$update=$this->custom_model->my_update(array('meta_key' =>'cart','content' =>serialize($new_content),'store_type'=>'health'),array('id'=>$id),'my_cart');
											$message = 'Product Added To Cart Successfully';
											echo json_encode( array("status" => true , "message" => $message));die;	
			        					}
			        				else
				        				{
				        					$content = array('product_id'=>$pid,'qty'=>$qty);
				        					$content_new[$append]=$content;

				        					$data=array(
						        						'user_id'=>'h_'.$uid,
						        						'meta_key'=>'cart',
						        						'content'=>serialize($content_new),
						        						'store_type'=>'health'
				        								);
											$id=$this->custom_model->my_insert($data,'my_cart');
											if($id)
												{
													$message = 'Product Added To Cart Successfully';
													echo json_encode( array("status" => true , "message" => $message));die;	
												}
											else
												{
													$message = 'Product Added To Cart Successfully';
													echo json_encode( array("status" => true , "message" => $message));die;
												}	
				        				}
			        			}
			        		else
				        		{
				        			$upcontent=array();
				        			$uncontent = unserialize($this->session->userdata('guest_content'));
				        			if(!empty($uncontent))
					        			{
					        				if(array_key_exists($append,$uncontent)){
					        					$new_qty=$uncontent[$append]['qty']+$qty;
				        						$uncontent[$append]['qty']=$new_qty;
				        						$this->session->set_userdata('guest_content',serialize($uncontent));
				        						$message = 'Product Quantity Updated Cart Successfully';
												echo json_encode( array("status" => true , "message" => $message));die;				
											}
											$new_content[$append]=array('product_id'=>$pid,'qty'=>$qty);
											$upcontent=array_merge($new_content,$uncontent);
											$this->session->set_userdata('guest_content',serialize($upcontent));

					        			}
				        			else
					        			{
					        				$content[$append]=array('product_id'=>$pid,'qty'=>$qty);
					        				$this->session->set_userdata('guest_content',serialize($content));
					        			}


				        			$qty = $qty+$this->session->userdata('cart_count');
									$this->session->set_userdata('cart_count',$qty);
									$message = 'Product Added To Cart Successfully';
									echo json_encode( array("status" => true , "message" => $message));die;	
				        		}
		        		}
		        	}
		        	else
			        {
			        	$message = 'Product Not Found To Add Cart ';
						echo json_encode( array("status" => false , "message" => $message));die;
			        }	
			
	   	}







	/**
	 * View products in cart
	*/
	public function view_cart()
	{
		$total_saved = $totaltax = $totaldel = 0;
		$json = file_get_contents('php://input');
		// $user_id = 627;
		$jsonobj 	= json_decode($json);

		$language 	= @$jsonobj->language;
		$language = empty($language)? 'en':$language;

    	$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'view_cart':$ws;
		
        $user_id = $this->check_user_login($language,$ws);
    
   	 	$response = $data = $data1 = $error = array();
   	 	$cart_qty = 0;

		$this->load->library('user_account');

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false ,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
   	 	}

        //Remove last order which is draft and add product to cart
        $this->load->library('place_order');
        $orderids = $this->custom_model->my_where('order_master','*', ['customer_id' => $user_id, 'payment_status' => 'Draft']);
        if (!empty($orderids))
        {
            foreach ($orderids as $key => $value)
            {
                $oid = $value['order_master_id'];
                $this->place_order->remove_order($oid, 'order_master_id', $user_id);
            }
        }
        
   	 	$cart = $this->custom_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));

   	 	if(!empty($cart)) $content = unserialize($cart[0]['content']);

   	 	// echo "<pre>";
   	 	// print_r($content);die;

   	 	$adel = array();
   	 	if (!empty($content)) {
			$default_tax = $this->custom_model->get_admin_option("default_tax");		
			foreach ($content as $key => $value) {
				$res = $this->this_product_data($value['pid'],$language);

				if ($res)
				{
					$append = $value['pid'];
					
					$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
					// echo "<pre>";
					if (!empty($res) && $res['curr']['stock_status'] != 'notinstock')
					{
						$data1[$key]['is_in_wish_list'] = !empty($my_wish) && in_array($append, $my_wish)? 1:0;
					}					
					
					if(!empty($value['metadata'])){
                        foreach ($value['metadata'] as $pkey => $pvalue) {
    						$append .= 'm'.$pvalue;
    					}
					}
					if ($res['curr']['stock'] < $value['qty'] && $res['curr']['stock'] != 0)
					{
					    $this->user_account->add_remove_cart($value['pid'],$user_id,'add',$res['curr']['stock']);

						$error[] = 'Quantity of '.$res['curr']['product_name'].' is reduced.';
						$value['qty'] = $res['curr']['stock'];
						
					}
					elseif ($res['curr']['stock_status'] == 'notinstock' || $res['curr']['stock'] == 0)
					{
						$this->wish_list_actions($user_id, $value['pid'], 'add');
						$this->user_account->add_remove_cart($append,$user_id,'remove');
						$error[] = $res['curr']['product_name'].lang('product_moved_wishlist');
						continue;
					}

                    $cart_qty += $value['qty'];
					$shipping = $res['curr1']['shipping'];
					$vendor_name = $res['curr1']['vendor_name'];
					$adel[$vendor_name] = $shipping;
					$tax = $res['curr']['tax'];
                    if(!empty($default_tax)){
                        if(empty($tax)){
                            $tax = $default_tax;
                        }
                    }
                    $price = $res['curr']['price'] * $value['qty'];
                    $sale_price = $res['curr']['sale_price'] * $value['qty'];
                    if(empty($res['curr']['sale_price'])) $sale_price = $price;
                    $total_saved += ($price - $sale_price);
					if(!empty($tax)) $totaltax = $totaltax + ( $sale_price * $tax ) / 100;

					$arr = array_merge($res['curr'], $res['curr1'], array('uqty' => $value['qty']));

					$data['product'][] = $arr;
					$data1[$key]['p'] = $res['curr'];
					$data1[$key]['partner_name'] = $res['curr1']['vendor_name'];
					$data1[$key]['uqty'] = $value['qty'];
					$data1[$key]['metadata'] = !empty($value['metadata'])? $value['metadata']: new stdClass();
				}
			}

			if(!empty($adel)){
				foreach ($adel as $akey => $avalue) {
					$totaldel = $totaldel + $avalue;
				}
			}

			$default_replacement_policy = $this->custom_model->get_admin_option("default_replacement_policy");
			$default_transaction_cost = $this->custom_model->get_admin_option("default_transaction_cost");
			$data["default_tax"] = $default_tax;
			$data["default_transaction_cost"] = $default_transaction_cost;
			$data['default_replacement_policy'] = $default_replacement_policy;

			foreach ($data1 as $key => $value)
			{
				// echo "<pre>";
				// print_r($value);
				$response[] = $value;
				// $response[$value['v']['vendor_name']][] = $value;
			}

			// $response = array_values($response);
			// if(empty($error)) $error = new stdClass();

			// echo "<pre>";
			// print_r($response);
			// die;

			echo json_encode( array("status" => true ,"ws" => $ws ,/*"data" => $data,*/"response" => $response,"total_tax" => $totaltax, "total_shipping" => $totaldel, "total_saved" => $total_saved, "count" => $cart_qty,/* "removed_product" => $error*/) );die;
		}
		else{
			$data = new stdClass();

			echo json_encode( array("status" => false ,"message" => "Empty cart " ,"ws" => $ws ,"data" => $data,"response" => $response, "removed_product" => $error) );die;
		}

		echo json_encode( array("status" => false ,"ws" => $ws,"message" => ($language == 'ar'? 'طلب غير صالح':'No Products') ) );die;
   	}

	/**
	 * add product to wish list 
	 */
	public function add_to_wish_list()
	{
		$json = file_get_contents('php://input');
		//$json 		= '{"product_id":"6","type":"remove"}';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'add_to_wish_list':$ws;

		//$user_id = 636;
		$user_id = $this->check_user_login($language,$ws);

		$pid 	= @$jsonobj->product_id;
		$type 	= @$jsonobj->type;
		$type = empty($type)? 'add':$type;
		$my_wish = array();

		if (!empty($user_id))
		{
			$my_wish = $this->wish_list_actions($user_id, $pid, $type);
			echo json_encode( array("status" => true, "message" => ($language == 'ar'? 'طلب':'Successfully') ,  "ws" => $ws , "wish_list" => $my_wish) );die;
		}
		else
		{
			echo json_encode( array("status" => false ,  "ws" => $ws  , "message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}

   	public function wish_list_actions($user_id, $pid, $type)
   	{
   		$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

   		// echo "<pre>";
   		// print_r($wish_arr);
   		// die;
   			$my_wish = array();

			if(!empty($wish_arr)) $id = $wish_arr[0]['id'];
			if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);

			if (empty($wish_arr) && $type == 'add')
			{
				$my_wish[] = $pid;
				$data = array('meta_key' => 'wish_list', 'content' => serialize($my_wish), 'user_id' => $user_id);
				$this->custom_model->my_insert($data,'my_cart');
			}
			elseif (!in_array($pid, $my_wish) && $type == 'add')
			{
				$my_wish[] = $pid;
				
				$this->custom_model->my_update(array('content' => serialize($my_wish)),array('id' => $id),'my_cart',true,true);
			}
			
			if (in_array($pid, $my_wish) && $type == 'remove')
			{
				$my_wish = array_diff($my_wish, array($pid));
				
				// print_r($my_wish);
				// die;
				// $my_wish = array_filter($my_wish);
				$this->custom_model->my_update(array('content' => serialize($my_wish)),array('id' => $id),'my_cart');
				
			}

		return $my_wish;
   	}

	/**
	 * view wish list product
	 */
	public function view_wish_list()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);

		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'view_wish_list':$ws;

		//$user_id = 1060;

		$user_id = $this->check_user_login($language,$ws);

   	 	$response = array();
   	 	
   	 	if (!empty($user_id) )
		{
			$data = array();

			$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

			if (!empty($wish_arr) && !empty($wish_arr[0]['content']))
			{
				$my_wish = unserialize($wish_arr[0]['content']);
				if (empty($my_wish))
				{
					$data = new stdClass();
					echo json_encode( array("status" => false,"message" => "No order found !", "ws" => $ws ,"data" => $data) );die;
				}
				foreach ($my_wish as $key => $value)
				{
					$res = $this->this_product_data($value,$language);
					if ($res)
					{
						$data[] = $res['curr'];
					}				
				}
					//echo "<pre>";
					//print_r($res['curr']['status']);die;
				if($res['curr']['status'] == '1')
				{
					echo json_encode( array("status" => true,  "ws" => $ws  ,"data" => $data) );die;
				}
				else
				{
					echo json_encode( array("status" => false, "ws" => $ws, "message" => "No record found") );die;
				}	
				
						
				
			}
			else{
				$data = new stdClass();
				echo json_encode( array("status" => false ,  "ws" => $ws  ,"data" => $data) );die;
			}
		}
		else
		{
			echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}
   	/**
   	 * upload_image function
   	 */
   	public function upload_image()
   	{
   		$uid = 0;
   		$uid = $this->validate_token();

    	/*	$id = uniqid();
    	$req_dump = "<br/>---------".$id."---------<br/>".print_r( $_REQUEST, true );
    	file_put_contents( 'logs/'.$id.'_request.log', $req_dump );
    	$ser_dump = "<br/>---------".$id."---------<br/>".print_r( $_SERVER, true );
    	file_put_contents( 'logs/'.$id.'_server.log', $ser_dump );
    	$file_dump = "<br/>---------".$id."---------<br/>".file_get_contents( 'php://input' );
    	file_put_contents( 'logs/'.$id.'_file.log', $file_dump );
    	$fil_dump = "<br/>---------".$id."---------<br/>".print_r( $_FILES, true );
    	file_put_contents( 'logs/'.$id.'_fil.log', $fil_dump );*/
    	
   	    @$image_type = @$_POST['image_type'];
   	    $language = @$_POST['language'];
   	    $language = empty($language)? 'en':$language;
   	    
   	    $FILES = @$_FILES['club_image'];
    	if(!empty($FILES)){
    				if(isset($FILES["type"]))
    				{
    					$details = array( "caption" => "My Logo", "action" => "fiu_upload_file", "path" => "admin/usersdata/$image_type/" );
    					$path = $details['path'];
    					$upload_dir =  ASSETS_PATH.$path;
    					if (!file_exists($upload_dir)) {
    						mkdir($upload_dir, 0777, true);
    					}
    					$newFileName = md5(time());
    					$target_file = $upload_dir . basename($FILES["name"]);
    					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    					$newFileName = $newFileName.".".$imageFileType;
    					$target_file = $upload_dir.$newFileName;

    					list($width, $height, $type, $attr)= getimagesize($FILES["tmp_name"]);
    					$type1 = $FILES['type'];  

    					if ( ( ($imageFileType == "gif") || ($imageFileType == "jpeg") || ($imageFileType == "jpg") || ($imageFileType == "png") ) )
    					{ 

    						if (move_uploaded_file($FILES["tmp_name"], $target_file)) 
    						{
    							$post_data = array('name' => $newFileName,
    												'path' => $path,
													'note' => 'user,'.$image_type.',app',
    												'user_id' => $uid);
    							$img_id = $this->custom_model->my_insert($post_data,'image_master');
    							echo json_encode( array( "status" => true,"data" => $newFileName, "url" => base_url("assets/admin/usersdata/$image_type/").$newFileName ) );die;
    						}
    						else
    						{
    							echo json_encode( array( "status" => false,"data" => ($language == 'ar'? 'حاول مرة اخرى.':'Please try again.') ) );die;
    						}
    					}
    					else
    					{ 
    						echo json_encode( array( "status" => false,"data" => ($language == 'ar'? 'الرجاء تحميل صورة صالحة.':'Please upload valid image.') ) );die;
    					}
    				}
    	}else{
    		echo json_encode( array( "status" => false,"data" => ($language == 'ar'? 'الرجاء تحميل صورة صالحة.':'Please upload valid image.') ) );die;
    	}
	    
   	}
	/**
	 * place_order function
	 */
	public function place_order()
	{
		$uid = 0;

		
		$json = file_get_contents('php://input');
		// $json 	= '{"mobile_no": "8149169115", "email": "vishal@appristine.in", "address": "441", "language": "en", "device": "IOS", "shipping_charge": "0", "last_name": "Bhumkar", "country_code": "1", "first_name": "Girish", "sub_total": "20", "payment_method": "cash-on-del"}';

		//$json = '{"dme_id":"76492","delivery_type":"","":"9685745698","email":"vishal@appristine.in","address":"441","device":"android","shipping_charge":"0.00","first_name":"Madhu","last_name":"kh","country_code":"","sub_total":"7120.0","payment_method":"cash-on-del","type":"cart","language":"en"}';

		// $json = '{"last_name" : "1554121679","year" : "","card_number" : "","cvv" : "","card_name" : "","country_code" : "0.00","device" : "IOS","email" : "kantikar@gmail.com","card_type" : "","dme_id" : "","language" : "en","address" : "74","delivery_type": "","first_name" : "change","shipping_charge" : 1,"month" : "","mobile_no" : "14236870","sub_total" :137.99000000000001,"payment_method" : "cash-on-del","type" : "cart"}'

		//$json = '{"dme_id":"","delivery_type":"store_pickup","mobile_no":"9856547621","email":"vishal@appristine.in","address":"","device":"android","shipping_charge":"regular_delivery","first_name":"Anna","last_name":"Th","country_code":"","sub_total":"3000.0","payment_method":"ONLINE","card_name":"John Smith","card_number":"4788250000028291","card_type":"visa","month" :"10" , "year" :"20" ,"cvv":"123","type":"buy_now","language":"en"}';

		$jsonobj 	= json_decode($json, True);
   	 	$response = $data = $post_arr = $payment = array();
		$language 	= @$jsonobj['language'];
		$language = empty($language)? 'en':$language;
		
		$ws 		= @$jsonobj->ws;
        $ws 		= empty($ws)? 'place_order':$ws;
        //$uid = 230;
        //print_r($uid);
		//$uid = $this->validate_token($language,$ws);
		 $uid = 44;
		// CONTACT DETAILS
		$post_arr['username'] 	= @$jsonobj['email'];
		$post_arr['first_name'] = @$jsonobj['first_name'];
		$post_arr['last_name'] 	= @$jsonobj['last_name'];
		$post_arr['mobile_no'] 	= @$jsonobj['mobile_no'];
		// address details
		$post_arr['address'] 	= @$jsonobj['address'];
		if($post_arr['address'] == '')
		{
			$post_arr['delivery_type'] 	= @$jsonobj['delivery_type'];
		}
		

		// BILLING INFORMATION
		
		$payment_method = @$jsonobj['payment_method'];
		$post_arr['payment_method'] = $payment_method;
		$type 					= @$jsonobj['type'];
		
		if($post_arr['payment_method'] == 'ONLINE' && $type == 'buy_now')
		{
			$post_arr['card_name'] 			= @$jsonobj['card_name'];
			$post_arr['card_number'] 		= @$jsonobj['card_number'];
			$post_arr['card_type'] 			= @$jsonobj['card_type'];
			$post_arr['month'] 				= @$jsonobj['month'];
			$post_arr['year'] 				= @$jsonobj['year'];
			$post_arr['cvv'] 				= @$jsonobj['cvv'];

		}
		if($post_arr['payment_method'] == 'ONLINE' && $type == 'cart')
		{
			$payment['card_name'] 			= @$jsonobj['card_name'];
			$payment['card_number'] 		= @$jsonobj['card_number'];
			$payment['card_type'] 			= @$jsonobj['card_type'];
			$payment['month'] 				= @$jsonobj['month'];
			$payment['year'] 				= @$jsonobj['year'];
			$payment['cvv'] 				= @$jsonobj['cvv'];
		}
	

		$post_arr['payment_mode'] = $payment_method;
		$post_arr['online_pay'] 	= @$jsonobj['online_pay'];
		//$card_type = $post_arr['card_type'] 		= @$jsonobj['card_type'];

		/*$post_arr['card_number'] 	= @$jsonobj['card_number'];
		$post_arr['card_name'] 		= @$jsonobj['card_name'];
		$post_arr['exp_month'] 		= @$jsonobj['exp_month'];
		$post_arr['exp_year'] 		= @$jsonobj['exp_year'];*/
		// $post_arr['insurance'] 	= @$jsonobj['insurance'];
		// $post_arr['usersdata'] 	= @$jsonobj['usersdata'];
		//$post_arr['cvv']			= @$jsonobj['cvv'];

		$post_arr['dme_id'] 		= @$jsonobj['dme_id'];

		$save_details 				= @$jsonobj['save_details'];
		$credit_result 				= @$jsonobj['credit_card_result'];
        $device_fingerprint_id      = @$jsonobj['device_fingerprint_id'];
		// Product info
		$products 						= @$jsonobj['products'];
		$post_arr['sub_total']			= 0;
		$post_arr['shipping_charge'] 	= @$jsonobj['shipping_charge'];
		$device = @$jsonobj['device'];
   	 	$save_details = '';
   	 	$post_arr['order_status'] = "pending";

	   	// echo "<pre>";
	   	// print_r($products);
	   	// die;
   	 	
   	 	/*if($post_arr['address'] == 'store_pickup')
   	 	{
   	 		$post_arr['address'] 	= @$jsonobj['address'];
   	 	}	*/
   	 	if ($type == 'buy_now')
		{
			$status = $this->buy_now_order_place($json,$uid);
			// echo "<pre>";
			// print_r($status);
			// die;
			$url ='';
			if ($status['status'] == 'success')
			{
				
				echo json_encode( array("status" => true,"display_order_id" => $status['display_order_id'] ,"ws"=>$ws,"message" => ($language == 'ar'? 'طلب':'Successfully')) );die;
			}
			else if($payment_method == 'ONLINE' && $status['status'] == 'success' && $status['transaction_status'] == 'approved')
			{
				echo json_encode( array("status" => true,"display_order_id" => $status['display_order_id'] , "transaction_status"=>$status['transaction_status'] ,"ws"=>$ws,"message" => ($language == 'ar'? 'طلب':'Successfully')) );die;
			}
			else if($payment_method == 'ONLINE' && $status['status'] == 'error' && $status['transaction_status'] == 'Not Processed')
			{
				echo json_encode( array("status" => false ,"ws" => $ws ,"transaction_status"=>$status['transaction_status'],"data" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
			}
			else if($payment_method == 'ONLINE' && $status['transaction_status'] == 'declined')
			{
				echo json_encode( array("status" => false ,"ws" => $ws ,"transaction_status"=>$status['transaction_status'],"data" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
			}
			else
			{
    			echo json_encode( array("status" => false ,"ws" => $ws ,"data" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
    		}
	        // die;
		}
		else
		{
		
            $is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
            $is_data_h = $this->custom_model->my_where('my_cart','*',array('user_id' => 'h_'.$uid,'meta_key' => 'cart'));
			$is_data_p = $this->custom_model->my_where('my_cart','*',array('user_id' => 'p_'.$uid,'meta_key' => 'cart'));
            $guest_content=$this->session->userdata('guest_content');
            $guest_content_p=$this->session->userdata('guest_content_p');
            if (!empty($is_data) OR !empty($is_data_h) OR !empty($is_data_p) OR !empty($guest_content) OR !empty($guest_content_p))
            {
      
				$products = unserialize($is_data[0]['content']);
				if (!empty($products))
                {

	                $this->load->library('place_new_order');
                    $response = $this->place_new_order->create_order($post_arr,$products, $uid, $device,$credit_result,$payment,$guest_content,$guest_content_p);
                    
                }
    
            }
    
    		// print_r($is_data);
    		// print_r($products);print_r($is_data);print_r($post_arr);
    		// die;
    
    		$url = "";
    		if ($response)
    		{
    			$this->load->library('user_account');
    			/*if(isset($response['remove_pr'])){
    			    foreach ($response['remove_pr'] as $key => $value)
    			    {
    			    	$this->user_account->add_remove_cart($value,$uid,'remove');
    			    }
    			}*/
    			
    			$this->custom_model->my_update(array('content' =>''),array('meta_key' => 'cart','user_id' => $uid),'my_cart');


				$title      = "Order Notification";
            	$message    = "Order placed successfully your order id is ".$response['display_order_id'] ;

            	$noti_cart = array(
								"message" 			=> $message,
								"title" 			=> $title,
								"user_id" 			=> $uid);
				$notification = $this->custom_model->my_insert($noti_cart,'user_notification');

				if($response['transaction_status'] == 'declined')
				{
					echo json_encode( array("status" => false,"display_order_id" => $response['display_order_id'] ,"ws" => $ws ,"transaction_status" => $response['transaction_status'], "data" => $response) );die;
				}
				else
				{
					echo json_encode( array("status" => true,"display_order_id" => $response['display_order_id'] ,"ws" => $ws ,"transaction_status" => $response['transaction_status'], "data" => $response) );die;
				}
    
    		}
    		else
    		{
    			echo json_encode( array("status" => false ,"ws" => $ws ,"data" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
    		}
		}
   	}

	public function buy_now_order_place($json,$uid)
	{
		$jsonobj 	= json_decode($json, True);
		$type 			= @$jsonobj['type'];

		/*echo "<pre>";
		print_r($jsonobj);
		die;*/

		if ($type == 'buy_now')
		{
			//$product_id = 16;
			$product_id     			= @$jsonobj['product_id'];
			$color      				= @$jsonobj['color'];
			$size      					= @$jsonobj['size'];
			$order_type					=	'Ecommerce';
			$name						= @$jsonobj['first_name'] .' '.@$jsonobj['last_name'] ;
			$mobile_no      			= @$jsonobj['mobile_no'];
			$email      				= @$jsonobj['email'];
			$address_id      			= @$jsonobj['address'];
			$delivery_type      		= @$jsonobj['delivery_type'];
			$sub_total      			= @$jsonobj['sub_total'];
			$shipping_charge      		= @$jsonobj['shipping_charge'];
			$quantity      				= @$jsonobj['quantity'];
			$payment_method      		= @$jsonobj['payment_method'];
			$source      				= @$jsonobj['device'];
			$dme_id      				= @$jsonobj['dme_id'];
			$card_name					= @$jsonobj['card_name'];
			$card_number				= @$jsonobj['card_number'];
			$card_type					= @$jsonobj['card_type'];
			$month						= @$jsonobj['month'];
			$year 						= @$jsonobj['year'];
			$cvv 						= @$jsonobj['cvv'];
			
				
			date_default_timezone_set('Asia/Kolkata');
        	$order_datetime = date("Y-m-d h:i:s");
        	//$product_id = 14;
			if (!empty($product_id))
			{
				
			
				$product_details = $this->custom_model->my_where('product','*',array('id' => $product_id));
				if($delivery_type == '')
				{
					
					$add_detail = $this->custom_model->my_where('user_address','*',array('id' => $address_id));
				}
				
				
				if (!empty($product_details))
				{
					
					$seller_id 		= $product_details[0]['seller_id'] ;
					$price 			= $product_details[0]['price'] ;
					$product_name 	= $product_details[0]['product_name'] ;
					$order_status 	= 'pending';

					if ($payment_method == 'cash-on-del')
					{
						$payment_status = 'unpaid';
					}
					elseif ($payment_method == 'online')
					{
						$payment_status = 'paid';
					}

					
					$attribute_data = $response = array();
					if(!empty($color)) $attribute_data['color'] 			= $color;
					if(!empty($size)) $attribute_data['size'] 				= $size;
					$attribute =  json_encode($attribute_data);


					$order_master_data = $response = array();
					if(!empty($order_status)) $order_master_data['order_status'] 		= $order_status;
					if(!empty($order_type)) $order_master_data['order_type'] 			= $order_type;
					if(!empty($uid)) $order_master_data['customer_id'] 					= $uid;
					if(!empty($uid)) $order_master_data['user_id'] 						= $uid;
					if(!empty($name)) $order_master_data['name'] 						= $name;
					if(!empty($order_datetime)) $order_master_data['order_datetime'] 	= $order_datetime;
					if(!empty($mobile_no)) $order_master_data['mobile_no'] 				= $mobile_no;
					if(!empty($email)) $order_master_data['email'] 						= $email;
					if($delivery_type == '')
					{
						if(!empty($add_detail)) $order_master_data['address_1'] 	= $add_detail[0]['address_1'];
						if(!empty($add_detail)) $order_master_data['address_2'] 	= $add_detail[0]['address_2'];
						if(!empty($add_detail)) $order_master_data['city'] 			= $add_detail[0]['city'];
						if(!empty($add_detail)) $order_master_data['state'] 		= $add_detail[0]['state'];
						if(!empty($add_detail)) $order_master_data['country'] 		= $add_detail[0]['country'];
						if(!empty($add_detail)) $order_master_data['pincode'] 		= $add_detail[0]['pincode'];
					}
					else
					{
					 	$order_master_data['delivery_type'] 	= $delivery_type;
					}
					if(!empty($payment_method)) $order_master_data['payment_mode'] 	= $payment_method;
					if(!empty($payment_status)) $order_master_data['payment_status'] 	= $payment_status;

					if(!empty($source)) $order_master_data['source'] 					= $source;
					if(!empty($order_datetime)) $order_master_data['created_date'] 		= $order_datetime;
					if(!empty($price)) $order_master_data['sub_total'] 				= $price;
					if(!empty($price)) $order_master_data['net_total'] 				= $price;

					/* Shipping charge 29-01-2019 vk*/
					if($shipping_charge == 'regular_delivery')
					{
						$regular_ship = $this->custom_model->get_data_array("SELECT `regular_delivery` FROM shippingcharge");
						$shipping_charge = $regular_ship[0]['regular_delivery'];

						if(!empty($shipping_charge)) $order_master_data['shipping_charge'] 	= $shipping_charge;
						
					}
					else
					{
						$urgent_ship = $this->custom_model->get_data_array("SELECT `onehour_delivery` FROM shippingcharge");
						$shipping_charge = $urgent_ship[0]['onehour_delivery'];
						if(!empty($shipping_charge)) $order_master_data['shipping_charge'] 	= $shipping_charge;
					}
					/* end */

					if(!empty($dme_id)) $order_master_data['dme_id'] 			= $dme_id;
					$order_master_id = $this->custom_model->my_insert($order_master_data,'order_master');
					$display_order_id = date('YmdHis').$order_master_id;

				
					$this->custom_model->my_update(array('display_order_id' => $display_order_id),array('order_master_id' => $order_master_id),'order_master');
                    
                    //print_r($display_order_id);
                    //die;
                    
					if (!empty($order_master_id))
					{
						$order_master_data = $response = array();
						if(!empty($order_master_id)) $order_master_data['order_no'] 	= $order_master_id;
						if(!empty($uid)) $order_master_data['customer_id'] 				= $uid;
						if(!empty($uid)) $order_master_data['user_id'] 				= $uid;
						if(!empty($product_id)) $order_master_data['product_id'] 		= $product_id;
						if(!empty($seller_id)) $order_master_data['seller_id'] 			= $seller_id;
						if(!empty($order_datetime)) $order_master_data['created_date'] 	= $order_datetime;
						if(!empty($product_name)) $order_master_data['product_name']	= $product_name;
						if(!empty($attribute)) $order_master_data['attribute'] 			= $attribute;


						if(!empty($quantity)) $order_master_data['quantity'] 			= $quantity;
						if(!empty($price)) $order_master_data['price'] 					= $price;

						if(!empty($order_datetime)) $order_master_data['created_date'] 		= $order_datetime;
						if(!empty($price)) $order_master_data['sub_total'] 				= $price;
						if(!empty($shipping_charge)) $order_master_data['shipping_cost'] 	= $shipping_charge;

						$order_item_id = $this->custom_model->my_insert($order_master_data,'order_items');

						$curr = $this->custom_model->my_where('product','id,seller_id,stock,product_name,price,sale_price,category',array('id'=>$product_id));


						$update['stock'] = $curr[0]['stock'] - 1;

						if ($update['stock'] == 0 || $update['stock'] < 0)
						{
							$update['stock_status'] = 'notinstock';
						}
						$this->custom_model->my_update($update,array('id' => $product_id), 'product');

						// commission and tax update

						$curr1 = $this->custom_model->my_where('admin_users','first_name,commision,email',array('id'=>$seller_id));
						
						if ($curr1) 
						{
							$commision = $curr1[0]['commision'];
						}
						$totalcommision = 0;
						// $final_commission = (($price * $quantity) + $tax) * ($commision / 100);
						$final_commission = (($price * $quantity)) * ($commision / 100);

						// print_r($item_id);
						// echo "<br>";

						$totalcommision +=$final_commission;
						
						// update commission of that product
						$this->custom_model->my_update(array('commission' => $final_commission), array('item_id' => $order_item_id), 'order_items');


					}

					if (!empty($order_master_id) && !empty($order_item_id))
					{
						
						$order_status = 'pending';

						if ($payment_method == 'cash-on-del')
						{
							$payment_status = 'unpaid';
						}
						elseif ($payment_method == 'online')
						{
							$payment_status = 'paid';
						}
						

						$order_invoice_data = $response = array();




						if(!empty($order_master_id)) $order_invoice_data['order_no'] 	= $order_master_id;
						if(!empty($order_item_id)) $order_invoice_data['item_ids'] 		= $order_item_id;
						if(!empty($payment_status)) $order_invoice_data['payment_status'] = $payment_status;

						if(!empty($payment_method)) $order_invoice_data['payment_mode'] = $payment_method;
						if(!empty($order_datetime)) $order_invoice_data['created_date'] 	= $order_datetime;
						if(!empty($seller_id)) $order_invoice_data['seller_id'] 			= $seller_id;
						if(!empty($shipping_charge)) $order_invoice_data['shipping_cost'] 	= $shipping_charge;
						if(!empty($shipping_charge)) $order_invoice_data['transaction_cost'] = $shipping_charge;
						if(!empty($price)) $order_invoice_data['sub_total'] 			= $price;
						if(!empty($order_status)) $order_invoice_data['order_status']	= $order_status;
						if(!empty($display_order_id)) $order_invoice_data['display_order_id']	= $display_order_id;
						if(!empty($price)) $order_invoice_data['net_total'] 		= $price;
						if(!empty($source)) $order_invoice_data['source'] 				= $source;

						$order_item_id = $this->custom_model->my_insert($order_invoice_data,'order_invoice');

						$curr12 = $this->custom_model->my_where('admin_users','first_name,commision,email',array('id'=>$seller_id));
						
						if ($curr12) 
						{
							$commision = $curr12[0]['commision'];
						}

						// echo "<pre>";
						// print_r($product_id);
						// die;

						$totalcommision = 0;
						$final_commission = ($price) * ($commision / 100);

						$update_final_comm[] = $final_commission; 
						$this->custom_model->my_update(array('commission' => $final_commission), array('invoice_id' => $order_item_id), 'order_invoice');
					}

					$tax_amount = $this->custom_model->my_where('tax','id,tax');
					$tax = 0;
					if ($tax_amount) 
					{
						$tax = $tax_amount[0]['tax'];
					}


					$final_tax = (($price)) * ($tax / 100);

					$total_adding_final_comm = array_sum($update_final_comm);

					// print_r($total_amount);
					// echo "<br>";
					// print_r($total_adding_final_comm);

					$this->custom_model->my_update(array('display_order_id' => $display_order_id,"sub_total" => $price, "net_total" => $price,"tax" => $final_tax,'commision' => $total_adding_final_comm),array('order_master_id' => $order_master_id),'order_master');
				    
				    $title_buy     = "Order Notification";
            		$message_buy    = "Order placed successfully your order id is ".$display_order_id;
            	
            		$noti_buy = array(
								"message" 			=> $message_buy,
								"title" 			=> $title_buy,
								"user_id" 			=> $uid);

					$notification_buy = $this->custom_model->my_insert($noti_buy,'user_notification');

					/* Payment integration */

				if($payment_method == 'ONLINE' && !empty($display_order_id))
				{

				    //$post_data = $this->input->post();
				    /*echo "<pre>";
				    print_r($post_data);
				    die;*/
					if(isset($display_order_id) && !empty($display_order_id)){
					    $insert_data = array();
					    //siddiqi account
					    // $serviceURL = 'https://api-cert.payeezy.com/v1/transactions';

					     // production url live
					    $serviceURL = 'https://api.payeezy.com/v1/transactions';

					    /* this is use for payeeze account */
					    //$serviceURL = 'https://checkout.globalgatewaye4.firstdata.com';
					    /* End */
					    // client sandbox api key
					    /*$apiKey = "UMAWJEQeX5gRzpX25DopFzoNsN4Z6O31";
					    $apiSecret = "c1c2447739a59737f858ce3531c148d9363f2b49ba5856eac3c5df8f79b48033";
					    $token = "fdoa-08370ee0bab59261e0583e7c015b232f08370ee0bab59261";*/

					    // quamer sabdbox api key
					    /*$apiKey = "LENo2GpSnAnxJH89Z2Ux9fY4PJm4PicE";
					    $apiSecret = "526dde8c301fd598f465c7a53d55526b93bdb7ccee48c5a325cee5e31922c249";
					    $token = "fdoa-f82cb3977604312c074c9dce2038e049f82cb3977604312c";*/

					    //client production api key
					    $apiKey = "XfuqFbDrwqcjSIuGaPwQJUjSJRQK0cGj";
					    $apiSecret = "2e02a41eed03e11f38cc622866123290266cc80e453192ee4d5775112a7874b9";
					    $token = "fdoa-baea26c8a723b56b15610215675d2010baea26c8a723b56b";



					    $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
					    $timestamp = strval(time()*1000); //time stamp in milli seconds

					    //$query  = $this->custom_model->get_data_array("SELECT * FROM order_master WHERE display_order_id = '$display_order_id'");
					    //$sub_total          = $order_details[0]['sub_total'];
					    //$payment_status     = $order_details[0]['payment_status'];
					    //$order_master_id    = $order_details[0]['order_master_id'];
					    //$display_order_id    = $order_details[0]['display_order_id'];
					    

					    $price_round = $price * 100;
					 $info_array = array(
					          "sub_total"       => $price_round,
					          "currency_code"   => 'USD',
					          "serviceURL"      => $serviceURL,
					          "apiKey"          => $apiKey,
					          "apiSecret"       => $apiSecret,
					          "token"           => $token,
					          "payment_status"  => $payment_status,
					          "card_name"       => $card_name,
					          "card_number"     => $card_number,
					          "card_type"       => $card_type,
					          "month"           => $month,
					          "year"            => $year,
					          "cvv"            => $cvv,
					          "user_id"             => $uid,
					          "order_master_id"    => $order_master_id,
					          "display_order_id"   => $display_order_id
					        );

					    // echo "<pre>";
					    // print_r($info_array);
					    // die;

					    $post_data2 = $this->setPrimaryTxPayload($info_array);

					    
					    $payload =$this->getPayload($post_data2);

					    /*echo "<pre>";
					    print_r($payload);
					    die;*/
					    /**
					    * Payeezy
					    *
					    * Generate Payload
					    */

					   /* echo "<br><br> Request JSON Payload :" ;
					    echo $payload ;
					    echo "<br><br> Authorization :" ;*/

					    $data = $apiKey . $nonce . $timestamp . $token . $payload;
					   

					    $hashAlgorithm = "sha256";

					    ### Make sure the HMAC hash is in hex -->
					    $hmac = hash_hmac ( $hashAlgorithm , $data , $apiSecret, false );

					    ### Authorization : base64 of hmac hash -->
					    $hmac_enc = base64_encode($hmac);

					    /*echo "<br><br>";
					    echo $hmac_enc;
					    echo "<br><br>" ;*/

					    $curl = curl_init('https://api.payeezy.com/v1/transactions');
					    /*echo "<pre>";
					    print_r($curl);
					    die;*/
					    $headers = array(
					          'Content-Type: application/json',
					          'apikey:'.strval($apiKey),
					          'token:'.strval($token),
					          'Authorization:'.$hmac_enc,
					          'nonce:'.$nonce,
					          'timestamp:'.$timestamp,
					        );

					    curl_setopt($curl, CURLOPT_HEADER, false);
					    curl_setopt($curl, CURLOPT_POST, true);
					    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

					    curl_setopt($curl, CURLOPT_VERBOSE, true);
					    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

					    $json_response = curl_exec($curl);

					    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

					    $response = json_decode($json_response, true);

					    //echo "<br><br> " ;
					    // echo "<pre>";
					    //print($json_response);
					    //print($status);
					    //die;
					    	// echo "<pre>";
					     //  print_r($response);
					     //  die;
					    if ($status != 201 )
					    {
					  
					      $insert_data = $response;      
					      //echo ("Error: call to URL $serviceURL failed with status $status, response , curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
					      $insert_data['Error_code']=$insert_data['Error']['messages'][0]['code'];
					      $insert_data['Error_description']=$insert_data['Error']['messages'][0]['description'];
					      $insert_data['card_type'] = $card_type;
					      $insert_data['cardholder_name'] = $card_name;
					      $insert_data['card_number'] = $card_number;
					      $insert_data['exp_date'] = $month.$year; 
					      $insert_data['user_id'] =  $uid;
					      $insert_data['display_order_id'] = $display_order_id;
					      $insert_data['order_id'] = $order_master_id;
					      unset($insert_data['Error']);

					      $this->custom_model->my_insert($insert_data,'transaction_details');

					      $cureent_date = date("Y-m-d h:i:s A");

					      $update_master = $this->custom_model->my_update(array("payment_status" => 'unpaid', "order_status" => 'cancel',"user_id" => $uid,"customer_id" => $uid,"transaction_status" => $response['validation_status'],"transaction_time" => $cureent_date),array("order_master_id" => $insert_data['order_id']),"order_master" );

					     /* echo "<h2>Your transactions id :".@$response['transaction_id']."</h2>";
					      echo "<h2>Your correlation id  :".@$response['correlation_id']."</h2>";
					      echo "<h2>Your Payment Status :".$response['validation_status']."</h2>";
					      echo "<h2>Error Code:".$response['Error']['messages'][0]['code']."</h2>";
					      echo "<h2>Error Message :".$response['Error']['messages'][0]['description']."</h2>";*/

					     //echo json_encode( array("status" => false, "ws" => $ws ,"data" => $response) );die;


					    }
					    else 
					    {
					      $insert_data = $response;
					      //$insert_data['token_type'] = $insert_data['token']['token_type'];
					      //$insert_data['token_value'] = $insert_data['token']['token_data']['value'];
					      $insert_data['card_type'] = $card_type;
					      $insert_data['cardholder_name'] = $card_name;
					      $insert_data['card_number'] = $card_number;
					      $insert_data['exp_date'] = $month.$year;
					      $insert_data['user_id'] = $uid;
					      $insert_data['display_order_id'] = $display_order_id;
					      $insert_data['order_id'] = $order_master_id;

					      unset($insert_data['token']);
					      unset($insert_data['card']);

					      // print_r($response);
					      // die;

					      $this->custom_model->my_insert($insert_data,'transaction_details');
					      
					      $cureent_date = date("Y-m-d h:i:s A");

					      if($response['transaction_status'] == 'declined')
					      {
					      	$update_master = $this->custom_model->my_update(array("payment_status" => 'unpaid' ,"transaction_status" => $response['transaction_status'],"transaction_time" => $cureent_date),array("order_master_id" => $insert_data['order_id']),"order_master" );
					      }
					      else
					      {
					      	$update_master = $this->custom_model->my_update(array("payment_status" => 'paid' ,"transaction_status" => $response['validation_status'],"transaction_time" => $cureent_date),array("order_master_id" => $insert_data['order_id']),"order_master" );
					      
					      }
					     
					       //echo json_encode( array("status" => true , "ws" => $ws ,"data" => $response) );die;

					    }
					  } 
				}

					/* End */
					//print_r($response);
					//die;
					if($payment_method == 'ONLINE' && @$response['transaction_status'] == 'Not Processed' && @$response['validation_status'] == 'failed')
					{
	
						return ['status'=>'error','display_order_id'=>$display_order_id,'transaction_status'=>@$response['transaction_status']];
						
					}
					else if($payment_method == 'ONLINE' && $transaction_status == 'approved' && $validation_status == 'success')
					{
						
						
						return ['status'=>'success','display_order_id'=>$display_order_id,'transaction_status'=>@$response['transaction_status']];
						
					}
					else if($payment_method == 'ONLINE' && $response['transaction_status'] == 'declined')
					{

						return ['status'=>'error','display_order_id'=>$display_order_id,'transaction_status'=>@$response['transaction_status']];
						
					}
					else
					{
						return ['status'=>'success','display_order_id'=>$display_order_id];
					}

				}
				else
				{
					 return ['status'=>'error','display_order_id'=>$display_order_id];

				    // return  "error";
				}
				
				// echo "<pre>";
				// print_r($order_invoice_data);
				// echo "<br>";
				// print_r($order_item_id);
				// echo "<br>";
				// print_r($order_master_id);
				// echo "<br>";
				// print_r($add_detail);
				// print_r($order_master_data);
				// // print_r($jsonobj);
				die;
			}
		}else{
			return  "error";
		}
   	}
   	
	/**
	 * order_history 
	 */
	public function order_history_user()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
        //  $uid 		= @627;
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'order_history_user':$ws;
		//$uid = 20;
		$uid = $this->validate_token($language,$ws);

   	 	$response = array();

		if (!empty($uid))
		{
			$data = array();
			$data = $this->custom_model->my_where("order_master","order_status,display_order_id,order_master_id,name,order_datetime,payment_mode,net_total,mobile_no,email,order_type,order_comment",array("customer_id" => $uid),array(),"order_master_id","DESC" );
			if (!empty($data))
			{
				foreach ($data as $key => $value)
				{
					$items = $this->custom_model->my_where("order_items","product_id,seller_id,quantity,price,commission,attribute,order_status,order_comment",array("order_no" => $value['order_master_id']) );

					foreach ($items as $k => $val)
					{
						$item_info = $this->custom_model->my_where("product","id,product_name,product_image,category,insurance",array("id" => $val['product_id']) );
						
						if(!empty($item_info[0]['category']))
						{
						    $cat_name =  $this->custom_model->my_where('category','*',array('id' => $item_info[0]['category']));
						    if(!empty($cat_name))
						    {
						        $item_info[$k]['category_name'] = $cat_name[0]['display_name'];        
						    }
						}
						
				        
				        // print_r($cat_name);		
						
						
						
						@$item_info[0]['product_image'] = $this->get_product_path($item_info[0]['product_image']);
						@$val['attribute'] = ($val['attribute'] != '[]')? json_decode($val['attribute']):new stdClass();
						@$data[$key]['items'][$k] = array_merge($val,$item_info[0]);
					}
				}
				// echo "<pre>";
				// print_r($cat_name);
				// die;
				echo json_encode( array("status" => true,"ws" => $ws ,"data" => $data) );die;
			}
			else{
	   	 		$response['ws'] = $ws;
	   	 		$response['status'] = false;
				$response['message'] = ($language == 'ar'? 'لا توجد طلبات حتى الآن!':'No orders yet!');
				echo json_encode($response);die;
	   	 	}

		}
		else
		{
			echo json_encode( array("status" => false, "ws" => $ws  ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}

	/**
	 * address_book function
	 */
	public function address_book()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"id":"2" ,"address_name":"Girish R Bhumkar","address_1":"Building","address_2":"Building","city":"Building","country":"Building","state":"Building","pincode":"123456","type":"delete"}';
		$jsonobj 	= json_decode($json);

		$language 	= @$jsonobj->language;
		$language = empty($language)? 'en':$language;

		$address_type 		= @$jsonobj->address_type;
		
		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'address_book':$ws;

		// $user_id = 627;
		$user_id = $this->check_user_login($language,$ws);

		$id 	= @$jsonobj->id;
		$info_array = array(
				"user_id" => $user_id,
				"address_name" => @$jsonobj->address_name,
				"address_1" => @$jsonobj->address_1,
				"address_2" => @$jsonobj->address_2,
				"city" => @$jsonobj->city,
				"country" => @$jsonobj->country,
				"state" => @$jsonobj->state,
				"address_type" => @$jsonobj->address_type,
				"pincode" => @$jsonobj->pincode
			);

		$type 	= @$jsonobj->type;
   	 	$response = array();$inserted_id = 0;

   	 	if (!empty($user_id))
   	 	{
			if ($type == 'save')
			{
				$inserted_id = $this->custom_model->my_insert($info_array, 'user_address');
			}
			else if($type == 'update' && !empty($id))
			{
				$this->custom_model->my_update($info_array ,array("id" => $id),"user_address");
			}
			else if($type == 'delete' && !empty($id))
			{
				$this->custom_model->my_delete(['id' => $id], 'user_address');
			}

			$data = $this->custom_model->my_where("user_address","*",array("user_id" => $user_id),array(),"id","DESC","","", array(), "",array(),true );

			if (empty($data))
			{
				echo json_encode( array("status" => false, "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No record found')) );die;
			}
			else{
				foreach ($data as $key => $value)
				{
					if ($value['id'] == $inserted_id)
					{
						$data[$key]['mark'] = true;
					}
					else{
						$data[$key]['mark'] = false;
					}
				}
				echo json_encode( array("status" => true, "ws" => $ws ,"data" => $data) );die;
			}
   	 	}
		else
		{
			echo json_encode( array("status" => false, "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}

	/**
	 * Payment Setting
	 */
	public function setPrimaryTxPayload($post_data)
	{

		 $card_holder_name = $card_number = $card_type = $card_cvv = $card_expiry_month = $card_expiry_year = $card_expiry = $currency_code = $merchant_ref = $display_order_id = $order_master_id =  $user_id = "";

	      $card_holder_name       = $this->processInput($post_data['card_name']);
	      $card_number            = $this->processInput($post_data['card_number']);
	      $card_type              = $this->processInput($post_data['card_type']);
	      $card_cvv              = $this->processInput($post_data['cvv']);
	      $card_expiry            = $this->processInput($post_data['month'].$post_data['year']);
	      $amount                 = $this->processInput($post_data['sub_total']);
	      $display_order_id        = $this->processInput($post_data['display_order_id']);
	      $order_master_id         = $this->processInput($post_data['order_master_id']);
	      	$user_id         = $this->processInput($post_data['user_id']);
	      $currency_code          = $this->processInput($post_data['currency_code']);
	      $merchant_ref           = $this->processInput("Astonishing-Sale");

	      $primaryTxPayload = array(
	          "amount"=> $amount,
	          "card_number" => $card_number,
	          "card_type" => $card_type,
	          "cvv" => $card_cvv,
	          "card_holder_name" => $card_holder_name,
	          "card_expiry" => $card_expiry,
	          "merchant_ref" => $merchant_ref,
	          "currency_code" => $currency_code,
	          "display_order_id" => $display_order_id,
	          "order_master_id" => $order_master_id,
	          "user_id" => $user_id
	      );
	      /*echo "<pre>";
	      print_r($primaryTxPayload);
	      die;*/
	      return $primaryTxPayload;
	}

	/* End */
	public function getPayload($args = array())
	{
		    $args = array_merge(array(
		        "amount"=> "",
		        "card_number" => "",
		        "card_type" => "",
		        "cvv" => "",
		        "card_holder_name" => "",
		        "card_expiry" => "",
		        "merchant_ref" => "",
		        "currency_code" => "",
		        "transaction_tag" => "",
		        "split_shipment" => "",
		        "transaction_id" => "",
		        "display_order_id" => "",
		        "order_master_id" => "",
		        "user_id" => "",

		    ), $args);

		    $data = "";
		    
		    $data = array(
		              'merchant_ref'=> $args['merchant_ref'],
		              'transaction_type'=> "authorize",
		              'method'=> 'credit_card',
		              'amount'=> $args['amount'],
		              'display_order_id'=> $args['display_order_id'],
		              'order_master_id'=> $args['order_master_id'],
		              'currency_code'=> strtoupper($args['currency_code']),
		              'user_id'=> strtoupper($args['user_id']),
		              'credit_card'=> array(
		                      'type'=> $args['card_type'],
		                      'cardholder_name'=> $args['card_holder_name'],
		                      'card_number'=> $args['card_number'],
		                      'exp_date'=> $args['card_expiry'],
		                      'cvv'=> $args['cvv'],
		                    )
		    );
		   
		    return json_encode($data, JSON_FORCE_OBJECT);
	}

	public function processInput($data) 
	{
	    $data = trim($data);
	    $data = stripslashes($data);
	    $data = htmlspecialchars($data);
	    return strval($data);
	}

	/* End */

	/* get payment details list */
    public function get_payment()
    {
    	$json = file_get_contents('php://input');
	 	//$json 		= '{"user_id":"22"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;

		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'get_payment':$ws;

		$user_id = $this->validate_token($language ,$ws);

   	 	$response = array();

 		$data = $this->custom_model->get_data_array("SELECT * FROM saved_cards WHERE `user_id` = $user_id AND  status = 'success'");

   	 	if(isset($data)){
   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data) );die;
   	 	}else{
   	 		echo json_encode( array("status" => false,"ws"=>$ws ,"message" => 'No cards Saved') );die;
   	 	}
    }
    
	/* End */

	public function multiple_payment_card()
	{
		$json = file_get_contents('php://input');

		//$json 		= '{"display_order_id":"20190215173833202" ,"card_type":"Credit card","card_number":"123123123123","card_name" : "Girish" , "exp_month" :"01/11" , "exp_year" :"2020" ,"type" :"save"}';

   	 	$response = $data = $post_arr = array();
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;

		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'multiple_payment_card':$ws;

		//$user_id = 20;
		// $user_id = $this->check_user_login($language,$ws);

		$post_arr['user_id'] 	 		= @$user_id;
		$post_arr['card_type'] 			= @$jsonobj->card_type;
		$post_arr['card_number'] 		= @$jsonobj->card_number;
		$post_arr['card_name'] 			= @$jsonobj->card_name;
		$post_arr['exp_month'] 			= @$jsonobj->exp_month;
		$post_arr['exp_year'] 			= @$jsonobj->exp_year;
		$post_arr['display_order_id']			= @$jsonobj->display_order_id;
		$type 							= @$jsonobj->type;
		$inserted_id					= 0;

   	 	if (!empty($user_id))
		{
			
			if (!empty($post_arr) && $type == 'save')
			{
				$inserted_id = $this->custom_model->my_insert($post_arr,'billing_info');
			}
			else if(!empty($post_arr) && $type == 'update' && !empty($id))
			{
				$this->custom_model->my_update($post_arr,array('id' => $id),'billing_info');
			}
			else if($type == 'delete' && !empty($id))
			{
				$this->custom_model->my_delete(['id' => $id], 'billing_info');
			}

			$data = $this->custom_model->my_where('billing_info','*',array('user_id'=>$user_id), array(),"id","DESC");

			if (empty($data))
			{
				echo json_encode( array("status" => false , "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No record found')) );die;
			}
			else{
				foreach ($data as $key => $value)
				{
					if ($value['id'] == $inserted_id)
					{
						$data[$key]['mark'] = true;
					}
					else{
						$data[$key]['mark'] = false;
					}
				}
				echo json_encode( array("status" => true , "ws" => $ws ,"data" => $data) );die;
			}
		}

		echo json_encode( array("status" => false , "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
   	}


	/**
	 * Search by category/vendor/product
	 */
	public function search_category_product()
	{
	    $user_id = 0;
		$json = file_get_contents('php://input');
		// $json 		= '{"string":"Vacuum"}';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
        $ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'address_book':$ws;
		$string 	= @$jsonobj->string;
   	 	$response = array();
   	 	
   	 	// $user_id 	= 627;
        $user_id = $this->validate_token($language,$ws);
		$this->load->library('search');
   	 	$response = $this->search->search_lib($language,$string,'api',$user_id);
   	 	
   	 	if (!empty($response))
   	 	{
   	 		echo json_encode( array("status" => true ,"ws" => $ws , "message" => "Record found ." ,"data" => $response) );die;
   	 	}
   	 	else{
   	 		echo json_encode( array("status" => false,"ws" => $ws , "message" => "No record found .") );die;
   	 	}
   	 	
   	}

	
	public function check_qty_product()
	{
		$json = file_get_contents('php://input');
		
		//$json 		= '{"pid":"155" , "qty" :"111"}';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;

		$ws 		= @$jsonobj->ws;
		$ws 		= empty($ws)? 'check_qty_product':$ws;

		// $user_id = 627 ;
		
		// $user_id = $this->validate_token($language,$ws);

		$pid 	= @$jsonobj->pid;
		$qty 	= @$jsonobj->qty;
   	 	$response = array();

   	 	if (empty($pid) || empty($qty)) {
   	 		echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
   	 	}

   	 	$res = $this->custom_model->my_where('product','*',array('id' => $pid));
   	 	// echo "<pre>";
   	 	// print_r($res);
   	 	// die;
		if (isset($res[0]))
		{
			if ($qty > $res[0]['stock'])
			{
				$response['ws'] = $ws;
				$response['status'] = false;
				$response['message'] = ($language == 'ar'? 'لا يوجد رصيد كاف لإضافة كمية ...':'Not enough stock to add quantity...');
			}
			else{
				$response['status'] = true;
				$response['ws'] = $ws;
				$response['message'] = ($language == 'ar'? 'جاهز للمضي...':'Good to go...');
			}
		}

		echo json_encode( $response );die;
   	}
    
    
	public function products_filters()
	{
        $user_id = 0;
		$json 			= file_get_contents('php://input');
		 //$json 			= '{"category_id":"9"}';
		$jsonobj 		= json_decode($json);
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$category_id 	= @$jsonobj->category_id;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'products_filters':$ws;
		
		 //$user_id 		= 1060;

		$user_id = $this->validate_token($language);
		
   	 	$response = array();
   	 	$brands = array();
   	 	$color = array();
   	 	$price = array();


		if (!empty($category_id))
		{
			$query = "SELECT product_brand,diagnosis_code,product_name,price,id,COUNT(product_brand) AS pcount, MAX(price) AS price FROM `product` WHERE category = $category_id AND status = '1' group by product_brand";
			
			$result = $this->db->query($query);
			$brand_info =  $diag_code = array();
			foreach ($result->result() as $akey => $row)
			{
				$product_id[] = $row->id;
				$product_brand = $row->product_brand;
				$product_name = $row->product_name;
				$diagnosis_code = $row->diagnosis_code;

				$brand_info[$akey]['product_name'] 		= $product_name;
				// $brand_info[$akey]['product_id'] 	= $product_id;
				$brand_info[$akey]['product_brand']		= $product_brand;
				$brand_info[$akey]['diagnosis_code'] 	= $diagnosis_code;
				$diag_code[] = $diagnosis_code;
				// $brand_info[$akey]['count'] = $row->pcount;
			}
            
            // echo "<pre>";
            // print_r($diag_code);
            // die;
            $array3 = array();
            
            if (!empty($diag_code))
            {
            	foreach ($diag_code as $vkey => $vvalue)
            	{
					$myArray_vkey = explode(',', $vvalue);
					// print_r($myArray_vkey);
					$array3 = array_merge($myArray_vkey, $array3);
					// if (!empty($myArray_vkey))
					// {
					// 	foreach ($myArray_vkey as $dkey => $dvalue) {
					// 		$array3[] = $dvalue;
					// 	}
					// }
            	}

            	$a3 = array_unique($array3);
				asort($a3);
            }

            // echo "<pre>";
            // print_r($array3);

			if (empty($result->result()))
			{
			    echo json_encode( array("status" => false ,"ws" => $ws ,"message" => "Empty records .") );die;
			}
			
			
			$p_ids = implode(',', $product_id);

			// $color = "SELECT p.item_id,a.item_name FROM `product_attribute` as p join attribute_item as a on p.item_id = a.id where p.p_id IN ($p_ids) AND p.attribute_id = 19 group by item_id  ";
			$color = "SELECT p.item_id,a.item_name,a.image,a.attribute_code,a.a_id FROM `product_attribute` as p join attribute_item as a on p.item_id = a.id where p.p_id IN ($p_ids)  group by item_id  ";
            
			$color = $this->custom_model->get_data_array($color);
			/*foreach ($color as $key_color => $value_color) {
				@$a_id .= $value_color['a_id'];
				
			}
			if(empty(@$a_id == '19'))
				{
				echo "Color no founds";
				}	*/

			/*echo "<pre>";
			print_r($a_id);
			die;*/

			$price = "SELECT MAX( price ) AS max_price, MIN( price ) AS min_price FROM  `product` WHERE category =$category_id AND status =  '1' ";

			$price = $this->custom_model->get_data_array($price);
            
            //echo "<pre>";
            //print_r($price);
            // print_r($color);
            // print_r(array_values($array3));
            //die;
			

			echo json_encode( array("status" => true ,"ws" => $ws ,"brands" => $brand_info,"diag_code" => $a3, "color" => $color , "price" => $price , "message" => "Successfully ."));die;
			}
			else{
    			echo json_encode( array("status" => false ,"ws" => $ws ,"message" => "Empty records .") );die;
			}
	}
	
    
    public function products_filters_result()
	{
		$json 			= file_get_contents('php://input');
		// $json 			= '{"category_id":"61" , "min_price":"","max_price":"", "product_brand":"Metalic red" , "product_color" :"black","diag_code":"21"}';
		//$json = '{"category_id":"10","guest":"","string":"","min_price":"","max_price":"","product_brand":"","product_color":"","language":"en"}';
		$jsonobj 		= json_decode($json);
        
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;

		$diag_code 		= @$jsonobj->diag_code;

		$product_brand 	= @$jsonobj->product_brand;
		$category_id 	= @$jsonobj->category_id;
		$max_price 		= @$jsonobj->max_price;
		$min_price 		= @$jsonobj->min_price;
		$product_color 	= @$jsonobj->product_color;
        $string 	    = @$jsonobj->string;
        $guest 	        = @$jsonobj->guest;
        
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'products_filters_result':$ws;
		// $user_id 		= 0;
		
        if(empty($guest))
        {
            $user_id = $this->validate_token($language,$ws);    
        }
        
		if (!empty($category_id))
		{
			$seller = $this->custom_model->get_data_array("SELECT * FROM  `product` WHERE category = $category_id AND `status` = '1' ");

				if ($seller)
				{
					foreach ($seller as $akey => $avalue) {
						$seller_id = $avalue['seller_id'];
						if ($seller_id)
						{
							$seller_name = $this->custom_model->get_data_array("SELECT first_name FROM  `admin_users` WHERE id =$seller_id ");
							if ($seller_name)
							{
								$sel_name = $seller_name[0]['first_name'];
								$this->custom_model->my_update(array('seller_name' => $sel_name),array('id' => $seller[0]['id']),'product');
								$this->custom_model->my_update(array('seller_name' => $sel_name),array('id' => $seller[0]['id']),'product_trans');
							}
						}
					
					
					}
				}

			$price = $this->custom_model->get_data_array("SELECT MAX( price ) AS max_price, MIN( price ) AS min_price FROM  `product` WHERE category = $category_id AND status =  '1' ");
			
			if (empty($string))
   	 		{
   	 			if ($language != 'en')
   	 			{
   	 			    $data = $this->custom_model->get_data_array("SELECT MAX( price ) AS max_price, MIN( price ) AS min_price FROM  `product_trans` WHERE category =$category_id AND `status` =  '1' ");
   	 		    }
   	 			else
   	 			{
   	 				$data = $this->custom_model->get_data_array("SELECT MAX( price ) AS max_price, MIN( price ) AS min_price FROM  `product` WHERE category =$category_id AND  `status` =  '1' ");
   	 			}
   	 		}
   	 		else
   	 		{
   	 		    // print_r("SELECT MAX( price ) AS max_price, MIN( price ) AS min_price FROM  `product` WHERE category =$category_id AND product_name LIKE '%$string%'  AND  `status` = '1' ");
   	 			if ($language != 'en')
   	 			{
   	 				$data = $this->custom_model->get_data_array("SELECT * FROM  `product_trans` WHERE `category` = $category_id AND product_name LIKE '%$string%' OR  AND diagnosis_code LIKE '%$string%' OR item_code LIKE '%$string%' OR product_brand LIKE '%$string%' OR seller_name LIKE '%$string%' AND `status` = '1' ");

   	 			    // echo "<pre>";
   	 			    // print_r($data);
   	 			    // die;
   	 			    
   	 			}
   	 			else{
   	 				$data = $this->custom_model->get_data_array("SELECT * FROM  `product` WHERE `category` =$category_id AND (product_name LIKE '%$string%' OR  diagnosis_code LIKE '%$string%' OR item_code LIKE '%$string%' OR product_brand LIKE '%$string%' OR seller_name LIKE '%$string%') AND `status` = '1' ");
   	 			}

				// echo $this->db->last_query();
				// echo "<pre>";
				// print_r($data);
				// die;

   	 			if (!empty($data))
				{
					foreach ($data as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
       	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
    					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
    
    					$data[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
    					
    					
						$data[$rkey]['product_image'] = $this->get_product_path($data[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "product_brand" => $data , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
   	 		}
   	 		
   	 		
			if (empty($min_price) && empty($max_price) && !empty($price))
			{
				$min_price = $price[0]['min_price'];
				$max_price = $price[0]['max_price'];
			}
				// echo "<pre>";
				// print_r($price);
				// die;
				// echo $this->db->last_query();

			if (empty($min_price))
			{
				echo json_encode( array("status" => false ,"ws" => $ws ,"message" => "Empty records .") );die;
			}
			

			if (!empty($product_brand) && empty($product_color))
			{
				$myArray = explode(',', $product_brand);
				$all_m_id = "'" . implode("','", $myArray) . "'";
				$product_brand = $this->custom_model->get_data_array("SELECT id,product_name ,product_image, price,sale_price,storeprice,stock_status,color , product_brand,insurance FROM  `product` WHERE category = $category_id AND product_brand IN ($all_m_id)  AND status =  '1' AND  price BETWEEN '$min_price' AND '$max_price' ");
				// echo "<pre>";
				// print_r($product_brand);
				// die;
				if (!empty($product_brand))
				{
					foreach ($product_brand as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
       	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
    					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
    
    					$product_brand[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
    					
						$product_brand[$rkey]['product_image'] = $this->get_product_path($product_brand[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "product_brand" => $product_brand , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
			}
			elseif (!empty($diag_code))
			{
				$myArray = explode(',', $diag_code);
				$all_m_id = "'" . implode("','", $myArray) . "'";
				$all_m_id1 = "" . implode("','", $myArray) . "";

				
				$diag_code = $this->custom_model->get_data_array("SELECT id,product_name ,product_image, price,sale_price,storeprice,stock_status,color,insurance , diagnosis_code FROM  `product` WHERE category = $category_id AND  status =  '1' AND  diagnosis_code IN ($all_m_id)  OR  diagnosis_code  LIKE '%$all_m_id1%' AND  price BETWEEN '$min_price' AND '$max_price' ");

				// echo $this->db->last_query();
				// echo "<pre>";
				// print_r($diag_code);
				// die;
				if (!empty($diag_code))
				{
					foreach ($diag_code as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
       	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
    					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
    
    					$diag_code[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
    					
						$diag_code[$rkey]['product_image'] = $this->get_product_path($diag_code[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "diag_code" => $diag_code , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
			}
			elseif (!empty($product_brand) && !empty($product_color))
			{
				$myArray = explode(',', $product_brand);
				$all_m_id = "'" . implode("','", $myArray) . "'";

				$product_brand = $this->custom_model->get_data_array("SELECT id,product_name ,product_image, price,sale_price,storeprice,stock_status,color,insurance , product_brand FROM  `product` WHERE category = $category_id AND product_brand IN ($all_m_id)  AND STATUS =  '1'  AND  color  LIKE '%$product_color%' AND  price BETWEEN '$min_price' AND '$max_price' ");

				// echo "<pre>";
				// print_r("SELECT id,product_name ,product_image, price,stock_status,color , product_brand FROM  `product` WHERE category = $category_id AND product_brand IN ($all_m_id)  AND STATUS =  '1' AND stock_status =  'instock' AND  color  LIKE '%$product_color%' AND  price BETWEEN '$min_price' AND '$max_price' ");
				// die;
				if (!empty($product_brand))
				{
					foreach ($product_brand as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
       	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
    					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
    
    					$product_brand[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
    					
						$product_brand[$rkey]['product_image'] = $this->get_product_path($product_brand[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "product_brand" => $product_brand , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
			}
			elseif (empty($product_brand) && empty($product_color) && !empty($max_price) && !empty($min_price))
			{
				$myArray = explode(',', $product_brand);
				$all_m_id = "'" . implode("','", $myArray) . "'";
				$product_brand = $this->custom_model->get_data_array("SELECT id,insurance,product_name ,product_image, price,sale_price,storeprice,stock_status,color , product_brand FROM  `product` WHERE category = $category_id AND  STATUS =  '1'  AND  price BETWEEN '$min_price' AND '$max_price' ");
				// echo "<pre>";
				// print_r($product_brand);
				// die;
				if (!empty($product_brand))
				{
					foreach ($product_brand as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
					    if(empty($guest))
					    {
					        $wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
        					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
        
        					$product_brand[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;    
					    }
       	 				
					
						$product_brand[$rkey]['product_image'] = $this->get_product_path($product_brand[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "product_brand" => $product_brand , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
			}
			elseif (empty($product_brand) && !empty($product_color) && !empty($max_price) && !empty($min_price))
			{
				$myArray = explode(',', $product_brand);
				$all_m_id = "'" . implode("','", $myArray) . "'";
				
				
                $p_color = explode(',', $product_color);
                
               
                    
                if($p_color)
                {
                    $i = 0;
                    $len = count($p_color);
                    
                    $coloor = '';
                    
                    foreach ($p_color as $ckey => $cvalue)
                    {
                        if ($i == 0) 
                        {
                            $a =  "color  LIKE '%$cvalue%'  ";
                        }
                        else if ($i == $len - 1) 
                        {
                            $a =  " color  LIKE '%$cvalue%' ";
                        }
                        else{
                            $a =  " color  LIKE '%$cvalue%' ";    
                        }
                        
                        if ($i != $len - 1) 
                        {
                            $a = $a.' OR ';
                        }
                        
                        // …
                        $i++;
                        
                       
                        
                        $coloor = $coloor.$a ; 
                    }
                    
                    
                }

    
				
				
				$product_brand = $this->custom_model->get_data_array("SELECT insurance,id,product_name ,product_image, price,sale_price,storeprice,stock_status,color , product_brand FROM  `product` WHERE category = $category_id AND  STATUS =  '1' AND  ($coloor)  AND  price BETWEEN '$min_price' AND '$max_price' ");
			    
			 //   echo $this->db->last_query();
			 //   echo "<br>";
			    
				// echo "<pre>";
				// print_r($product_color);
				// die;
				
				if (!empty($product_brand))
				{
					foreach ($product_brand as $rkey => $rdvalue)
					{
					    $product_id = $rdvalue['id'];
       	 				$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => @$user_id,'meta_key' => 'wish_list'));
    
    					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
    
    					$product_brand[$rkey]['is_in_wish_list'] = !empty($my_wish) && in_array($product_id, $my_wish)? true:false;
    					
    					
						$product_brand[$rkey]['product_image'] = $this->get_product_path($product_brand[$rkey]['product_image']);
					}

					echo json_encode( array("status" => true ,"ws" => $ws , "product_brand" => $product_brand , "message" => "Successfully .") );die;
				}
				else{
					echo json_encode( array("status" => false ,"ws" => $ws , "message" => "no record found .") );die;
				}
			}
			
			echo json_encode( array("status" => true ,"ws" => $ws ,"brands" => $brand_info, "color" => $color , "price" => $price , "message" => "Successfully .") );die;
		}
	}

	public function get_vendor_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/seller_img/'.$image;
			return $str;
		}
   	}
	

	public function this_product_data($pid,$language = 'en')
	{
		$curr = $this->custom_model->my_where('product','*',array('id'=>$pid));
		$shipping = 0;
		$deliveryin = $this->custom_model->get_admin_option("default_delivery_day");
		if (empty($curr))
		{
			return false;
		}

		$curr1 = $this->custom_model->my_where('admin_users','first_name as vendor_name',array('id'=>$curr[0]['seller_id']));
		$curr2 = $this->custom_model->get_vender_value($curr[0]['seller_id']);
		if(isset($curr2['deliveryin']) && !empty($curr2['deliveryin'])){
			$curr1[0]['deliveryin'] = $curr2['deliveryin'];
		}else{
			$curr1[0]['deliveryin'] = $deliveryin;
		}
		if(isset($curr2['shipping']) && !empty($curr2['shipping'])){
			$curr1[0]['shipping'] = $curr2['shipping'];
		}else{
			$curr1[0]['shipping'] = $shipping;
		}
	 		if ($language != 'en')
	 		{
	 			$res = $this->custom_model->my_where("product_trans","*",array('id' => $curr[0]['id']) );
	 			if (!empty($res))
	 			{
	   	 			$curr[0]['product_name'] = $res[0]['product_name'];
	   	 			$curr[0]['description'] = $res[0]['description'];
	   	 			$curr[0]['product_brand'] = $res[0]['product_brand'];
	 			}

	 			$res1 = $this->custom_model->my_where("admin_users_trans","first_name as vendor_name",array('id' => $curr[0]['seller_id']) );
	 			if (!empty($res1))
	 			{
	   	 			$curr1[0]['vendor_name'] = $res1[0]['vendor_name'];
	 			}
	 			
	 		}
	 		unset($curr[0]['description']);
			unset($curr[0]['user_like']);
			unset($curr[0]['product_code']);
			unset($curr[0]['created_date']);
			$curr[0]['product_image'] = $this->get_product_path($curr[0]['product_image']);
			$curr[0]['slug'] = $curr1[0]['vendor_name'];
		return array('curr' => $curr[0], 'curr1' => $curr1[0]);
   	}

   
   	public function check_user_login($language = 'en',$ws)
	{
		$token1 = $this->getBearerToken();
	    $Jwt_client = new Jwt_client(); 
	    $token = $Jwt_client->decode($token1);

	    if($token)
	    {
	    	$aData = array();
	    	$id = @$token['id'];
	    	$password = @$token['password'];
	    	// $this->logout();
	    	$logged_in = $this->custom_model->my_where('users','password,token',array('id'=>$id),array(),"","","","", array(), "",array(),false );
	    	
	    	if (!empty($logged_in))
   	 		{
   	 			if(password_verify ( $password ,$logged_in[0]['password'] ))
				{
					if ($logged_in[0]['token'] == $token1) {
						return $id;
					}
				}
				elseif ($password == $logged_in[0]['password'] )
				{
				    if ($logged_in[0]['token'] == $token1) {
						return $id;
					}
				}
   	 		}
   	 	}

   	 	echo json_encode( array("status" => false,"message" => ($language == 'ar'? "مصادقة غير صالحة.":'Invalid authentication.' ),  "language"=> $language , "ws" => $ws ) );die;
   	}

	/** 
	 * Get hearder Authorization
	 * */

	function getAuthorizationHeader()
	{
        $headers = null;
        if (isset($_SERVER['Token'])) {
            $headers = trim($_SERVER["Token"]);
        }
        else if (isset($_SERVER['HTTP_TOKEN'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_TOKEN"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Token'])) {
                $headers = trim($requestHeaders['Token']);
            }
        }
        return $headers;
	}


	/**
	 * get access token from header
	 * */
	function getBearerToken() {
	   $headers = $this->getAuthorizationHeader();
	    // HEADER: Get the access token from the header
	    if (!empty($headers)) {
	        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	            return trim($matches[1]);
	        }
	    }
	    return null;
	}


	/*
	 * insurance image path
	*/
	public function validate_token($language = 'en',$ws='')
	{
		$uid = 0;
		$token = $this->getBearerToken();
		// print_r($token); die;
   	    $Jwt_client = new Jwt_client();
   	    $token = $Jwt_client->decode($token);
   	    if($token){
   	       if(@$token['api_key'] != $this->token_id ){
   	       		$uid = $this->check_user_login($language,$ws);
   	       }
   	    }else{
   	        $uid = $this->check_user_login($language,$ws);
   	    }

   	    return $uid;
   	}

	/**
	 * logout user if login
	 * */
	function logout()
	{
	    if($this->ion_auth->logged_in())
	    {
	        $this->ion_auth->logout();
	    }
	}
	
	
	
	public function verify_otp()
	{
   	    $Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');

		//$json  = '{"email":"vishal@appristine.in", "address":"Kolhapur Mahadik Vasahat" , "password":"123123","first_name": "Vk","mobile":"+918551995731", "otp":"0990","source":"Android", "city":"Kolhapur","invite_code":"" , "language":"en"}';

		$jsonobj 		= json_decode($json);
		$first_name 	= @$jsonobj->first_name;
		$email 			= @$jsonobj->email;
		$username 		= $email;
		$mobile 		= @$jsonobj->mobile;
		$address 		= @$jsonobj->address;
		$lat 	    	= @$jsonobj->lat;
		$lng     		= @$jsonobj->lng;
		$password 		= @$jsonobj->password;
		$source 		= @$jsonobj->source;
		$social 		= @$jsonobj->social;

		$otp 			= @$jsonobj->otp;

		$group_id 		= @$jsonobj->group_id;
        $group_id 		= empty($group_id)? 9:$group_id;
        $social 		= empty($social)? 'normal':$social;

        $invite_code 	= @$jsonobj->invite_code;

        $language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'verify_otp':$ws;

		$user_id = $this->validate_token($language , $ws);

		date_default_timezone_set('Asia/Kolkata');
        $created_on = date("Y/m/d h:i:s");

        // print_r($language); die;

        if (!empty($mobile) && !empty($otp))
		{
			$check = $this->custom_model->get_data_array("SELECT *  FROM otp_verify WHERE phone LIKE '%$mobile%' AND `otp` = $otp ");

			if (empty($check))
			{
				$response['status'] = false;
				$response['ws'] = $ws;
				$response['message'] = 'Please enter valid OTP.';
				echo json_encode($response);die;
			}


			$additional_data = $response = array();
			if(!empty($country_code)) $additional_data['country_code'] = $country_code;
			if(!empty($first_name)) $additional_data['first_name'] = $first_name;
			if(!empty($mobile)) $additional_data['phone'] = $mobile;
			if(!empty($email)) $additional_data['username'] = $email;
			if(!empty($email)) $additional_data['email'] = $email;
	        if(!empty($source)) $additional_data['source'] = $source;
	        if(!empty($address)) $additional_data['address_1'] = $address;
	        if(!empty($social)) $additional_data['social'] = $social;
	        if(!empty($created_on)) $additional_data['created_on'] = $created_on;
	     	// if(!empty($lat)) $additional_data['lat'] = $lat;
    		// if(!empty($lng)) $additional_data['lng'] = $lng;
    		if(!empty($invite_code)) $additional_data['invite_code'] = $invite_code;
    		if(!empty($language)) $additional_data['language'] = $language;
			if(!empty($password)) $additional_data['password'] = password_hash($password, PASSWORD_BCRYPT);
	        $additional_data['active'] = 1;
	       // $additional_data['group_id'] = $group_id;

	        //print_r($additional_data);
	        //echo $mobile;
	        //die;
			$query = $this->create_member1($additional_data);

			if($query == 'email')
			{
				$response['status'] = false;
				$response['message'] = 'Email already exists';
				echo json_encode($response);die;	
			}
			elseif($query == 'phone')
			{
				$response['status'] = false;
				$response['message'] = 'Phone number already exists';
				echo json_encode($response);die;
			}
			elseif($query == 'invite_code')
			{
				$response['status'] = false;
				$response['message'] = 'Invite code Is Invalid';
				echo json_encode($response);die;	
			}			
			else
			{			
				// echo "<pre>";
				// print_r($ref_user); die;

				$user1 = $this->custom_model->my_where('users','*',array('phone' => $mobile),array(),"","","","", array(), "",array(),false );

				if (!empty($user1))
				{
					$myStr = $user1['0']['first_name'];
					$result = substr($myStr, 0, 4);
					$generate_ref = lcfirst($result).$user1['0']['id'];

					// echo "<pre>";
					// print_r($generate_ref); die;

					$this->custom_model->my_update(['own_refere_id' => $generate_ref], ['id' => $user1['0']['id']], 'users');
				}

				if (!empty($invite_code)) 
				 {
					 $ref_user = $this->custom_model->my_where('users','*',array('own_refere_id' => $invite_code));
				 }

				if (!empty($ref_user)){
					$count = $ref_user[0]['refer_count'];
					$total_c = $count + 1 ;
					$this->custom_model->my_update(['refer_count' => $total_c], ['own_refere_id' => $invite_code], 'users');
					$from_id = $ref_user[0]['id'];
					$to_id   = $user1['0']['id'];
					date_default_timezone_set('Asia/Kolkata');
					$date  = date("Y/m/d h:i:s");
					$this->custom_model->my_insert(['from_id' => $from_id ,'to_id' => $to_id,'date' => $date ],'referal');

				}

				$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user1[0]['id'] ) );

				$this->custom_model->my_update(['token' => $response["token"]], ['id' => $user1['0']['id']], 'users');

				$user = $this->custom_model->my_where('users','*',array('phone' => $mobile),array(),"","","","", array(), "",array(),false );

				//$get_otp = $this->custom_model->my_where("otp_verify","*",array('phone' => $mobile ),array(),"id","DESC");

				/*if (!isset($get_otp[0]['otp']))
				{
				    $rand_no = mt_rand(1000, 9999);
				     $this->custom_model->my_insert(array('phone' => $mobile,'otp'=>$rand_no ),"otp_verify");
				}*/
				
				
				$rand_no =  $this->custom_model->my_update(['status' => 'active' ], ['phone' => $mobile], 'otp_verify');
				


				//$message = 'Please use OTP '.$rand_no.' to verify your mobile number.Thank you for using MSM';

				//echo "string";

				//$this->load->library('twilio');
				//$sms = $this->twilio->send_sms($mobile,$message);

				//print_r($sms);
				//die;
				

				// echo "<pre>";
				// print_r($user); die;

				$admin_users_groups = $this->db->insert('admin_users_groups',array( "user_id" => $query,"group_id" => 5 ));

				$password = $user[0]['password'];
				unset($user[0]['password']);
				unset($user[0]['salt']);
				unset($user[0]['ip_address']);
				unset($user[0]['activation_code']);
				unset($user[0]['forgotten_password_code']);
				unset($user[0]['forgotten_password_time']);
				unset($user[0]['remember_code']);
				// $response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user[0]['id'] ) );
				$response['status'] = true;
				$response["user"] = $user[0];
				
				/*$message = '<h6 style="font-size: 15px; margin-top: -10px;"> Hi '.$first_name.' !,</6><br/>
					<p style="font-size: 12px; color:#696969;">Thank you for creating a Tikram account. </p> 
					<p style="font-size: 12px; color:#696969;"> Contact Details:- admin@meidcalsupply.com </p>';

	        	$emails = $email.",admin@medicalsupply.com";
				$subject = "Welcome to Tikram";
				send_email($emails,$subject,$message);*/
				$response['status'] = true;
				$response['message'] = 'Account Successfully Created...';
				echo json_encode($response);die;
			}
		}
		else{
			$response['status'] = false;
			$response['message'] = 'All fields are required.';
			echo json_encode($response);die;
		}
	}


	public function login()
	{
		
   	    $Jwt_client = new Jwt_client();

		$json 		= file_get_contents('php://input');
	    //$json 		= '{"email":"karandevishal455@gmail.com","password":"123123", "language":"en" , "source":"web" }';
		$jsonobj 	= json_decode($json);
		$password 	= @$jsonobj->password;
		$email 		= @$jsonobj->email;
		// $type 		= @$jsonobj->type;
		$source 	= @$jsonobj->source;
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'login':$ws;
		$source 	= empty($source)? 'normal':$source;

		$user_id = $this->validate_token($language , $ws);

		if (empty($email) || empty($password)  || empty($source)) {
			echo json_encode(array("status" => false,"message" => ($language == 'ar'? 'كل الحقول مطلوبة.':'All fields are required.') ));
			die;
		}

		$logged_in = $this->ion_auth->user_login($email, $password, FALSE);

		// result
		if ($logged_in == 'error') {
            echo json_encode(array("status" => false,"message" => ('account deactive by Admin Kindly Contact Admin Section.') ));
            
		}
		elseif ($logged_in == 'error1') {
            echo json_encode(array("status" => false,"message" => ('you cant login as a '.$type.'') ));
            
		}
		elseif ($logged_in == 'password') {
            echo json_encode(array("status" => false,"message" => ('Please enter correct password') ));
		}
		else if ($logged_in)
		{

			$user = $logged_in;
			$user_id = $user[0]->id;
			$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user_id ) );
			$this->custom_model->my_update(array("language" => $language,"source" =>$source , "token"=> $response["token"] ),array("id" => $user_id),"users");

			$u_details = $this->custom_model->get_data("SELECT * FROM users WHERE id = $user_id  ORDER BY 'id' DESC");
			// echo "<pre>";
			// print_r($u_details);
			// die;
			// $response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $u_details[0]->id ) );

			unset($u_details[0]->password);
			unset($u_details[0]->salt);
			unset($u_details[0]->ip_address);
			unset($u_details[0]->activation_code);
			unset($u_details[0]->forgotten_password_code);
			unset($u_details[0]->forgotten_password_time);
			unset($u_details[0]->remember_code); 
			// TODO: append API key

			// print_r($response['token']); die;
			$response['status'] = true;
            $u_details[0]->logo = $this->get_profile_path($u_details[0]->logo);
            
            if ($language == 'ar') {
				$response['message'] = 'تسجيل الدخول بنجاح';
			}
			else{
				$response['message'] = 'Login Successfully';
			}

			$response["user"] = $u_details;
			echo json_encode( $response );
			// echo "<pre>";
			// print_r($response);

		}
		else
		{
			echo json_encode(array("status" => false,"message" => ($language == 'ar'? 'تسجيل الدخول غير صحيح.':'Please enter correct email') ));
		}
		
		die;
	}


	function create_member1($new_member_insert_data)
	{
		$this->db->where('username', $new_member_insert_data['username']);
		$query = $this->db->get('users')->result();

		if (!empty($new_member_insert_data['invite_code']))
		{
			$check = $this->custom_model->record_count('users', ['own_refere_id' => $new_member_insert_data['invite_code']]);
			// print_r($check); die;
			if (empty($check))
			{
				return 'invite_code';
			}
		}

        if(!empty($query)){ 
        	return 'email';
		}else{
  			
			$this->db->where('phone', $new_member_insert_data['phone']);
			$query = $this->db->get('users')->result();

	        if(!empty($query)){
	        	return 'phone';
			}
			else
			{

				$insert = $this->db->insert('users', $new_member_insert_data);
			    return $this->db->insert_id();
			}
		}
	}

	public function get_profile_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/usersdata/'.$image;
			return $str;
		}
   	}


   	public function profile_info()
	{
		$json = file_get_contents('php://input');
		// $user_id = 642;
	    // $json 		= '{"logo":"dfs","first_name":"Girish B","email":"girishbhumkar5@rediffmail.com","phone":"12312311","address_1":"Baner Pune 123123" , "language":"en","city":"pune","country":"India"}';
		
		$jsonobj 	= json_decode($json);
		$first_name 	= @$jsonobj->first_name;
		$logo 			= @$jsonobj->logo;
		$email 			= @$jsonobj->email;
		$phone 			= @$jsonobj->phone;

		$address_1 		= @$jsonobj->address_1;
		$city 			= @$jsonobj->city;
		$country 		= @$jsonobj->country;

		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'profile_info':$ws;

		$user_id = $this->validate_token($language , $ws);
		
		$type 	= @$jsonobj->type;
   	 	$response = array();

   	 	if (!empty($user_id))
   	 	{
			$user_check = $this->custom_model->my_where("users","*",array("id =" => $user_id),array(),"","","","", array(), "",array(),false  );
			if (empty($user_check))
			{
				echo json_encode( array("status" => false,"message" => 'User not found'));die;
			}
			// $password =password_hash($password, PASSWORD_BCRYPT);
			$phone_check = $this->custom_model->my_where("users","*",array("phone" => $phone, "id !=" => $user_id),array(),"","","","", array(), "",array(),false  );

			if (!empty($phone_check))
			{
				echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'رقم الهاتف موجود بالفعل':'Phone number already exists')) );die;
			}

			$email_check = $this->custom_model->my_where("users","*",array("email" => $email,"id !=" => $user_id),array(),"","","","", array(), "",array(),false  );
			
			if (!empty($email_check))
			{
				echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'البريد الالكتروني موجود بالفعل':'Email already exists')) );die;
			}

			$additional_data = $response = array();

			if(!empty($first_name)) $additional_data['first_name'] 			= $first_name;
			if(!empty($mobile)) $additional_data['phone'] 					= $mobile;
			if(!empty($email)) $additional_data['username'] 				= $email;
			if(!empty($email)) $additional_data['email'] 					= $email;
	        if(!empty($address_1)) $additional_data['address_1'] 			= $address_1;
	        if(!empty($city)) $additional_data['city'] 						= $city;
	        if(!empty($country)) $additional_data['country'] 				= $country;

	        $result = $this->custom_model->my_update($additional_data,array("id" => $user_id),"users");

	        // print_r($result); die;
			// $this->custom_model->my_update(array("first_name" => $first_name,"logo" => $logo,"username" => $email,"email" => $email,"phone" => $phone),array("id" => $user_id),"users" );

			$response["message"] = ($language == 'ar'? 'تم تحديث الملف الشخصي بنجاح.':'Profile updated successfully.');
		

			$data = $this->custom_model->my_where("users"," id,email,phone,first_name, logo,address_1,city,country",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );
			//print_r($data);
			$data[0]['logo'] = $this->get_profile_path($data[0]['logo']);
			$response["status"] = true;
			$response["data"] = $data[0];
			echo json_encode( $response );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}


   	public function change_pass()
	{
		$json = file_get_contents('php://input');

		// $json 		= '{"password":"123123","old_password":"123456"}';
		// $user_id = 642;
		$jsonobj 	= json_decode($json);
		$user_id 			= @$user_id;
		$password 			= @$jsonobj->password;
		$current_password 	= @$jsonobj->old_password;

		$language 			= @$jsonobj->language;
		$language 			= empty($language)? 'en':$language;
		$ws 				= empty($ws)? 'change_password':$ws;

		$user_id = $this->check_user_login($language , $ws);

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,  "ws" => $ws,"message" => 'Invalid request') );die;
   	 	}
   	 	if(empty($password) || strlen($password) > 35 ){
	    	echo json_encode( array("status" => false,  "ws" => $ws,"message" => 'Please enter valid password.') );die;
	    }
		if (empty($password) && strlen($password) < 6 ){
			echo json_encode(array("status" => false, "ws" => $ws, "message" => "Please enter password atleast 6 character") ); die;
		}

		$logged_in = $this->custom_model->my_where('users','password',array('id'=>$user_id),array(),"","","","", array(), "",array(),false );
	    // print_r($logged_in); die;

    	if (!empty($logged_in))
	 	{
	 		if(password_verify ( $current_password ,$logged_in[0]['password'] ))
			{
				$password =password_hash($password, PASSWORD_BCRYPT);
				$this->custom_model->my_update(array("password" => $password),array("id" => $user_id),"users" );
				echo json_encode( array("status" => true,"message" => 'Password Changed.' , "ws"=> $ws) );die;
			}
			else{
				echo json_encode( array("status" => false, "ws" => $ws,"message" => 'Please enter valid old password') );die;
			}
	 	}else{
	 	    echo json_encode( array("status" => false, "ws" => $ws, "message" => 'User Not Exists. ') );die;
	 	}	 	
   	}

	public function forgetpass()
	{
		$json = file_get_contents('php://input');
		//$json 		= '{"string":"girishbhumkar5@rediffmail.com"}';
		$jsonobj 	= json_decode($json);
		$string 	= @$jsonobj->string;
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'forget password':$ws;
		// $user_id = $this->validate_token($language , $ws);		

   	 	if (empty($string)) {
   	 		echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'الرجاء إدخال عنوان البريد الإلكتروني أو رقم الهاتف.':'Please enter email address .')) );die;
   	 	}
   	 	else
   	 	{
			$this->load->model('User_model');
   	 		$datas = $this->User_model->forget_password($string);
			if($datas)
			{
			    $this->load->model('User_model');
   	 		    $datas = $this->User_model->forget_password($string);
   	 		
			    /*if ($datas->social == 'facebook' || $datas->social =='gmail') {
					echo json_encode( array("status" => false,"message" =>' You can\'t change password. Beacuse you are login through social') );die;
				}*/
				// echo "<pre>";
				// print_r($datas);
				// die;

				$name = $datas->first_name;
				$email = $datas->username;
				$link = base_url()."Login/resetpassword/".en_de_crypt($datas->id)."/".$datas->forgotten_password_code;

				$message = forgetpass_content($name,$link);
				$emails = $email;
				$subject = "Test Forget Password Link.";
				send_email($emails,$subject,$message);
				echo json_encode( array("status" => true, "ws" => $ws, "message" => ($language == 'ar'? 'يرجى التحقق من بريدك الإلكتروني لإعادة تعيين كلمة المرور.':'Please check your email to reset your password.')) );die;
   	 		}
   	 		else{
   	 			echo json_encode( array("status" => false, "ws" => $ws, "message" => ($language == 'ar'? 'لم يتم العثور على رقم البريد الإلكتروني / الهاتف! الرجاء إدخال بريد إلكتروني أو رقم هاتف صالح.':'Email address was not found. Please enter a valid email address or register for a new account.')) );die;
   	 		}

   	 	}
		echo json_encode( array("status" => false, "ws" => $ws, "message" => ($language == 'ar'? 'هناك خطأ ما. يرجى الاتصال بالمسؤول.':'Something went wrong. Please contact admin.')) );die;
   	}
	
	
    
    public function home_page_data()
	{
		$json = file_get_contents('php://input');
// 		$json 		= '{"category":"1" }';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'home_page_data':$ws;
		// $category 	= @$jsonobj->category;
// 		$user_id = 1;
		$user_id = $this->validate_token($language ,$ws);

   	 	if (!empty($user_id))
   	 	{
   	 		$female_data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,status FROM product WHERE category = '2' ORDER BY RAND() LIMIT 10;");
   	 		if($language != "en")
   	 		{
				$female_data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,status FROM product_trans WHERE category = '2' ORDER BY RAND() LIMIT 10;");
			}

   	 		// echo "<pre>";
   	 		// print_r($female_data);
   	 		// die;
   	 		if ($female_data)
   	 		{
   	 			foreach ($female_data as $key => $value)
   	 			{
   	 				$female_data[$key]['product_image'] = $this->get_product_path($value['product_image']);
   	 			}
   	 		}

   	 		$male_data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,status FROM product WHERE category = '1' ORDER BY RAND() LIMIT 10;");

   	 		if($language != "en")
   	 		{
				$male_data = $this->custom_model->get_data_array("SELECT id,product_name,category,description,price,stock_status,product_image,status FROM product_trans WHERE category = '1' ORDER BY RAND() LIMIT 10;");
			}

 			if (!empty($male_data))
 			{
 				foreach ($male_data as $qkey => $qvalue)
	 			{
	 				$male_data[$qkey]['product_image'] = $this->get_product_path($qvalue['product_image']);
	 			}
 			}

 			$banner1 = $this->custom_model->get_data_array("SELECT * FROM banner_first  ORDER BY RAND() ;");
 			if (!empty($banner1))
 			{
 				foreach ($banner1 as $iakey => $iavalue)
	 			{
	 				$banner1[$iakey]['english_image'] = $this->get_banner_path($iavalue['english_image']);
	 				$banner1[$iakey]['arebic_image'] = $this->get_banner_path($iavalue['arebic_image']);
	 			}
 			}
 			
 			// echo "<pre>";
 			// print_r($banner1);
 			// die;


 			$banner2 = $this->custom_model->get_data_array("SELECT * FROM banner_second  ORDER BY RAND() ");

 			if (!empty($banner2))
 			{
 				foreach ($banner2 as $akey => $avalue)
	 			{
	 				$banner2[$akey]['english_image'] = $this->get_banner_path($avalue['english_image']);
	 				$banner2[$akey]['arebic_image'] = $this->get_banner_path($avalue['arebic_image']);
	 			}
 			}


   	 		echo json_encode(array("status" => true, "message" => ($language == 'ar'? ' بنجاح .':'Successfully') , "female_data" => @$female_data ,"male_data" => @$male_data ,"banner1" => $banner1 ,"banner2" => $banner2)); die;   	 		
 		}
 		else
 		{
 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
		
		die;
	}
	
	

	public function get_banner_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/images/'.$image;
			return $str;
		}
   	}
	
	public function get_product_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/products/'.$image;
			return $str;
		}
   	}
    
    
    public function category_list() 
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"language":"ar","pagination":"1" }';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'category_list':$ws;
		$category 	= @$jsonobj->category;
		$pagination 	= @$jsonobj->pagination;
		// $user_id = 1;
		$user_id = $this->validate_token($language ,$ws);
		$string 	= @$jsonobj->string;
        
        //     	echo "<pre>";
        // 		print_r($user_id);
        // 		die;
        		 		
   	 	if (isset($user_id))
   	 	{
   	 		if ($language == 'en') {
			$cat_table  = 'category';
			}elseif ($language == 'es') {
			$cat_table  = 'category_trans';		    	
			}

   	 		if (!empty($string))
   	 		{
   	 			if ($language != 'en')
	 			{
	 				$data = $this->custom_model->get_data_array("SELECT id,display_name,image FROM category_trans WHERE status = 'active' AND display_name LIKE '%$string%' ");
	 			}
	 			else{
	 				$data = $this->custom_model->get_data_array("SELECT id,display_name,image FROM category WHERE status = 'active' AND display_name LIKE '%$string%' ");
	 			}

	 			if (!empty($data))
	 			{
	 				foreach ($data as $key => $value)
	   	 			{
	   	 				$data[$key]['image'] = $this->get_category_path($value['image']);
	   	 			}
	   	 			echo json_encode(array("status" => true,"data" => $data,"ws" => $ws ,"message" => ($language == 'ar'? 'بنجاح.':'Successfully') )); die;
	 			}
	 			else{
	 				echo json_encode(array("status" => true,"ws" => $ws ,"message" => ($language == 'ar'? 'بنجاح.':'No record found') )); die;
	 			}
   	 		}
   	 		
   	 		/* New pagination code */
   	 		if($pagination == "all"){

		    $data = $this->custom_model->get_data_array("SELECT id,display_name,image FROM $cat_table WHERE status = 'active' ");
		    //$data1 = $this->custom_model->get_data_array("SELECT COUNT(id) AS count FROM $cat_table WHERE status = 'active' ");

	 		}else{

	 			if(empty($pagination)) $pagination = 1;
				$limit = 10;
				$pagination = $limit * ( $pagination - 1);
				$data = $this->custom_model->get_data_array("SELECT id,display_name,image FROM $cat_table WHERE status = 'active' LIMIT $pagination,$limit");
				//$data1 = $this->custom_model->get_data_array("SELECT COUNT(id) AS count FROM $cat_table WHERE status = 'active' LIMIT $pagination,$limit ");
	 		}
   	 		/* End */ 

   	 		//$data =  $this->custom_model->my_where('category','id,display_name,image',array('status' => 'active'));
   	 		$count_user = $this->custom_model->get_data_array("SELECT COUNT(id) as user FROM category WHERE status = 'active'");
   	 		$count = $count_user[0]['user'];

   	 		if ($language != 'en')
	 		{
	 			if (!empty($data))
	 			{
	 				foreach ($data as $dkey => $dvalue)
	 				{
	 					$datat = $this->custom_model->my_where("category_trans","id,display_name,image",array("status" => 'active', 'id' => $dvalue['id'] ) );
						if(isset($datat[0]['image']) && !empty($datat[0]['image']))
						{
							$data[$dkey]['image'] = $datat[0]['image'];
							$data[$dkey]['display_name'] = $datat[0]['display_name'];
						}
	 				}
	 			}	 			
	 		}
	 		
   	 		if ($data)
   	 		{
   	 			foreach ($data as $key => $value)
   	 			{
   	 				$data[$key]['image'] = $this->get_category_path($value['image']);
   	 			}

   	 			// echo "<pre>";
		 		// print_r($user_id);
		 		// die;

   	 			echo json_encode(array("status" => true,"count" => $count,"data" => $data,"ws" => $ws ,"message" => ($language == 'ar'? 'بنجاح.':'Successfully') )); die;
			}
   	 		else
   	 		{
   	 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
   	 		}
 		}
 		else
 		{
 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
	}


	public function get_category_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/frontend/images/home/'.$image;
			return $str;
		}
   	}


   	public function get_pages()
	{
		$json = file_get_contents('php://input');
	 //	$json 		= '{"slug":"contact-us","language":"ar"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;

		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'get_pages':$ws;


		$user_id = $this->validate_token($language ,$ws);

   	 	$response = array();
 		$data = $this->custom_model->my_where("pages","*",array("status" => 'active' ,'slug' => $slug) );
 		if($language != "en"){
 			$datat = $this->custom_model->my_where("pages_trans","*",array('id' => $data[0]['id'] ) );
 			if(isset($datat[0]['title']) && !empty($datat[0]['title'])){
 				$data[0]['title'] = $datat[0]['title'];
 			}
 			if(isset($datat[0]['editor']) && !empty($datat[0]['editor'])){
 				$data[0]['editor'] = $datat[0]['editor'];
 			}
 		}

 		// echo "<pre>";
 		// print_r($data);
 		// die;
 		

   	 	if(isset($data[0])){
   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data[0]) );die;
   	 	}else{
   	 		echo json_encode( array("status" => false,"ws"=>$ws ,"message" => 'Something went wrong.') );die;
   	 	}
   	}

   	/* Shipping charges */
   	public function get_shipping()
	{
		$json = file_get_contents('php://input');
	 	//$json 		= '{"slug":"contact-us","language":"ar"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;

		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'get_shipping':$ws;

		//$user_id = 1060;
		$user_id = $this->validate_token($language ,$ws);

   	 	$response = array();
 		$data = $this->custom_model->my_where("shippingcharge","*");
 
   	 	if($data){

   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data) );die;
   	 	 }
   	 	
   	 	else
   	 	{
   	 		echo json_encode( array("status" => false,"ws"=>$ws ,"message" => 'Something went wrong.') );die;
   	 	}
   	}
   	/* End */

   	/* Notification 01-02-2019 */

   	public function get_notification()
	{
		$json = file_get_contents('php://input');
	 	//$json 		= '{"user_id":"1280","language":"ar"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;

		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'get_notification':$ws;

		//$user_id = 1280;
		$user_id = $this->validate_token($language ,$ws);

 		$data = $this->custom_model->my_where("user_notification","*",array("user_id" => $user_id));
 
   	 	if($data)
   	 	{

   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data) );die;
   	 	 }
   	 	
   	 	else
   	 	{
   	 		echo json_encode( array("status" => false,"ws"=>$ws ,"message" => 'Something went wrong.') );die;
   	 	}
   	}


   	/* End */

   	public function order_tracking()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"language":"ar" }';
		$jsonobj 	= json_decode($json);
		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'order_tracking':$ws;
		$category 	= @$jsonobj->category;
		 //$user_id = 1144;
		$user_id = $this->validate_token($language ,$ws);

   	 	if (!empty($user_id))
   	 	{
   	 		
   	 		$data = $this->custom_model->my_where("order_master","order_status,display_order_id,order_master_id,delivery_date,order_datetime,order_comment,address,address_1,address_2,city,state,name,mobile_no,email,order_type",array("customer_id" => $user_id),array(),"order_master_id","DESC" );
			
			if (!empty($data))
			{
				foreach ($data as $key => $value)
				{
					$items = $this->custom_model->my_where("order_items","product_id,seller_id,quantity,price,commission,attribute,order_status,order_comment",array("order_no" => $value['order_master_id']) );

					foreach ($items as $k => $val)
					{
						
						$item_info = $this->custom_model->my_where("product","id,product_name,product_image,insurance",array("id" => $val['product_id']) );

						@$item_info[0]['product_image'] = $this->get_product_path($item_info[0]['product_image']);
						@$val['attribute'] = ($val['attribute'] != '[]')? json_decode($val['attribute']):new stdClass();
						@$data[$key]['items'][$k] = array_merge($val,$item_info);
					}
				}

				// echo "<pre>";
				// print_r($data);
				// die;

				echo json_encode(array("status" => true, "ws" => $ws , "data" => $data ,"message" => ($language == 'ar'? 'بنجاح.':'Successfully') )); die;
			}
			else{
				echo json_encode(array("status" => false , "ws" => $ws , "message" => ($language == 'ar'? 'لا يوجد طلب حتى الآن!':'No order yet ! ') )); die;
			}
 		}
 		else
 		{
 			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
	}


	public function order_tracking_details()
	{
		$json = file_get_contents('php://input');
		 //$json 				= '{"display_order_id":"20190109093112750" }';
		$jsonobj 			= json_decode($json);
		$display_order_id 	= @$jsonobj->display_order_id;
		$language 			= @$jsonobj->language;
		$ws 				= @$jsonobj->ws;
		$language 			= empty($language)? 'en':$language;
		$ws 				= empty($ws)? 'order_tracking_details':$ws;
		 //$user_id = 947;
		$user_id = $this->validate_token($language ,$ws);

   	 	if (!empty($user_id))
   	 	{
   	 		
   	 		$data = $this->custom_model->my_where("order_master","order_status,display_order_id,order_master_id,delivery_date,order_datetime,order_comment,address,address_1,address_2,city,state,name,mobile_no,email",array("customer_id" => $user_id,"display_order_id" => $display_order_id),array(),"order_master_id","DESC" );
			
			if (!empty($data))
			{
				foreach ($data as $key => $value)
				{
				    $display_o_id =$value['display_order_id'];
				    
					$items = $this->custom_model->my_where("order_items","product_id,seller_id,quantity,price,commission,attribute,order_no,order_comment",array("order_no" => $value['order_master_id']) );

					foreach ($items as $k => $val)
					{
						$item_info = $this->custom_model->my_where("product","id,product_name,product_image,insurance,seller_id",array("id" => $val['product_id']) );
						$item_info[0]['product_image'] = $this->get_product_path($item_info[0]['product_image']);
						
						$seller_id = $item_info[0]['seller_id'] ;

                        $daata = $this->custom_model->my_where("order_invoice","*",array("seller_id" => $seller_id,"order_no" => $val['order_no']) );
                        if($daata)
                        {
                            $val['order_order_comment']     = $daata[0]['order_comment'] ;
                            $val['order_delivery_date']     = $daata[0]['delivery_date'] ;
                            $val['order_order_status']      = $daata[0]['order_status'] ;
                            $val['order_comment']           = $daata[0]['order_comment'] ;
                            
    						    
                        }
                        $val['display_o_id']           = $display_o_id;
                        
                        // $data = json_decode($val['attribute'], TRUE);
						// echo "<pre>";
						// print_r($data);

						$val['attribute'] = ($val['attribute'] != '[]')? json_decode($val['attribute']):new stdClass();
						$data[$key]['items'][$k] = array_merge($val,$item_info[0]);
					}
				}

				// echo "<pre>";
				// print_r($data[0]);
				// die;

				echo json_encode(array("status" => true , "ws"=> $ws ,"data" => $data[0] ,"message" => ($language == 'ar'? 'بنجاح.':'Successfully') )); die;
			}
			else{
				echo json_encode(array("status" => false , "ws"=> $ws ,"message" => ($language == 'ar'? 'لا يوجد طلب حتى الآن!':'No order yet ! ') )); die;
			}
 		}
 		else
 		{
 			echo json_encode(array("status" => false , "ws"=> $ws ,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
	}
	
	public function product_check_availablity()
	{
		$json = file_get_contents('php://input');

		// $json 	= '{"products":[{"pid":"1","qty":"1"},{"pid":"2","qty":"2"},{"pid":"3","qty":"68"}]}';

		$jsonobj 			= json_decode($json);
		$products 			= @$jsonobj->products;

		$language 			= @$jsonobj->language;
		$ws 				= @$jsonobj->ws;
		$language 			= empty($language)? 'en':$language;
		$ws 				= empty($ws)? 'product_check_availablity':$ws;
		// $user_id = 627;
		 $user_id = $this->validate_token($language ,$ws);
		

   	 	if (!empty($products))
   	 	{
   	 		$p = array();
   	 		foreach ($products as $key => $value)
   	 		{
   	 			$quantity = $value->qty;
   	 			$product_id = $value->pid;
   	 			$data = $this->custom_model->get_data_array("SELECT * FROM product WHERE stock >= '$quantity' AND stock_status = 'instock' AND id = '$product_id'  ");
				// echo "<br>";
				// print_r("SELECT * FROM product WHERE stock >= '$quantity' AND stock_status = 'instock' AND id = '$product_id' ");
   	 			
   	 			if ($data)
   	 			{
   	 				// $p[] = $data[0];
   	 				$products[$key]->add_status = '1';
   	 			}
   	 			else
   	 			{
   	 				$products[$key]->add_status = '0';
   	 			}
   	 		}

   	 		echo json_encode(array("status" => true ,"ws" => $ws ,"product" => $products ,"message" => ($language == 'ar'? 'طلب غير صالح':'success') )); die;

   			// echo "<pre>";
			// print_r($products);
			// die;
 		}
 		else
 		{
 			echo json_encode(array("status" => false , "ws"=> $ws ,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
 		}
	}
	

	public function email_mobile_validate()
	{
		$json = file_get_contents('php://input');

		// $json 		= '{"email":"sdf","phone":"8149169115"}';

		$jsonobj 	= json_decode($json);
		$email 		= @$jsonobj->email;
		$phone 		= @$jsonobj->phone;

		$ws 		= @$jsonobj->ws;
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'email_mobile_validate':$ws;
		
   	 	if (!empty($email) || !empty($phone))
   	 	{
			$phone_check = $this->custom_model->my_where("users","*",array("phone" => @$phone),array(),"","","","", array(), "",array(),false  );

			$email_check = $this->custom_model->my_where("users","*",array("email" => @$email),array(),"","","","", array(), "",array(),false  );


			if (!empty($email_check) &&  !empty($phone_check))
			{
				echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'البريد الالكتروني موجود بالفعل':'Email and  Phone already exists')) );die;
			}


			if (!empty($email_check))
			{
				echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'البريد الالكتروني موجود بالفعل':'Email already exists')) );die;
			}

			if (!empty($phone_check))
			{
				echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'رقم الهاتف موجود بالفعل':'Phone number already exists')) );die;
			}


			$response["message"] = ($language == 'ar'? 'تم تحديث الملف الشخصي بنجاح.':'Successfully.');
		
			//print_r($data);
			$response["status"] = true;
			$response["ws"] = $ws;
			// $response["data"] = $data[0];
			echo json_encode( $response );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}



   	public function fcm_update()
	{
		$json = file_get_contents('php://input');
		
		// $json 		= '{"fcm_no":"sdf"}';
		$Jwt_client = new Jwt_client();
		$jsonobj 	= json_decode($json);
		
		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
    	$fcm_no		= @$jsonobj->fcm_no;
    	$ws 		= @$jsonobj->ws;
 		$ws 		= empty($ws)? 'fcm_update':$ws;
		$user_id 	= $this->validate_token();
		// $user_id 	= 1;


		$check = $this->custom_model->record_count('users', ['id' => $user_id]);
		// print_r($check);
		if ($check == false)
		{
			echo json_encode( array("status" => false , "message" => ($language == 'ar'? 'مستخدم غير معروف':'Unknown user') ) );die;
		}

		$user_d = $this->custom_model->my_where("users","*",array("fcm_no" => @$fcm_no),array(),"","","","", array(), "",array(),false  );

		if (!empty($user_d))
		{
			$this->custom_model->my_update(array("fcm_no" => '',"notification" => "unavailable"),array("id" => $user_d[0]['id']),"users");
		}


		if (!empty($fcm_no))
   	 	{
	 		$this->custom_model->my_update(array("fcm_no" => $fcm_no,"notification" => "available"),array("id" => $user_id),"users");
	 		
			echo json_encode( array("status" => true,"ws" => $ws ,"message" => "FCM Key Updated Successfully") );die;
   	 	}
		else
		{
			$this->custom_model->my_update(array("fcm_no" => $fcm_no,"notification" => "unavailable"),array("id" => $user_id),"users");
			
			echo json_encode( array("status" => true,"ws" => $ws ,"message" => "FCM Key Updated Successfully") );die;
		}
   	}


   	public function patient_order_intake()
	{
		$json = file_get_contents('php://input');

		// $json 		= '{"sex":"male","pname":"1017","paddress":"10/6/2017","primary_insurance_cname":"1668","primary_insurance_number":"Girish","diag_code":"", "diag_desc":"dsds","secondary_insurance_cname":"","patient_height":"pune","other_insurance_number":"12675234654","patient_weight":"nsc123","patient_birth_of_date":"Male","mobile_no":"Upin123","email":"dsds","type" : "delete" ,"id" :"1"}';

		$jsonobj 	= json_decode($json);

		// echo "<pre>";
		// print_r($jsonobj);
		// die;

		// $user_id					= 627;

		$language 					= @$jsonobj->language;
		$language 					= empty($language)? 'en':$language;
		$ws 						= @$jsonobj->ws;
		$ws 						= empty($ws)? 'patient_order_intake':$ws;

		$user_id 					= $this->check_user_login($language,$ws);

		$id 						= @$jsonobj->id;
		$primary_insurance_cname 	= @$jsonobj->primary_insurance_cname;
		$primary_insurance_number 	= @$jsonobj->primary_insurance_number;
		$secondary_insurance_cname 	= @$jsonobj->secondary_insurance_cname;
		$other_insurance_number 	= @$jsonobj->other_insurance_number;

		$sex						= @$jsonobj->sex;
		$pname      				= @$jsonobj->pname;
		$paddress    				= @$jsonobj->paddress;

		$patient_height				= @$jsonobj->patient_height;							
		$patient_weight 			= @$jsonobj->patient_weight;
		$patient_birth_of_date 		= @$jsonobj->patient_birth_of_date;
		$mobile_no 					= @$jsonobj->mobile_no;			
		$email						= @$jsonobj->email;


		$additional_data = $response = array();

		if(!empty($primary_insurance_cname)) $additional_data['primary_insurance_cname'] 			= $primary_insurance_cname;
		if(!empty($primary_insurance_number)) $additional_data['primary_insurance_number'] 					= $primary_insurance_number;
		if(!empty($secondary_insurance_cname)) $additional_data['secondary_insurance_cname'] 				= $secondary_insurance_cname;
		if(!empty($other_insurance_number)) $additional_data['other_insurance_number'] 					= $other_insurance_number;
        if(!empty($sex)) $additional_data['sex'] 							= $sex;
        if(!empty($pname)) $additional_data['pname'] 						= $pname;
        if(!empty($paddress)) $additional_data['paddress'] 					= $paddress;
        if(!empty($patient_height)) $additional_data['patient_height'] 		= $patient_height;
        if(!empty($patient_weight)) $additional_data['patient_weight'] 		= $patient_weight;
        if(!empty($patient_birth_of_date)) $additional_data['patient_birth_of_date'] 				= $patient_birth_of_date;
        if(!empty($mobile_no)) $additional_data['mobile_no'] 				= $mobile_no;
        if(!empty($email)) $additional_data['email'] 						= $email;
        if(!empty($user_id)) $additional_data['user_id'] 					= $user_id;


		// echo "<pre>";
		// print_r($additional_data);
		// die;

		$type 	= @$jsonobj->type;
   	 	$inserted_id = 0;

   	 	if (!empty($user_id))
   	 	{
			if ($type == 'save')
			{
				$inserted_id = $this->custom_model->my_insert($additional_data, 'patient_order_intake');
			}
			else if($type == 'update' && !empty($id))
			{
				$this->custom_model->my_update($additional_data ,array("id" => $id),"patient_order_intake");
			}
			else if($type == 'delete' && !empty($id))
			{
				$this->custom_model->my_update(array("status"=>"1") ,array("id" => $id),"patient_order_intake");

				// $this->custom_model->my_delete(['id' => $id], 'patient_order_intake');
			}

			$data = $this->custom_model->my_where("patient_order_intake","*",array("user_id" => $user_id,"status !=" => "1"),array(),"id","DESC","","", array(), "",array(),true );
			
			// echo $this->db->last_query();

			// echo "<pre>";
			// print_r($data);
			// die;

			if (empty($data))
			{
				echo json_encode( array("status" => false, "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No record found')) );die;
			}
			else
			{
				// echo "<pre>";
				// print_r($data);
				// die;
				echo json_encode( array("status" => true, "ws" => $ws,"message" => "Successfully" ,"data" => $data) );die;
			}
   	 	}
		else
		{
			echo json_encode( array("status" => false, "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
		}
   	}

   	public function getcontact_us()
	{
		$json = file_get_contents('php://input');
		//$json = '{"name":"vishal123","email":"vishal123@gmail.com","mobile":"8551995731","subject":"hello vk","message":"test test test"}';
		$jsonobj 				= json_decode($json);
		$language 				= @$jsonobj->language;
		$language 				= empty($language)? 'en':$language;
		$ws 		            = empty($ws)? 'getcontact_us':$ws;
		
		$user_id = $this->validate_token($language);

		$check_form1 = $this->custom_model->get_data_array("SELECT stay_address,email,telephone,send_message,get_touch FROM social");
			
		echo json_encode(array("status" => true, "ws" => $ws,"data" => $check_form1 ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
		
   	}

   	public function contact_us()
   	{
   		$json = file_get_contents('php://input');
		//$json = '{"name":"vishal123","email":"vishal123@gmail.com","mobile":"8551995731","subject":"hello vk","message":"test test test"}';
   		$post_arr = array();
		$jsonobj 				= json_decode($json);
		$language 				= @$jsonobj->language;
		$language 				= empty($language)? 'en':$language;
		$ws 		            = empty($ws)? 'contact_us':$ws;
		
		$user_id = $this->validate_token($language);

		$post_arr['name'] 		= @$jsonobj->name;
		$post_arr['email'] 		= @$jsonobj->email;
		$post_arr['mobile']		= @$jsonobj->mobile;
		$post_arr['subject']	= @$jsonobj->subject;
		$post_arr['message']	= @$jsonobj->message;
			
		if (!empty($post_arr))
		{
		   $check_form = $this->custom_model->my_insert($post_arr,'contact_us');

		   echo json_encode(array("status" => true, "ws" => $ws,"data" => $check_form ,"message" => ($language == 'ar'? 'الرجاء إدخال معرف بريد إلكتروني صالح / رقم الجوال.':'Successfully') )); die;
		}
		else
		{
			echo json_encode(array("status" => false, "ws" => $ws,"data" => $check_form ,"message" => "All fields are required." )); die;
		}		
   	}

   	public function saved_cards()
    {
	   		 
	   	$json = file_get_contents('php://input');
	   	// $json 	= '{"user_id":"20","cardholder_name":"John Smith","card_number":"4788250000028291","card_type" : "American Express" , "month" :"02" , "year" :"34" ,"cvv" :"123"}';

   		$post_data = array();
		$jsonobj 				= json_decode($json);
		$language 				= @$jsonobj->language;
		$language 				= empty($language)? 'en':$language;
		$ws 		            = empty($ws)? 'saved_cards':$ws;
		
		$user_id = $this->validate_token($language);
		//$uid = 0;
   		$post_data['cardholder_name'] 	= @$jsonobj->cardholder_name;
		$post_data['card_number'] 		= @$jsonobj->card_number;
		$post_data['card_type'] 		= @$jsonobj->card_type;
		$post_data['month'] 			= @$jsonobj->month;
		$post_data['year'] 				= @$jsonobj->year;
		$post_data['cvv'] 				= @$jsonobj->cvv;
		$post_data['user_id'] 			= @$jsonobj->user_id;
		
		/* Payment tokenize integration  22-02-2019 */

		    $insert_data=array();
		    //client production api key
		    $serviceURL = 'https://api.payeezy.com/v1/transactions';
		    $apiKey = "XfuqFbDrwqcjSIuGaPwQJUjSJRQK0cGj";
		    $apiSecret = "2e02a41eed03e11f38cc622866123290266cc80e453192ee4d5775112a7874b9";
		    $token = "fdoa-baea26c8a723b56b15610215675d2010baea26c8a723b56b";


		    $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
		    $timestamp = strval(time()*1000); //time stamp in milli seconds

		    if(!empty($post_data))
		    {

		    $post_data21  = $this->setPrimaryTxPayload123($post_data);     
		    // echo "<pre>";
		    // print_r($post_data21);
		    // die;
		    $payload =$this->getPayload123($post_data21);

		     // echo "<pre>";
		     // print_r($payload);
		     // die;
		    /**
		       * Payeezy
		       *
		       * Generate Payload
		       */

		   /* echo "<br><br> Request JSON Payload :" ;

		    echo $payload ;

		    echo "<br><br> Authorization :" ;*/

		    $data = $apiKey . $nonce . $timestamp . $token . $payload;

		    $hashAlgorithm = "sha256";

		    ### Make sure the HMAC hash is in hex -->
		    $hmac = hash_hmac ( $hashAlgorithm , $data , $apiSecret, false );

		    ### Authorization : base64 of hmac hash -->
		    $hmac_enc = base64_encode($hmac);

		    /*echo "<br><br> " ;

		    echo $hmac_enc;

		    echo "<br><br>" ;*/

		    $curl = curl_init('https://api.payeezy.com/v1/transactions/tokens');

		    $headers = array(
		          'Content-Type: application/json',
		          'apikey:'.strval($apiKey),
		          'token:'.strval($token),
		          'Authorization:'.$hmac_enc,
		          'nonce:'.$nonce,
		          'timestamp:'.$timestamp,
		        );
		    /*echo "<pre>";
		    print_r($headers);
		    echo "</pre>";
		    echo "<pre>";
		    print_r(json_decode($payload));
		    die;*/

		    curl_setopt($curl, CURLOPT_HEADER, false);
		    curl_setopt($curl, CURLOPT_POST, true);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

		    curl_setopt($curl, CURLOPT_VERBOSE, true);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		    $json_response = curl_exec($curl);

		    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		    $response = json_decode($json_response, true);

		    /*echo "<pre>";
		    print_r($response);
		    print_r($status);
		    die;*/


		    if ( $status != 201 ) 
		    {

		      $insert_data = $response;
		      $insert_data['Error_code']=$insert_data['Error']['messages'][0]['code'];
		      $insert_data['Error_description']=$insert_data['Error']['messages'][0]['description'];
		      $insert_data['card_type']=$post_data['card_type'];
		      $insert_data['cardholder_name']=$post_data['cardholder_name'];
		      $insert_data['card_number']=$post_data['card_number'];
		      $insert_data['exp_date']=$post_data['month'].$post_data['year']; 	
		      $insert_data['month']=$post_data['month'];
		      $insert_data['year']=$post_data['year'];
		      $insert_data['user_id'] = $user_id;
		      unset($insert_data['Error']); 
		     $this->custom_model->my_insert($insert_data,'saved_cards');

		     echo json_encode(array("status" => false,'ws' => $ws,"data" => $response ,"message" => $response['Error_description'] )); die;

		    
		    } 
		    else 
		    {
		      $insert_data = $response;
		      //$insert_data['token_type']=$insert_data['token']['token_type'];
		      //$insert_data['token_value']=$insert_data['token']['token_data']['value'];
		      $insert_data['card_type']=$post_data['card_type'];
		      $insert_data['cardholder_name']=$post_data['cardholder_name'];
		      $insert_data['card_number']=$post_data['card_number'];
		      $insert_data['exp_date']=$post_data['month'].$post_data['year'];
		      $insert_data['month']=$post_data['month'];
		      $insert_data['year']=$post_data['year'];
		      $insert_data['user_id'] = $user_id;
		      unset($insert_data['token']);
		      unset($insert_data['card']);

		      $this->custom_model->my_insert($insert_data,'saved_cards');

		     echo json_encode(array("status" => true,'ws' => $ws,"data" => $response ,"message" => 'Save card successfully' )); die;
		      
		    }
		}
			else
			{
				$response['status'] = false;
				$response['ws'] = $ws;
				$response['message'] = 'All fields are required.';
				echo json_encode($response);die;
			}
   	}

   	public function delete_cards()
 	{
 			$uid = 0;
 		    $json = file_get_contents('php://input');	
 		    //$json  = '{"id"="12"}';
 		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'delete_cards':$ws;
			// $user_id 		= 627;
			//$uid = $this->validate_token($language,$ws);

 			$jsonobj 	= json_decode($json);
 			$id	        = @$jsonobj->id;

 	   	 	$response = array();

 	   	 	if (!empty($id))
 	   	 	{

 		   	$cards = $this->custom_model->my_delete(['id' => $id], 'saved_cards');

 		 			$response['status'] = true;
 					$response['cards'] = $cards;
 					$response['ws'] = $ws;
 					$response['message'] = 'Success';
 			
 				echo json_encode($response);die;
 	 		}
 	 		else
 	 		{
 		 			$response['status'] = false;
 		 			$response['ws'] = $ws;
 					$response['message'] = 'Something went wrong.';
 					echo json_encode($response);die;
 	 		}
 			
 			die;
    }	

    /* Validation for add cards 21-2-2019 */
    public function setPrimaryTxPayload123($post_data)
    {

        $cardholder_name = $card_number = $card_type = $card_cvv  =  $card_expiry  = $merchant_ref = $user_id = "";

        $cardholder_name =$this->processInput123($post_data['cardholder_name']);
        $card_number = $this->processInput123($post_data['card_number']);
        $card_type = $this->processInput123($post_data['card_type']);
        $card_cvv = $this->processInput123($post_data['cvv']);
        $user_id = $this->processInput123($post_data['user_id']);
        $card_expiry = $this->processInput123($post_data['month'].$post_data['year']);
        $merchant_ref = $this->processInput123("Astonishing-Sale");


        $primaryTxPayload1 = array(
            "card_number" => $card_number,
            "card_type" => $card_type,
            "cardholder_name" => $cardholder_name,
            "cvv" => $card_cvv,
            "card_expiry" => $card_expiry,
            "user_id" => $user_id,
            "merchant_ref" => $merchant_ref,
        );

        return $primaryTxPayload1;
    }


    public function getPayload123($args = array())
    {
      $args = array_merge(array(
          "card_number" => "",
          "card_type" => "",
          "cardholder_name" => "",
          "cvv" => "",
          "card_expiry" => "",
          "user_id" => "",
          "merchant_ref" => "",
          "transaction_tag" => "",
          "split_shipment" => "",
          "transaction_id" => "",

      ), $args);

      $data = "";
      
      $data = array(
                'type'=> 'FDToken',             
                'credit_card'=> array(
                        'type'=> $args['card_type'],
                        'cardholder_name'=> $args['cardholder_name'],
                        'card_number'=> $args['card_number'],
                        'exp_date'=> $args['card_expiry'],
                        'cvv'=> $args['cvv'],
                      ),
                'auth'=> 'false',
                'ta_token'=> 'NOIW'
      );
     
      return json_encode($data, JSON_FORCE_OBJECT);
    }

    public function processInput123($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return strval($data);
    }


    /* End */

    public function getorder_listing()
    {
    	$json = file_get_contents('php://input');
		//$json = '{"user_id":"20" }';
		$jsonobj 			= json_decode($json);
		$language 			= @$jsonobj->language;
		$ws 				= @$jsonobj->ws;
		$language 			= empty($language)? 'en':$language;
		$ws 				= empty($ws)? 'getorder_list':$ws;
		//$user_id = 115;
		$user_id = $this->validate_token($language ,$ws);

		if($user_id)
		{
			$data =  $this->custom_model->get_data_array("SELECT display_order_id,order_master_id,order_datetime FROM `order_master` WHERE `user_id` = $user_id AND `push_doc` != '' ORDER BY `order_master_id` DESC ");
			if($data)
			{
				echo json_encode(array("status" => true,"data" => $data , "ws" => $ws,"message" => 'Successfully Order Listing' )); die;
			}
			else 
			{
				echo json_encode(array("status" => false,"data" => $data , "ws" => $ws,"message" => "No Order Yet" )); die;
			}			
		}
		else
		{
			echo json_encode(array("status" => false, "ws" => $ws ,"message" => "Invalid request" )); die;
		}
    }

    public function resend_otp($mobile,$user_id='')
	{
		if (empty($user_id))
		{
			$user_id = array();
		}
		if (!empty($mobile))
		{
			//send otp to mobile
			$digits = 4;
			$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
			$check = $this->custom_model->record_count('otp_verify', ['phone' => $mobile]);			
			if ($check)
			{
				$this->custom_model->my_update(['otp' => $otp], ['phone' => $mobile], 'otp_verify');
			}
			else{
				$this->custom_model->my_insert(['otp' => $otp, 'phone' => $mobile,'user_id' => $user_id],'otp_verify');
			}
			
		}
	}

	public function sign_up()
	{
   	    //$jsonobj 		= json_decode($json);
   	    $Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');
		//$json = '{"email":"vishal@appristine.in","mobile":"8149169115","language":"en","country_code":"+91"}';
		$jsonobj 		= json_decode($json);
		$email 			= @$jsonobj->email;
		$mobile 		=  @$jsonobj->mobile;
		$country_code 		=  @$jsonobj->country_code;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'sign_up':$ws;

		$user_id = $this->validate_token($language , $ws);
		//echo $email;

		//echo $mobile
	

		if (!empty($email) && !empty($mobile))
		{
			// $check = $this->custom_model->record_count('otp_verify', ['otp' => $otp, 'phone' => $mobile]);

			$query_email = $this->custom_model->get_data_array("SELECT email FROM users WHERE email LIKE '%$email%'");
			
			if($query_email[0]['email'])
			{
				$response['status'] = false;
				$response['message'] = 'Email already exists';
				echo json_encode($response);die;	
			}

			$query_phone = $this->custom_model->get_data_array("SELECT phone FROM users WHERE phone LIKE '%$mobile%'");
			//print_r($query_phone);
			//die;
			if($query_phone[0]['phone'])
			{
				$response['status'] = false;
				$response['message'] = 'Phone number already exists';
				echo json_encode($response);die;
			}

			// $check = $this->custom_model->get_data_array("SELECT *  FROM otp_verify WHERE phone LIKE '%$mobile%' AND `otp` = $otp  ");
			$check_verifyphone = $country_code.$mobile;
			$get_otp = $this->custom_model->my_where("otp_verify","*",array('phone' => $check_verifyphone ),array(),"id","DESC");

			if (!isset($get_otp[0]['otp']))
			{
				    $rand_no = mt_rand(1000, 9999);
				     $this->custom_model->my_insert(array('phone' => $check_verifyphone,'otp'=>$rand_no ),"otp_verify");
			}
			else
			{
				//$this->custom_model->my_update(['status' => 'active' ], ['phone' => $mobile], 'otp_verify');

				$rand_no =  $this->custom_model->my_update(['otp' => $rand_no, 'status' => 'active' ], ['id' => $get_otp[0]['id']], 'otp_verify');
			}

			$message = 'Please use OTP '.$rand_no.' to verify your mobile number.Thank you for using MSM';

				//echo "string";
			$emails = $email;
			$subject = "OTP Verification MSM";
			send_email($emails,$subject,$message);
			$this->load->library('twilio');
			$sms = $this->twilio->send_sms($check_verifyphone,$message);

			echo json_encode( array("status" => true, "ws" => $ws, "message" => "OTP send successfully",'otp' => $rand_no ));die;
			/*if ($check)
			{

				$user = $this->custom_model->my_where('users','*',array('id' => $check[0]['user_id']),array(),"","","","", array(), "",array(),false );

				$password = $user[0]['password'];
				unset($user[0]['password']);
				unset($user[0]['salt']);
				unset($user[0]['ip_address']);
				unset($user[0]['activation_code']);
				unset($user[0]['forgotten_password_code']);
				unset($user[0]['forgotten_password_time']);
				unset($user[0]['remember_code']);

				$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user[0]['id'] ) );
				$response['status'] = true;
				$response["user"] = $user;

				// echo "<pre>";
				// print_r($user);
				// die;
				$this->custom_model->my_update(['active' => 1 , 'token' => $user[0]['token']], ['id' => $user[0]['id']], 'users');

				$this->custom_model->my_update(['status' => 'activate' ],['phone' => $mobile,'user_id' => $user[0]['id']], 'otp_verify');

				// echo $this->db->last_query();
				$response['status'] = true;
				$response['ws'] = $ws;
				$response['message'] = 'Successfully Login .';
				echo json_encode($response);die;
			}
			else
			{
				$response['status'] = false;
				$response['ws'] = $ws;
				$response['message'] = 'Please enter valid OTP.';
				echo json_encode($response);die;
			}*/
		}
		else
		{
			echo json_encode( array("status" => false, "ws" => $ws, "message" => "All fields are required."));die;
		}
	}

	public function get_employee()
	{
		$sql = $this->custom_model->get_data_array("SELECT * FROM employee");
		
		echo json_encode( array("status" => true,"data" => $sql) );
	}

}