<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

	public function __construct()
	{
		$this->load->model('default_model');
		$this->load->model('admin/custom_model');
		$this->load->library("Jwt_client");
	    $this->token_id = "s56by73212343289fdsfitdsdne";
	}

	/**
	 * gets main category and vendor list
	 */
	 
	 
	public function logo_upload()
    {
    	$json = file_get_contents('php://input');
// 		$user_id 		= 627;
        // $json 			= '{"logo":"salman"}';
		$jsonobj 		= json_decode($json);
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$logo 			= @$jsonobj->logo;
        $ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'logo_upload':$ws;
		
		$user_id 	= $this->validate_token($language);
		
   	 	if (!empty($user_id))
   	 	{
   	 		$additional_data = $response = array();
   	 		
			if(!empty($logo)) $additional_data['logo'] 			            = $logo;
			
	        $result = $this->custom_model->my_update($additional_data,array("id" => $user_id),"users");

			$response["message"] = ($language == 'ar'? 'تم تحديث الملف الشخصي بنجاح.':'Profile updated successfully.');

			$data = $this->custom_model->my_where("users","id,logo",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );
			//print_r($data);
			
			$data[0]['logo'] = $this->get_profile_path($data[0]['logo']);

			$response["status"] = true;
			$response["data"] = $data[0];
			$response["ws"] = @$ws;
			echo json_encode( $response );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
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

	public function index()
	{
		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$category 	= @$jsonobj->category;

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


   	 	$response = array();
   	 	// $category = '10';
   	 	$response['navbsr_list'] = $this->default_model->navbar_data();
		
		// $response['navbsr_list'] = $nav_list->result_array();
		$data = $this->custom_model->my_where("banner","*",array("status" => 'active' ) );
		if (!empty($data))
		{
			foreach ($data as $key => $value)
			{
				$response['banner_img'][] = $this->get_banner_path($value['image']);
			}
		}
   	 	if (!empty($category))
   	 	{
   	 		$vendor_list = $this->default_model->get_category($category);
   	 		if ($vendor_list)
   	 		{
   	 			$user_sort = array();
   	 			if (!empty($vendor_list['users'])) {
   	 				foreach ($vendor_list['users'] as $key => $value) {
	   	 				$value['logo'] = $this->get_vendor_path($value['logo']);
	   	 				// $vendor_list['users'][$key]['logo'] = $value['logo'];

	   	 				$plan = $value['plan'];
	   	 				$user_sort[$plan][] = $value;
	   	 			}
   	 			}
   	 			
   	 			$response['status'] = true;
				$response['data'] = $user_sort;
				$response['message'] = 'Success';
   	 		}
   	 		else
   	 		{
   	 			$response['status'] = false;
				$response['message'] = 'Invalid category code';
   	 		}
   	 		$response['platinum_slider'] = new stdClass();
   	 		echo json_encode($response);die;
   	 	}
   	 	else{
   	 		/*$vendor_list = $this->default_model->get_random_vendor();
   	 		if (!empty($vendor_list)) {
   	 			foreach ($vendor_list as $k => $val) {

   	 				if (!empty($val)) {
   	 					foreach ($val as $key => $value) {
		   	 				$vendor_list[$k][$key]['logo'] = $this->get_vendor_path($value['logo']);
		   	 			}
   	 				}
	   	 			
	 			}
   	 		}*/
   	 		$result = array();
   	 		$ven_data = $this->custom_model->my_where("admin_users","*",array('active' => '1','plan' => 'platinum') );
   	 		if (!empty($ven_data))
			{
				foreach ($ven_data as $key => $value)
				{
					$value['logo'] = $this->get_vendor_path($value['logo']);
					$result['platinum'][$key] = $value;
				}
			}

	 		$response['status'] = true;
			$response['data'] = new stdClass();
			$response['platinum_slider'] = $result;
			$response['message'] = 'Success';
			echo json_encode($response);die;
   	 	}

		die;
	}

	/**
	 * vendor details and sub category
	 */
	public function vendor()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"category":"30","vendor":"bonafide-restaurant"}';
		$jsonobj 	= json_decode($json);
		$category 	= @$jsonobj->category;
		$vendor 	= @$jsonobj->vendor;
		$user_id 	= @$jsonobj->user_id;

		
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


   	 	$response = array();

   	 	if (!empty($category) && !empty($vendor))
   	 	{
   	 		$data = $this->default_model->seller_data($category,$vendor,'',$language);

   	 		/*if (!empty($data['product']))
   	 		{

   	 			if (!empty($user_id))
   	 			{
	   	 			$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
   	 			}

   	 			foreach ($data['product'] as $key => $value)
   	 			{
   	 				$data['product'][$key]['product_image'] = $this->get_product_path($value['product_image']);
   	 				if (isset($my_wish))
   	 				{
   	 					$data['product'][$key]['is_in_wish_list'] = !empty($my_wish) && in_array($value['id'], $my_wish)? true:false;
   	 				}
   	 				else{
   	 					$data['product'][$key]['is_in_wish_list'] = false;
   	 				}
   	 			}
   	 		}*/

   	 		$data['seller_info'][0]['logo'] = $this->get_vendor_path($data['seller_info'][0]['logo']);

   	 		if (!empty($data['sub_category']))
   	 		{
   	 			foreach ($data['sub_category'] as $key => $value)
   	 			{
   	 				$data['sub_category'][$key]['image'] = $this->get_category_path($value['image']);

   	 				if (!empty($value['sub_cate']))
   	 				{
   	 					foreach ($value['sub_cate'] as $k => $val)
   	 					{
   	 						$data['sub_category'][$key]['sub_cate'][$k]['image'] = $this->get_category_path($val['image']);
   	 					}
   	 				}
   	 			}
   	 		}

   	 		if ($data)
   	 		{
	 			$response['status'] = true;
				$response['data'] = $data;
				$response['message'] = 'Success';
			}
   	 		else
   	 		{
   	 			$response['status'] = false;
				$response['message'] = 'Invalid category code';
   	 		}
			echo json_encode($response);die;
 		}
 		else
 		{
 			$response['status'] = false;
			$response['message'] = 'Something went wrong.';
			echo json_encode($response);die;
 		}
		
		die;
	}

	/**
	 * get sub_sub_category
	 */
	public function sub_sub_category()
	{
		

		$json = file_get_contents('php://input');
		// $json 		= '{"sub_category":"16"}';
		$jsonobj 	= json_decode($json);
		$sub_category 	= @$jsonobj->sub_category;
		
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


   	 	$response = array();

   	 	if (!empty($sub_category))
   	 	{
   	 		$data = $this->default_model->get_sub_sub_category($sub_category,$language);

   	 		if (!empty($data))
   	 		{
   	 			foreach ($data as $key => $value)
   	 			{
   	 				$data[$key]['image'] = $this->get_category_path($value['image']);
   	 			}
   	 		
	   	 		$response['status'] = true;
				$response['data'] = $data;
				echo json_encode($response);die;
	   	 	}
	   	 	else{
	   	 		$response['status'] = false;
				$response['message'] = 'There are no sub categories!';
				echo json_encode($response);die;
	   	 	}

   	 	}
   	 	else{
   	 		$response['status'] = false;
			$response['message'] = 'There are no sub categories!';
			echo json_encode($response);die;
   	 	}
   	}

	/**
	 * product details, vendor details and sub category
	 */
	public function product()
	{
		
		$json = file_get_contents('php://input');
		// $json 		= '{"category":"30","vendor":"bonafide-restaurant","subcategory":"30","brand_name":["my"],"max_price":50}';
		$jsonobj 	= json_decode($json);
		$category 	= @$jsonobj->category;
		$vendor 	= @$jsonobj->vendor;
		$subcategory 	= @$jsonobj->subcategory;
		$brand_name 	= @$jsonobj->brand_name;
		$max_price 	= @$jsonobj->max_price;
		$user_id 	= @$jsonobj->user_id;
		
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

   	 	$response = array();

   	 	if (!empty($category) && !empty($vendor) && !empty($subcategory))
   	 	{
   	 		$data = $this->default_model->products_data($category,$vendor,$subcategory,$language,$brand_name,$max_price);

   	 		if ($data)
   	 		{
   	 			$data['seller_info'][0]['logo'] = $this->get_vendor_path($data['seller_info'][0]['logo']);

   	 			if (!empty($user_id))
   	 			{
	   	 			$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

					if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);
   	 			}

   	 			if (!empty($data['product_info'])) 
	   	 		{
	   	 			foreach ($data['product_info'] as $key => $value)
	   	 			{
	   	 				$data['product_info'][$key]['product_image'] = $this->get_product_path($value['product_image']);
	   	 				if (isset($my_wish))
	   	 				{
	   	 					$data['product_info'][$key]['is_in_wish_list'] = !empty($my_wish) && in_array($value['id'], $my_wish)? true:false;
	   	 				}
	   	 				else{
	   	 					$data['product_info'][$key]['is_in_wish_list'] = false;
	   	 				}
	   	 			}
	   	 		}
	   	 		$data['ads']	 = strip_tags($data['ads']);
	 			$response['status'] = true;
				$response['data'] = $data;
				$response['message'] = 'Success';
			}
   	 		else
   	 		{
   	 			$response['status'] = false;
				$response['message'] = 'Invalid parameters';
   	 		}
			echo json_encode($response);die;
 		}
 		else
 		{
 			$response['status'] = false;
			$response['message'] = 'Something went wrong.';
			echo json_encode($response);die;
 		}
		
		die;
	}

      //prescription listing

		public function get_prescription()
		{
			$uid = 0;

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			
		    //$uid = 140;
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{

		   	 	$prescription = $this->custom_model->my_where('prescription',"*",array('status' => '1','user_id' => $uid),array(),"","",'prescription_img');
	           if(!empty($prescription)){
	            foreach($prescription as $kp => $vp ){
	               $vp['prescription_img_url'] = base_url('assets/admin/usersdata/prescription/').$vp['prescription_img'];
	               $prescription[$kp] = $vp;
	            }
	          }
		 			$response['status'] = true;
					$response['prescription'] = $prescription;
					$response['message'] = 'Success';
			
				echo json_encode($response);die;
	 		}
	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}

		public function get_document()
		{
			$json = file_get_contents('php://input');
			$jsonobj 	= json_decode($json);

			$uid = 0;
			$order_id  			= @$jsonobj->order_id;
			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{

		   	 	$prescription = $this->custom_model->my_where('upload_document',"*",array('status' => '1','user_id' => $uid,'order_id' => $order_id),array(),"","",'document_img');
	           if(!empty($prescription)){
	            foreach($prescription as $kp1 => $vp1 ){
	               $vp1['prescription_img_url'] = base_url('assets/admin/usersdata/upload_document/').$vp1['document_img'];
	               $prescription[$kp1] = $vp1;
	            }
	          }
		 			$response['status'] = true;
					$response['prescription'] = $prescription;
					$response['message'] = 'Success';
			
				echo json_encode($response);die;
	 		}
	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}


         //insurance listing

		public function get_insuarnce()
		{
			$uid = 0;
			
			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

            
            //$uid = 429;
			//echo $uid;
           
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{

		   	 	$insurance = $this->custom_model->my_where('order_insurance',"*",array('status' => '1','user_id' => $uid),array(),"","",'front_view');
	          if(!empty($insurance)){
	            foreach($insurance as $ik => $iv ){
	               $iv['front_view_url'] = base_url('assets/admin/usersdata/insurance/').$iv['front_view'];
	               $iv['back_view_url'] = base_url('assets/admin/usersdata/insurance/').$iv['back_view'];
	               $insurance[$ik] = $iv;
	            }
	          }
		 			$response['status'] = true;
					$response['insurance'] = $insurance;
					$response['message'] = 'Success';
			
				echo json_encode($response);die;
	 		}
	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}


        public function delete_insuarnce()
		{   
			$uid = 0;
		    $json = file_get_contents('php://input');	

		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			$jsonobj 	= json_decode($json);
			$id 	= @$jsonobj->id;
			$front_view	= @$jsonobj->front_view;
			$back_view	= @$jsonobj->back_view;
            //$uid = 140;
		    //$id = 48;
		    //$front_view =;
		    //$back_view =;

	   	 	$response = array();

	   	 	if (!empty($uid) && !empty($front_view) && !empty($back_view))
	   	 	{

		   	 	$insurance = $this->custom_model->my_delete(array('front_view' => $front_view,'user_id' => $uid,'back_view' => $back_view),'order_insurance');
	         
		 			$response['status'] = true;
					$response['insurance'] = $insurance;
					$response['message'] = 'Success';
			
				echo json_encode($response);die;
	 		}
	 		else
	 		{
		 			$response['status'] = false;
					$response['message'] = 'Something went wrong.';
					echo json_encode($response);die;
	 		}
			
			die;


     }

        public function delete_prescription()
 		{
 			$uid = 0;
 		    $json = file_get_contents('php://input');	

 		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

 			$jsonobj 	= json_decode($json);
 			$prescription_img	= @$jsonobj->prescription_img;
             //$uid = 139;
 		    // $id = 56;
 		    //$prescription_img

 	   	 	$response = array();

 	   	 	if (!empty($uid) && !empty($prescription_img))
 	   	 	{

 		   	 	$prescription = $this->custom_model->my_delete(array('prescription_img' => $prescription_img ,'user_id' => $uid),'prescription');
 	         
 		 			$response['status'] = true;
 					$response['prescription'] = $prescription;
 					$response['message'] = 'Success';
 			
 				echo json_encode($response);die;
 	 		}
 	 		else
 	 		{
 		 			$response['status'] = false;
 					$response['message'] = 'Something went wrong.';
 					echo json_encode($response);die;
 	 		}
 			
 			die;


      }

       public function delete_document()
 		{
 			$uid = 0;
 		    $json = file_get_contents('php://input');	

 		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'vendor':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

 			$jsonobj 	= json_decode($json);
 			$prescription_img	= @$jsonobj->prescription_img;
             //$uid = 139;
 		    // $id = 56;
 		    //$prescription_img

 	   	 	$response = array();

 	   	 	if (!empty($uid) && !empty($prescription_img))
 	   	 	{

 		   	 	$prescription = $this->custom_model->my_delete(array('document_img' => $prescription_img ,'user_id' => $uid),'upload_document');
 	         
 		 			$response['status'] = true;
 					$response['prescription'] = $prescription;
 					$response['message'] = 'Success';
 			
 				echo json_encode($response);die;
 	 		}
 	 		else
 	 		{
 		 			$response['status'] = false;
 					$response['message'] = 'Something went wrong.';
 					echo json_encode($response);die;
 	 		}
 			
 			die;


      }
	/**
	 * Product filter
	 */
	public function product_filter()
	{
		
		$json = file_get_contents('php://input');
		// $json 		= '{"vendor":"tower-health-natural-health-and-pharmacy-1","subcategory":"56"}';
		$jsonobj 	= json_decode($json);
		$vendor 	= @$jsonobj->vendor;
		$subcategory 	= @$jsonobj->subcategory;
   	 	$response = $price = array();
   	 	
   	 	$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$uid = $this->validate_token($language,$ws);


   	 	if (empty($vendor) || empty($subcategory)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}
   	 	else
   	 	{
   	 		$seller_info = $this->custom_model->my_where('admin_users','id',array('slug' => $vendor));

   	 		$data = $this->custom_model->my_where('product','id,product_brand,price,sale_price',array('seller_id' => $seller_info[0]['id'], 'category' => $subcategory,'status' => '1'), array(), "", "", "product_brand");
   	 		if (!empty($data))
   	 		{
   	 			foreach ($data as $key => $value)
   	 			{
   	 				if ($language != 'en')
   	 				{
   	 					$res = $this->custom_model->my_where('product_trans','product_brand',array('id' => $value['id']));
   	 					$value['product_brand'] = !empty($res)? $res[0]['product_brand']:$value['product_brand'];
   	 				}
   	 				$response['product_brand'][] = $value['product_brand'];
   	 				$price[] = !empty($value['sale_price'])? $value['sale_price']:$value['price'];
   	 			}
   	 			rsort($price);
   	 			$response['max_price'] = $price[0];

   	 			echo json_encode( array("status" => true, "data" => $response) );die;
   	 		}
   	 		
   	 	}

		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * product detail
	 */
	public function product_detail()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"product_id":"30"}';
		$jsonobj 	= json_decode($json);
		
		
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);
		$product_id 	= @$jsonobj->product_id;



   	 	$response = array();

   	 	if (!empty($product_id))
   	 	{
   	 		$data = $this->custom_model->my_where("product","*",array("status" => '1' ,'id' => $product_id) );

   	 		if (!empty($data))
   	 		{	

				$review = $this->custom_model->my_where( "user_rating","rating,comment",array('uid' => $user_id, 'pid' => $product_id ) );
				$data[0]['review'] = !empty($review)? $review[0] : new stdClass();
				$user_review = $this->custom_model->my_where("user_rating","*",array('pid' => $product_id, 'status' => 'active') );
				if (!empty($user_review))
				{
					$avg = 0;
					foreach ($user_review as $key => $value)
					{
						$udata = $this->custom_model->my_where("users","first_name",array("id" => $value['uid']),array(),"","","","", array(), "",array(),false  );
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
				
   	 			$data = $data[0];
   	 			$data['product_image'] = array($this->get_product_path($data['product_image']));
   	 			
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
   	 			

	 			$response['status'] = true;
				$response['data'] = $data;
				$response['message'] = 'Success';
   	 			echo json_encode( $response );die;
			}
   	 	}
   	 	echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * add product to cart 
	 */
	public function add_to_cart()
	{
		$json = file_get_contents('php://input');
		// $json 		= '{"product_id":"130","user_id":"56","quantity":"6"}';
		$jsonobj 	= json_decode($json);
		$pid 	= @$jsonobj->product_id;
		// $user_id 	= @$jsonobj->user_id;
		$quantity 	= @$jsonobj->quantity;
		$type 	= @$jsonobj->type;
		$type = empty($type)? 'add':$type;

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		if (!empty($pid) && !empty($user_id) && !empty($quantity))
		{

			$this->load->library('user_account');
			
			if ($type == 'add')
			{
				$response = $this->user_account->add_remove_cart($pid,$user_id,'add',$quantity);

				if ($response)
				{
					if (isset($response['inc_qty']))
					{
						unset($response['inc_qty']);
					}
					echo json_encode( array("status" => true,"cart" => $response,"count" => count($response)) );die;
				}
				else{
					echo json_encode( array("status" => false,"message" => 'Not enough stock...') );die;
				}
				
				
			}
			elseif ($type == 'remove')
			{
				$response = $this->user_account->add_remove_cart($pid,$uid,'remove');

				if ($response != '-1')
				{

					$count = count($response);

					if(empty($response))
					{
						$response = new stdClass();
						$count = '0';
					}

					echo json_encode( array("status" => true,"cart" => $response,"count" => $count) );die;
				}

			}
		}
			
		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		
		die;
   	}

	/**
	 * View products in cart
	 */
	public function view_cart()
	{
		$total_saved = $totaltax = $totaldel = 0;
		$json = file_get_contents('php://input');
		//$user_id = 17;
		$jsonobj 	= json_decode($json);

   	 	$response = $data = array();

   	 	$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}

   	 	$cart = $this->custom_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));
   	 	if(!empty($cart)) $content = unserialize($cart[0]['content']);
   	 	$adel = array();
   	 	if (!empty($content)) {
			$default_tax = $this->custom_model->get_admin_option("default_tax");		
			foreach ($content as $key => $value) {

				$res = $this->this_product_data($value['pid'],$language);
				if ($res)
				{	
					
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
			$cart_count = !empty($content)? count($content):0;

			echo json_encode( array("status" => true,"data" => $data, "total_tax" => $totaltax, "total_shipping" => $totaldel, "total_saved" => $total_saved, "count" => $cart_count) );die;
		}
		else{
			$data = new stdClass();
			echo json_encode( array("status" => false,"data" => $data) );die;
		}
		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * add product to wish list 
	 */
	public function add_to_wish_list()
	{

		$json = file_get_contents('php://input');
		// $json 		= '{"product_id":"13","user_id":"56","type":"remove"}';
		$jsonobj 	= json_decode($json);
		$pid 	= @$jsonobj->product_id;
		// $user_id 	= @$jsonobj->user_id;
		$type 	= @$jsonobj->type;
		$type = empty($type)? 'add':$type;

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		$my_wish = array();

		if (!empty($user_id))
		{
			$wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $user_id,'meta_key' => 'wish_list'));

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
				// $my_wish = array_filter($my_wish);
				
				$this->custom_model->my_update(array('content' => serialize($my_wish)),array('id' => $id),'my_cart');
				
			}
			
			echo json_encode( array("status" => true,"wish_list" => $my_wish) );die;
		}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
		

   	}

	/**
	 * view wish list product
	 */
	public function view_wish_list()
	{

		$json = file_get_contents('php://input');
		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

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
					echo json_encode( array("status" => false,"data" => $data) );die;
				}
				foreach ($my_wish as $key => $value)
				{
					$res = $this->this_product_data($value,$language);
					if ($res)
					{
						$data['product'][] = $res['curr'];
					}
					/*$curr = $this->custom_model->my_where('product','*',array('id'=>$value));
					if (!empty($curr))
					{
			   	 		if ($language != 'en')
			   	 		{
			   	 			$res = $this->custom_model->my_where("product_trans","*",array('id' => $curr[0]['id']) );
			   	 			if (!empty($res))
			   	 			{
				   	 			$curr[0]['product_name'] = $res[0]['product_name'];
				   	 			$curr[0]['description'] = $res[0]['description'];
				   	 			$curr[0]['product_brand'] = $res[0]['product_brand'];
			   	 			}
			   	 			
			   	 		}
						unset($curr[0]['user_like']);
						unset($curr[0]['rating']);
						unset($curr[0]['sale']);
						unset($curr[0]['slug']);
						unset($curr[0]['product_code']);
						unset($curr[0]['created_date']);
						unset($curr[0]['status']);

						$curr[0]['product_image'] = $this->get_product_path($curr[0]['product_image']);

						$data[] = $curr[0];
					}*/
					
				}
			
				echo json_encode( array("status" => true,"data" => $data) );die;
			}
			else{
				$data = new stdClass();
				echo json_encode( array("status" => false,"data" => $data) );die;

			}

		}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}

   	}
   	/**
   	 * upload_image function
   	 */
   	public function upload_image_insurance()
   	{
   		$uid = 0;
		$language 		= empty($language)? 'en':$language;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);
/*
    	$id = uniqid();
    	$req_dump = "<br/>---------".$id."---------<br/>".print_r( $_REQUEST, true );
    	file_put_contents( 'logs/'.$id.'_request.log', $req_dump );
    	$ser_dump = "<br/>---------".$id."---------<br/>".print_r( $_SERVER, true );
    	file_put_contents( 'logs/'.$id.'_server.log', $ser_dump );
    	$file_dump = "<br/>---------".$id."---------<br/>".file_get_contents( 'php://input' );
    	file_put_contents( 'logs/'.$id.'_file.log', $file_dump );
    	$fil_dump = "<br/>---------".$id."---------<br/>".print_r( $_FILES, true );
    	file_put_contents( 'logs/'.$id.'_fil.log', $fil_dump );
*/
   	    $FILES = @$_FILES['club_image'];
    	if(!empty($FILES)){
    				if(isset($FILES["type"]))
    				{
    					$details = array( "caption" => "My Logo", "action" => "fiu_upload_file", "path" => "admin/usersdata/insurance/" );
    					$path = $details['path'];
    					$upload_dir =  ASSETS_PATH.$path;
    					if (!file_exists($upload_dir)) {
    						mkdir($upload_dir, 0777, true);
    					}
    					$newFileName = time().rand(100,999);
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
    												'path' => $upload_dir,
    												'user_id' => $uid);
    							$img_id = $this->custom_model->my_insert($post_data,'image_master');
    						echo json_encode( array( "status" => true,"data" => $newFileName, "url" => base_url("assets/admin/usersdata/insurance/").$newFileName ) );die;
    						}
    						else
    						{
    							echo json_encode( array( "status" => false,"data" => "Please try again." ) );die;
    						}
    					}
    					else
    					{ 
    						echo json_encode( array( "status" => false,"data" => "Please upload valid image." ) );die;
    					}
    				}
    	}else{
    		echo json_encode( array( "status" => false,"data" => "Please upload image." ) );die;
    	}
	    
   	}

    public function upload_image_prescription()
   	{
   		$uid = 0;
   		
		$language 		= empty($language)? 'en':$language;
		$ws 			= empty($ws)? 'vendor':$ws;
		//$user_id 		= 1279;
		$user_id = $this->validate_token($language,$ws);

/*
    	$id = uniqid();
    	$req_dump = "<br/>---------".$id."---------<br/>".print_r( $_REQUEST, true );
    	file_put_contents( 'logs/'.$id.'_request.log', $req_dump );
    	$ser_dump = "<br/>---------".$id."---------<br/>".print_r( $_SERVER, true );
    	file_put_contents( 'logs/'.$id.'_server.log', $ser_dump );
    	$file_dump = "<br/>---------".$id."---------<br/>".file_get_contents( 'php://input' );
    	file_put_contents( 'logs/'.$id.'_file.log', $file_dump );
    	$fil_dump = "<br/>---------".$id."---------<br/>".print_r( $_FILES, true );
    	file_put_contents( 'logs/'.$id.'_fil.log', $fil_dump );
*/
   	    $FILES = @$_FILES['club_image'];
    	if(!empty($FILES)){
    				if(isset($FILES["type"]))
    				{
    					$details = array( "caption" => "My Logo", "action" => "fiu_upload_file", "path" => "admin/usersdata/prescription/" );
    					$path = $details['path'];
    					$upload_dir =  ASSETS_PATH.$path;
    					if (!file_exists($upload_dir)) {
    						mkdir($upload_dir, 0777, true);
    					}
    					$newFileName = time().rand(100,999);
    					$target_file = $upload_dir . basename($FILES["name"]);
    					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    					$newFileName = $newFileName.".".$imageFileType;
    					$target_file = $upload_dir.$newFileName;

    					list($width, $height, $type, $attr)= getimagesize($FILES["tmp_name"]);
    					$type1 = $FILES['type'];  

    					if ( ( ($imageFileType == "gif") || ($imageFileType == "jpeg") || ($imageFileType == "jpg") || ($imageFileType == "png") ) )
    					{
    						// print_r($FILES["tmp_name"]);
    						// echo ">>>>>>>";
    						// print_r($target_file);
    						// die;


    						if (move_uploaded_file($FILES["tmp_name"], $target_file)) 
    						{
    							$post_data = array('name' => $newFileName,
    												'path' => $upload_dir,
    												'user_id' => $uid);
    							$img_id = $this->custom_model->my_insert($post_data,'image_master');
    							echo json_encode( array( "status" => true,"data" => $newFileName, "url" => base_url("assets/admin/usersdata/prescription/").$newFileName ) );die;
    						}
    						else
    						{
    							echo json_encode( array( "status" => false,"data" => "Please try again." ) );die;
    						}
    					}
    					else
    					{ 
    						echo json_encode( array( "status" => false,"data" => "Please upload valid image." ) );die;
    					}
    				}
    	}else{
    		echo json_encode( array( "status" => false,"data" => "Please upload image." ) );die;
    	}
	    
   	}

   	public function upload_image_document()
   	{
   		$uid = 0;
   		
		$language 		= empty($language)? 'en':$language;
		$ws 			= empty($ws)? 'vendor':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

/*
    	$id = uniqid();
    	$req_dump = "<br/>---------".$id."---------<br/>".print_r( $_REQUEST, true );
    	file_put_contents( 'logs/'.$id.'_request.log', $req_dump );
    	$ser_dump = "<br/>---------".$id."---------<br/>".print_r( $_SERVER, true );
    	file_put_contents( 'logs/'.$id.'_server.log', $ser_dump );
    	$file_dump = "<br/>---------".$id."---------<br/>".file_get_contents( 'php://input' );
    	file_put_contents( 'logs/'.$id.'_file.log', $file_dump );
    	$fil_dump = "<br/>---------".$id."---------<br/>".print_r( $_FILES, true );
    	file_put_contents( 'logs/'.$id.'_fil.log', $fil_dump );
*/
   	    $FILES = @$_FILES['club_image'];
    	if(!empty($FILES)){
    				if(isset($FILES["type"]))
    				{
    					$details = array( "caption" => "My Logo", "action" => "fiu_upload_file", "path" => "admin/usersdata/upload_document/" );
    					$path = $details['path'];
    					$upload_dir =  ASSETS_PATH.$path;
    					if (!file_exists($upload_dir)) {
    						mkdir($upload_dir, 0777, true);
    					}
    					$newFileName = time().rand(100,999);
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
    												'path' => $upload_dir,
    												'user_id' => $uid);
    							$img_id = $this->custom_model->my_insert($post_data,'image_master');
    							echo json_encode( array( "status" => true,"data" => $newFileName, "url" => base_url("assets/admin/usersdata/upload_document/").$newFileName ) );die;
    						}
    						else
    						{
    							echo json_encode( array( "status" => false,"data" => "Please try again." ) );die;
    						}
    					}
    					else
    					{ 
    						echo json_encode( array( "status" => false,"data" => "Please upload valid image." ) );die;
    					}
    				}
    	}else{
    		echo json_encode( array( "status" => false,"data" => "Please upload image." ) );die;
    	}
	    
   	}

	/**
	 * place_order function
	 */
	public function place_order()
	{
		$uid = 0;
	    $language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$uid = $this->validate_token($language,$ws);

		//$uid = 1340
		//$uid = 1273;
		$json = file_get_contents('php://input');
		
       //$json = '{"source":"android","name":"Akshay","email":"patient@akshay.com","mobile_no":"997777777777777","pname":"Akshay chavan","paddress":"karad","patient_height":"6","patient_weight":"60","sex":"Male","patient_birth_of_date":"25\/1\/2019","physician_name":"jebeb","physician_facility_name":"heh","physician_facility_address":"berrbbebrbr","physician_npi":"hrbrbrbbrbr","physician_licence":"hrhhrhrhdh","physician_fax":"9595989898","physician_phone":"59595967989","physician_email":"ebbdbd@sjdn.com","order_date":"25\/1\/2019","name_of_order":"asddfggh","qty_dosage":"lkkknnbbbb","order_notes":"j383374u4u4u5u","diag_code":"asddffkk","diag_desc":"nnnnnbbw","dme_id":"76588","vender_id":"","delivery_address":"hdhrhrhhr","house_number":"hebrbrbbr","delivery_locality":"hrhrhrhrh","delivery_street":"hebebbe","delivery_city":"hrhrhrh","delivery_country":"hrhrhthh","delivery_zip":"hrhrhth5h3","Payment_mode":"insurance payment","delivery_type":"store_pickup","exp_month":"","exp_year":"","insurance_meta":"","prescription_meta":"","delivery_state":"","address":"hdhrhrhhr","address_1":"hebrbrbbr","address_2":"hrhrhrhrh","country":"hrhrhthh","state":"hebebbe","city":"hrhrhrh","pincode":"hrhrhth5h3","signature_img":[{"signature_img":"1548408288776.jpg"}],"insurance":[{"name":"primary insurance","number":"insurance number primary","front_view":"1548406284987.jpg","back_view":"1548406288764.jpg"}],"prescription":[{"prescription_img":""}]}';

		/*$json = '{"source":"android","name":"jdjd","email":"nnfnfn@jdjd.com","mobile_no":"495989989899","pname":"jdjd ndnfbfbbrb","paddress":"ddbbr","patient_height":"959","patient_weight":"959599","sex":"Male","patient_birth_of_date":"31\/1\/2019","physician_name":"enene","physician_facility_name":"ebrbrb","physician_facility_address":"b3bebb","physician_npi":"bebrbrbb","physician_licence":"bebrbrb","physician_fax":"959959595","physician_phone":"9192929","physician_email":"bebrbb@jje.com","order_date":"31\/1\/2019","name_of_order":"ndbdbrb","qty_dosage":"brbrbrb","order_notes":"jebrb","diag_code":"rbrbb","diag_desc":"bbbrrb","dme_id":"","vender_id":"","delivery_address":"bebeb","house_number":"bebrbb","delivery_locality":"bebrbb","delivery_street":"bebbebr","delivery_city":"bebebbr","delivery_country":"bebrbb","delivery_zip":"bebrbrbbrb","Payment_mode":"insurance payment","delivery_type":"Home","exp_month":"","exp_year":"","insurance_meta":"","prescription_meta":"","delivery_state":"","address":"bebeb","address_1":"bebrbb","address_2":"bebrbb","country":"bebrbb","state":"bebbebr","city":"bebebbr","pincode":"bebrbrbbrb","signature_img":[{"signature_img":"1548918575310.jpg"}],"insurance":[],"prescription":[{"prescription_img":"1548918535407.jpg"}]}';*/
		  


		   
		$jsonobj 	= json_decode($json);
   	 	$response = $data = $post_arr = array();

		// CONTACT DETAILS
		
	//	$post_arr['customer_id'] 		= @$jsonobj->uid;
		
		$post_arr['name'] 		= @$jsonobj->name;
		$post_arr['email']      = @$jsonobj->email;
		$post_arr['mobile_no'] 	= @$jsonobj->mobile_no;
		// address details
		$post_arr['address'] 	= @$jsonobj->address;
		$post_arr['house_number'] 	= @$jsonobj->house_number;

		$post_arr['vender_id'] 		      = @$jsonobj->vender_id;
		
		$post_arr['sex'] 	       			= @$jsonobj->sex;
		$post_arr['insurance_meta'] 	    = @$jsonobj->insurance_meta;
		$post_arr['prescription_meta'] 	    = @$jsonobj->prescription_meta;
		$post_arr['exp_month'] 	    		= @$jsonobj->exp_month;
		$post_arr['exp_year'] 	    		= @$jsonobj->exp_year;
		$post_arr['diag_code'] 	    		= @$jsonobj->diag_code;
		$post_arr['diag_desc'] 	    		= @$jsonobj->diag_desc;


		$post_arr['pname'] 	            = @$jsonobj->pname;
		$post_arr['paddress'] 	        = @$jsonobj->paddress;
		$post_arr['source'] 	        = @$jsonobj->source;
		
		$post_arr['patient_height'] 	        = @$jsonobj->patient_height;
		$post_arr['patient_weight'] 		    = @$jsonobj->patient_weight;
		$post_arr['patient_birth_of_date'] 		= @$jsonobj->patient_birth_of_date;
		// BILLING INFORMATION
		
        // 		$post_arr['card_type'] 		= @$jsonobj->card_type;
        // 		$post_arr['card_number'] 	= @$jsonobj->card_number;
        // 		$post_arr['card_name'] 		= @$jsonobj->card_name;
        // 		$post_arr['cvv'] 		    = @$jsonobj->cvv;
        
        $pharmacy_img 		      = @$jsonobj->pharmacy_img;
        if($pharmacy_img)
        {
            $post_arr['pharmacy_img'] 		      = @$jsonobj->pharmacy_img;    
        }
		

		
		$post_arr['physician_name'] 		  = @$jsonobj->physician_name;
		$post_arr['physician_facility_name']  = @$jsonobj->physician_facility_name;
		$post_arr['physician_facility_address']= @$jsonobj->physician_facility_address;

		$post_arr['physician_npi'] 		= @$jsonobj->physician_npi;
		$post_arr['physician_licence'] 	= @$jsonobj->physician_licence;
		$post_arr['physician_phone']    = @$jsonobj->physician_phone;
		$post_arr['physician_fax'] 		= @$jsonobj->physician_fax;
		$post_arr['physician_email'] 	= @$jsonobj->physician_email;

		$post_arr['name_of_order'] 	    = @$jsonobj->name_of_order;
		$post_arr['qty_dosage'] 	    = @$jsonobj->qty_dosage;
		$post_arr['order_date'] 	    = @$jsonobj->order_date;
		$post_arr['order_notes'] 	    = @$jsonobj->order_notes;
		$post_arr['dme_id'] 	    = @$jsonobj->dme_id;
		$post_arr['delivery_address']   = @$jsonobj->delivery_address;

		$post_arr['delivery_locality']  = @$jsonobj->delivery_locality;
		$post_arr['delivery_street'] 	= @$jsonobj->delivery_street;  
		$post_arr['delivery_city'] 		= @$jsonobj->delivery_city;
		$post_arr['delivery_state'] 	= @$jsonobj->delivery_state;
		$post_arr['delivery_country']   = @$jsonobj->delivery_country;
		$post_arr['delivery_zip']       = @$jsonobj->delivery_zip;
        $post_arr['payment_mode'] 		= @$jsonobj->payment_mode;
        $post_arr['delivery_type'] 		= @$jsonobj->delivery_type;
		$post_insur       = @$jsonobj->insurance;
		$post_pre       = @$jsonobj->prescription;
		$post_sig      = @$jsonobj->signature_img;
        
        // echo "<pre>";
        // print_r($post_pre);
        // die;
		// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];
		
		$ecommerce      				= @$jsonobj->ecommerce;
		
		if (empty($uid))
		{
			$status = $this->create_new_guest_user($json);
			$uid = $status['response']['user_id'];
		}
		
		$this->load->library('place_order');
		$response = $this->place_order->create_order($post_arr,$uid,$post_insur,$post_pre,$post_sig);
		
		// echo "<pre>";
		// print_r($response);
		// die;

	if ($response)
		{
			$display_order_id = $response['display_order_id'];

			if ($ecommerce)
			{
				$address_1 		= @$jsonobj->address_1;
				$address_2 		= @$jsonobj->address_2;
				$country 		= @$jsonobj->country;
				$state  		= @$jsonobj->state;
				$city  			= @$jsonobj->city;
				$pincode  		= @$jsonobj->pincode;
				$products  		= @$jsonobj->products;

				$this->custom_model->my_update(array("payment_status" => 'unpaid',"payment_mode" => 'insurance',"address_1" => $address_1,"address_2" => $address_2,"country" => $country,"state" => $state,"city" => $city,"pincode" => $pincode),array("display_order_id" => $display_order_id),"order_master" );

				if ($ecommerce == 'guest')
				{

					// $status = $this->create_new_guest_user($json);
					// $uid = $status['response']['user_id'];

					// echo "<pre>";
					// print_r($status);
					// print_r($uid);
					// die;
					
					$this->load->library('place_order_version_one_for_ecommerce');
					$response_get = $this->place_order_version_one_for_ecommerce->create_order($display_order_id, $products, $uid);
				}
				else if ($ecommerce == 'buy_now')
				{
					// $status = $this->create_new_guest_user($json);
					// $uid = $status['response']['user_id'];
					
					$this->load->library('place_order_version_one_for_ecommerce');
					$response_get = $this->place_order_version_one_for_ecommerce->create_order($display_order_id, $products, $uid);
				}
				else if($ecommerce == 'normal' &&  !empty($uid))
				{
					$cart = $this->custom_model->my_where('my_cart','content',array('user_id'=>$uid,'meta_key' => 'cart'));
                    
                    // echo "<pre>";
                    // print_r($cart);
                    // die;
                    
					if(!empty($cart)) $content = unserialize($cart[0]['content']);

					$adel = array();
			   	 	if (!empty($content)) {

						foreach ($content as $key => $value) {
							$res = $this->this_product_data($value['pid'],$language);

							if ($res)
							{
								$append = $value['pid'];

								// $wish_arr = $this->custom_model->my_where('my_cart','id,content',array('user_id' => $uid,'meta_key' => 'wish_list'));

								// if(!empty($wish_arr)) $my_wish = unserialize($wish_arr[0]['content']);

								// echo "<pre>";
								// $data1[$key]['is_in_wish_list'] = !empty($my_wish) && in_array($append, $my_wish)? 1:0;
								// print_r($append);
								// print_r($append);

								if(!empty($value['metadata']))
								{
			                        foreach ($value['metadata'] as $pkey => $pvalue) {
			    						$append .= 'm'.$pvalue;
			    					}
								}

								// print_r($append);
								// echo "<br>";
								// if ($res['curr']['stock'] < $value['qty'] && $res['curr']['stock'] != 0)
								// {
								// 	$this->load->library('user_account');
								//     $this->user_account->add_remove_cart($value['pid'],$uid,'add',$res['curr']['stock']);

								// 	$error[] = 'Quantity of '.$res['curr']['product_name'].' is reduced.';
								// 	$value['qty'] = $res['curr']['stock'];
									
								// }
								// elseif ($res['curr']['stock_status'] == 'notinstock' || $res['curr']['stock'] == 0)
								// {
								// 	$this->load->library('user_account');
								// 	$this->wish_list_actions($uid, $value['pid'], 'add');
								// 	$this->user_account->add_remove_cart($append,$uid,'remove_version1');
								// 	$error[] = $res['curr']['product_name'].lang('product_moved_wishlist');
								// 	continue;
								// }


			                   
			                    $price = $res['curr']['price'] * $value['qty'];
			                    $sale_price = $res['curr']['sale_price'] * $value['qty'];
			                    if(empty($res['curr']['sale_price'])) $sale_price = $price;

			                    // $total_saved += ($price - $sale_price);
								// if(!empty($tax)) $totaltax = $totaltax + ( $sale_price * $tax ) / 100;

								$arr = array_merge($res['curr'], $res['curr1'], array('uqty' => $value['qty']));

								$data['product'][] = $arr;

								$data1[$key]['qty'] = $value['qty'];
								$data1[$key]['pid'] = $res['curr']['id'];
								// $data1[$key]['product_name'] = $res['curr']['product_name'];
								$data1[$key]['insurance'] = $res['curr']['insurance'];
								$data1[$key]['price'] = $res['curr']['price'];
								if (!empty($value['metadata']))
								{
								    
									// echo "<pre>";
									// print_r($value['metadata']);
									// die;
									
									$color = array();
									foreach ($value['metadata'] as $ckey => $cvalue)
									{
										// $wish_arr = $this->custom_model->my_where('attribute_item','id,item_value,a_id',array('id' => $cvalue));
										$wish_arr = $this->custom_model->my_where('attribute_item','id,item_name,a_id',array('item_name' => $cvalue));
                                        	
                                        	// echo $this->db->last_query();
                                        	// echo "<pre>";
								        	// print_r($wish_arr);
								
								
										$color_size_array = $response = array();

										if (@$wish_arr[0]['a_id'] == '19')
										{
											$color = $wish_arr[0]['item_name'];
											if(!empty($color)) $color_size_array['color'] 	= $color;
											$data1[$key]['color'] = $color;
										}
										else
										{
											$size = @$wish_arr[0]['item_name'];
											if(!empty($size)) $color_size_array['size'] 	= $size;
											$data1[$key]['size'] = $size;
										}
									}
									// die;
									
									// echo "<pre>";
									// print_r($value['metadata']);
									// $data1[$key]['metadata'] = $value['metadata'];
								}
								
								// $data1[$key]['metadata'] = !empty($value['metadata'])? $value['metadata']: new stdClass();
							}
						}


						foreach ($data1 as $dkey => $dvalue)
						{
							$insurance = $dvalue['insurance'];
							$attribute = $response = array();
							if(!empty($dvalue['color'])) $attribute['color'] 	= $dvalue['color'];
							if(!empty($dvalue['size'])) $attribute['size'] 		= $dvalue['size'];
							$attribute = json_encode($attribute);
							$data1[$dkey]['attribute'] = $attribute;

							if (!empty($insurance))
							{
								$get_data_display_order_id = $response = array();
								if(!empty($dvalue['qty'])) $get_data_display_order_id['qty'] 		= $dvalue['qty'];
								if(!empty($dvalue['pid'])) $get_data_display_order_id['pid'] 		= $dvalue['pid'];
								if(!empty($dvalue['price'])) $get_data_display_order_id['price'] 	= $dvalue['price'];
								if(!empty($dvalue['color'])) $get_data_display_order_id['color'] 	= $dvalue['color'];
								if(!empty($dvalue['size'])) $get_data_display_order_id['size'] 		= $dvalue['size'];
								if(!empty($attribute)) $get_data_display_order_id['attribute'] 		= $attribute;
								if(!empty($display_order_id)) $get_data_display_order_id['display_order_id'] 		= $display_order_id;

								$item_id = $this->custom_model->my_insert($get_data_display_order_id,'get_data_display_order_id');

								$this->load->library('user_account');
								$this->user_account->add_remove_cart($dkey,$uid,'remove_version1');

								// echo "<pre>";
								// print_r($products);
								// echo "<br>";
							}
						}

						$products = $this->custom_model->get_data("SELECT * FROM get_data_display_order_id WHERE  display_order_id = '$display_order_id' ");
						if (!empty($products))
						{
							foreach ($products as $vkey => $vvaluew)
							{
								// print_r($vvaluew);
								$att = $vvaluew->attribute;
								if (!empty($att))
								{
									$attribute_array = $response = array();
									if(!empty($vvaluew->color)) $attribute_array['color'] 	= $vvaluew->color;
									if(!empty($vvaluew->size)) $attribute_array['size'] 	= $vvaluew->size;
									$products[$vkey]->attribute = $attribute_array;
								}
							}
						}
						// echo "<pre>";
						// print_r($products);

						$this->load->library('place_order_version_one_for_ecommerce');
						$response_get = $this->place_order_version_one_for_ecommerce->create_order($display_order_id, $products, $uid);

						$this->custom_model->my_delete(['display_order_id' => $display_order_id], 'get_data_display_order_id');

						// echo "<pre>";
						// print_r($response_get);
						// die;
					}
				}
				// echo "<pre>";
				// print_r($response_get);
				// die;
				echo json_encode( array("status" => true, "display_order_id" => $display_order_id ,"data" => $response_get) );die;
			}
			
			echo json_encode( array("status" => true,"data" => $response) );die;
		}
		else{
			echo json_encode( array("status" => false,"data" => 'data empty') );die;
		}
		
   	}
   	
   	public function create_new_guest_user($json)
	{
		$Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');

		$jsonobj 		= json_decode($json, True);

		$guest_name  		= @$jsonobj['guest_name'];
		$guest_number  		= @$jsonobj['guest_number'];
		$guest_type  		= @$jsonobj['guest_type'];
		$guest_email  		= @$jsonobj['guest_email'];
		$source  			= @$jsonobj['source'];
		$country_code  		= '91';

		
		// echo "<pre>";
		// print_r($jsonobj);
		// die;


		date_default_timezone_set('Asia/Kolkata');
    	$order_datetime = date("Y-m-d h:i:s");

		if (!empty($guest_email))
			{
				$this->load->model('User_model');

				$additional_data = $response = array();

				if(!empty($country_code)) $additional_data['country_code'] 	= $country_code;
				if(!empty($guest_name)) $additional_data['first_name'] 	= $guest_name;
				if(!empty($guest_number)) $additional_data['phone'] 	= $guest_number;
				if(!empty($guest_type)) $additional_data['type'] 		= $guest_type;
				if(!empty($guest_email)) $additional_data['username'] 	= $guest_email;
				if(!empty($guest_email)) $additional_data['email'] 		= $guest_email;
				if(!empty($guest_number)) $additional_data['password'] 	= password_hash($guest_number, PASSWORD_BCRYPT);
		        $additional_data['active'] 								= 1;
		        $additional_data['created_on'] 							= time();
		        if(!empty($source)) $additional_data['source'] 			= $source;
		        $additional_data = $additional_data;
		        
		        

				$query = $this->User_model->create_member($additional_data);

				if ($query == 'email' || $query == 'phone')
				{
					$user = $this->custom_model->my_where('users','*',array('email' => $guest_email),array(),"","","","", array(), "",array(),false );
					$user1 = $this->custom_model->my_where('users','*',array('email' => $guest_number),array(),"","","","", array(), "",array(),false );

					if (!empty($user))
					{
						$query = $user[0]['id'];
					}
					elseif (condition) {
						$query = $user1[0]['id'];
					}
				}
				else
				{
					$message = '<h6 style="font-size: 15px; margin-top: -10px;"> Hi there '.$guset_name.'!,</6><br/>
						        		<p style="font-size: 12px; color:#696969;">
						                Thank you for creating a Medical Supply Manager account. You’re all ready to go!

						                <p style="font-size: 12px; color:#696969;">
							                Username = '.$guest_email.'
							                <br>Password = '.$guest_number.'
							            </p>

						                Medical Supply Manager is market place for all health related products. Medical Supply Manager 
						                makes the consumer easy to purchase the items from different seller
						                in best price.</p>';

		        	$emails = $guest_email;
					$subject = "Welcome to Medical Supply Manager";
					send_email($emails,$subject,$message);

				}

				$user = $this->custom_model->my_where('users','*',array('id' => $query),array(),"","","","", array(), "",array(),false );

				unset($user[0]['password']);   
				unset($user[0]['salt']);
				unset($user[0]['ip_address']);
				unset($user[0]['activation_code']);
				unset($user[0]['forgotten_password_code']);
				unset($user[0]['forgotten_password_time']);
				unset($user[0]['remember_code']);

				$response["token"] = $Jwt_client->encode( array( "password" => $guest_number,"id" => $user[0]['id'] ) );

				$this->custom_model->my_update(['token' => $response["token"]], ['id' => $user[0]['id']], 'users');

				$response['status'] = true;

				$response["user"] = $user;
				$wish_list = $this->custom_model->my_where('my_cart','content',array('user_id' => $query,'meta_key' => 'wish_list'));
				$response["wish_list"] = isset($wish_list[0]['content']) && !empty($wish_list[0]['content'])? unserialize($wish_list[0]['content']):'';

				// send mail
				
				$response['user_id'] = $query;
				$response['status'] = true;
				$response['message'] = 'Account Successfully Created';

				// echo "<pre>";
				// print_r($response);
				// die;
				return ['status'=>'success','response' => $response];
			}
			else{
			    return ['status'=>'error'];
			}		
   	}

   	
   	   	public function insert_signature()
   		{	
   		    $uid = 0;
   			$oid = 0;

   		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


   			
   			//$uid = 1;
   			$json = file_get_contents('php://input');
   	
   			//$json = '{"prescription_img":"img.jpg","status":"1"}'; 


   			/*$json = '{ "signature_img" : [
		    			         {
		    			            "signature_img"	: "img.jpg",
		    			            "status"	: "1"
		    			         
		    			         },
		    			         {
		    			            "signature_img"	: "img.jpg",
		    			            "status"	: "1"

		    			         

		    			         }
		    			        
		    			               ] }';      */
   		 
   			$jsonobj 	= json_decode($json);
   	   	 	$response = $data = $post_sig = array();

   			
   			//$post_pre['prescription_img'] 		= @$jsonobj->prescription_img;
   			//$post_pre['status']                 = @$jsonobj->status;


   	   	 	$post_sig       = @$jsonobj->signature_img;

   			//print_r($post_pre);die;
   		
   			
   		
   			$this->load->library('place_order');
   			$response = $this->place_order->insert_signature($uid,$post_sig,$oid);



   			if ($response)
   			{
   				echo json_encode( array("status" => true,"data" => $response) );die;
   			}
   			else{
   				echo json_encode( array("status" => false,"data" => 'data empty') );die;
   			}
   			
   	   	}



   		public function insert_prescription()
   		{	//$uid = 0;
   			$oid = 0;
   			


   		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

   			
   			//$uid = 1;
   			$json = file_get_contents('php://input');
   	
   			//$json = '{"prescription_img":"img.jpg","status":"1"}'; 


   			/*$json = '{ "prescription" : [
		    			         {
		    			            "prescription_img"	: "img.jpg",
		    			            "status"	: "1"
		    			         
		    			         },
		    			         {
		    			            "prescription_img"	: "img.jpg",
		    			            "status"	: "1"

		    			         

		    			         }
		    			        
		    			               ] }';      */
   		 
   			$jsonobj 	= json_decode($json);
   	   	 	$response = $data = $post_pre = array();

   			
   			//$post_pre['prescription_img'] 		= @$jsonobj->prescription_img;
   			//$post_pre['status']                 = @$jsonobj->status;


   	   	 	$post_pre       = @$jsonobj->prescription;

   			//print_r($post_pre);die;
   		
   			
   		
   			$this->load->library('place_order');
   			$response = $this->place_order->insert_prescription($uid,$post_pre,$oid);



   			if ($response)
   			{
   				echo json_encode( array("status" => true,"data" => $response) );die;
   			}
   			else{
   				echo json_encode( array("status" => false,"data" => 'data empty') );die;
   			}
   			
   	   	}

   	   	/** 
		Upload Documents
   	   	**/

   	   	public function insert_document()
   		{
   			$json = file_get_contents('php://input');
			$jsonobj 		= json_decode($json);

			$oid  			= @$jsonobj->order_id;
			$status  		= @$jsonobj->status;
   	   	 	$post_pre       = @$jsonobj->prescription;

   		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'insert_document':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

      	   	if (!empty($post_pre))
	        {
				foreach ($post_pre as $skey => $value1)
			    {
	        		//print_r($value1);
					$prescription = $value1->prescription_img;
					// $status = $value1->status;
					// $order_id = $value1->order_id;

					$post_pre1 = array(
		                'document_img' => $prescription,
		                'status' => $status,
		                'order_id' => $oid,
						'user_id' => $uid
	               	);
					// print_r($post_pre1);
					$data = $this->custom_model->my_insert($post_pre1,' upload_document');
	       		}

	       		echo json_encode( array("status" => true,"data" => $response) );die;
			}
   			else{
   				echo json_encode( array("status" => false,"data" => 'data empty') );die;
   			}
   			
   	   	}

   	   		public function insert_insurance()
   	   		{	//$uid = 0;
   	   			$oid = 0;
   	   			
   	   			$language 		= @$jsonobj->language;
				$language 		= empty($language)? 'en':$language;
				$ws 			= @$jsonobj->ws;
				$ws 			= empty($ws)? 'place_order':$ws;
				// $user_id 		= 627;
				$uid = $this->validate_token($language,$ws);


   	   			
   	   			//$uid = 1;
   	   			$json = file_get_contents('php://input');
   	   	
   	   			//$json = '{"prescription_img":"img.jpg","status":"1"}'; 

/*
   	   			$json = '{ "insurance"	: [
						        {
						            "name"	: "bajaj",
						            "number"	: "12345",
						            "front_view"	: "insurance.jpg",
						            "back_view"	: "insurance.jpg"
						        },
						        {
						            "name"	: "max_life",
						            "number"	: "123456",
						            "front_view"	: "insurance.jpg",
						            "back_view"	: "insurance.jpg"

						        }
						       
						    ]
                          }';      */
   	   		 
   	   			$jsonobj 	= json_decode($json);
   	   	   	 	$response = $data = $post_pre = array();

   	   			
   	   			//$post_pre['prescription_img'] 		= @$jsonobj->prescription_img;
   	   			//$post_pre['status']                 = @$jsonobj->status;


   	   	   	 	$post_insur       = @$jsonobj->insurance;

   	   			//print_r($post_pre);die;
   	   		
   	   			
   	   		
   	   			$this->load->library('place_order');
   	   			$response = $this->place_order->insert_insurance($uid,$post_insur,$oid);



   	   			if ($response)
   	   			{
   	   				echo json_encode( array("status" => true,"data" => $response) );die;
   	   			}
   	   			else{
   	   				echo json_encode( array("status" => false,"data" => 'data empty') );die;
   	   			}
   	   			
   	   	   	}



	/**
	 * Login page and submission
	 */
public function login()
{
		
		$Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');

  		//$json 		= file_get_contents('php://input');
		
		//$json 		= '{"email":"viii2236@gmail.com","password":"123456"}';
		$jsonobj 	= json_decode($json);

		$language 	= @$jsonobj->language;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'login':$ws;
		$user_id = $this->validate_token($language , $ws);

		$password 	= @$jsonobj->password;
		$email 		= @$jsonobj->email;
		$source 	= empty($source)? 'normal':$source;

		if (empty($email) || empty($password)) {
			echo json_encode(array("status" => false,"message" => "All fields are required." ));
			die;
		}
		$logged_in = $this->ion_auth->user_login($email, $password, FALSE);

		// result
		if ($logged_in)
		{	

			$user = $logged_in;
	
			// TODO: append API key
			$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user[0]->id ) );
			$user_id = $user[0]->id;
			$this->custom_model->my_update(array("language" => $language,"source" =>$source , "token"=> $response["token"] ),array("id" => $user_id),"users");
			$uid = $user[0]->id;

			$u_details = $this->custom_model->get_data("SELECT * FROM users WHERE id = $user_id  ORDER BY 'id' DESC");

			unset($u_details[0]->password);
			unset($u_details[0]->salt);
			unset($u_details[0]->ip_address);
			unset($u_details[0]->activation_code);
			unset($u_details[0]->forgotten_password_code);
			unset($u_details[0]->forgotten_password_time);
			unset($u_details[0]->remember_code);

			$response["user"] = $u_details;

			// return result
			echo json_encode( $response );
		}
		else
		{
			echo json_encode(array("status" => false,"message" => "Incorrect Login." ));
		}
		die;
	}

	/**
	 * country_code list
	 */
	 
	public function country_code()
	{
		
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$uid = $this->validate_token($language,$ws);

	    $data = $this->custom_model->my_where('country', 'phonecode,iso,name', array(), array(), "", "", "phonecode");
	    if($data){
	    	$response["status"] = true;
	    	$response["data"] = $data;
	    }else{
	    	$response["status"] = false;
	    }
	    echo json_encode( $response );die;
	}
	/**
	 * sign_up page and submission
	 */
	public function sign_up()
	{
		$Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');

		// $json 		= '{"full_name":"vishal karande","password":"123123","email":"vk@app.in","phone":"1236511232","source":"Android","city":"kolhapur","country":"india","area_code":"0145","address":"market yaed kolhpaur","gender":"male","age":"28"}';
                   
		$jsonobj 	= json_decode($json);

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'sign_up':$ws;
		// $user_id 		= 627;
		$uid 		= $this->validate_token($language,$ws);

		$email 			= @$jsonobj->email;
		$username 		= $email;
		$full_name 		= @$jsonobj->full_name;
		$password 		= @$jsonobj->password;
		$source 		= @$jsonobj->source;
		$city 			= @$jsonobj->city;
		$phone 			= @$jsonobj->phone;
		$country 		= @$jsonobj->country;
		$gender 	    = @$jsonobj->gender;
		$age 	    = @$jsonobj->age;
		$area_code 	    = @$jsonobj->area_code;
		$source 		= empty($source)? 'normal':$source;

		
		if(empty($email) || strlen($email) > 50 || filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	    	echo json_encode( array("status" => false,"message" => "Please enter valid email address.") );die;
	    }
	    if(empty($password) || strlen($password) > 35 ){
	    	echo json_encode( array("status" => false,"message" => "Please enter valid password.") );die;
	    }
		if (empty($password) && strlen($password) < 6 ){
		  echo json_encode(array("status" => false,"message" => trim("Please enter password atleast 6 character") )); die;
		}
		if (empty($full_name)) {
		  echo json_encode(array("status" => false,"message" => trim("Please Enter a first name") )); die;
		}

		$this->load->model('User_model');

		
		$additional_data = $response = array();
		if(!empty($country)) $additional_data['country'] = $country;
		if(!empty($full_name)) $additional_data['full_name'] = $full_name;
		if(!empty($area_code)) $additional_data['area_code'] = $area_code;
		if(!empty($phone)) $additional_data['phone'] = $phone;
		if(!empty($city)) $additional_data['city'] = $city;
		if(!empty($age)) $additional_data['age'] = $age;
		if(!empty($gender)) $additional_data['gender'] = $gender;
		if(!empty($email)) $additional_data['username'] = $email;
		if(!empty($email)) $additional_data['email'] = $email;
		

		if(!empty($password)) $additional_data['password'] = password_hash($password, PASSWORD_BCRYPT);

        $additional_data['active'] = 1;
        $additional_data['created_on'] = time();
        if(!empty($source)) $additional_data['source'] = $source;
        $additional_data = $additional_data;

        
        // echo "<pre>";
        // print_r($additional_data);
        // die;

		$query = $this->User_model->create_member($additional_data);
		
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
		else
		{
			$user = $this->custom_model->my_where('users','*',array('id' => $query),array(),"","","","", array(), "",array(),false );

			unset($user[0]['password']);   
			unset($user[0]['salt']);
			unset($user[0]['ip_address']);
			unset($user[0]['activation_code']);
			unset($user[0]['forgotten_password_code']);
			unset($user[0]['forgotten_password_time']);
			unset($user[0]['remember_code']);

			$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user[0]['id'] ) );

			$this->custom_model->my_update(['token' => $response["token"]], ['id' => $user[0]['id']], 'users');

			$response['status'] = true;
			$response["user"] = $user;


			// send mail
			$message = "<h6 style='font-size: 15px; margin-top: -10px;'> Hi ".$full_name."</h6><br/>
					        		<p style='font-size: 12px; color:#696969;'>
					                Thank you for creating a RAI</p>";

        	$emails = $email;
			$subject = "Welcome to RAI";
			send_email($emails,$subject,$message);

			$response['status'] = true;
			$response['ws'] = $ws;
			$response['message'] = 'Account Successfully Created';
			
			echo json_encode($response);die;
		}
	}


	public function resend_otp()
	{

		$Jwt_client = new Jwt_client();
		$json = file_get_contents('php://input');
		//$json = '{"mobile":"8551995731","email":"vishal@appristine.in","language":"en","country_code":"+91"}';
		$jsonobj 		= json_decode($json);
		$mobile 		=  @$jsonobj->mobile;
		$email 			=  @$jsonobj->email;
		$country_code 		=  @$jsonobj->country_code;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'resend_otp':$ws;

		$user_id = $this->validate_token($language , $ws);


		if (empty($user_id))
		{
			$user_id = array();
		}
		$check_otpveify = $country_code.$mobile;
		if (!empty($mobile) && !empty($email))
		{
			//send otp to mobile
			$digits = 4;
			$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
			$check = $this->custom_model->record_count('otp_verify', ['phone' => $check_otpveify]);	
			// print_r($check);
			// die;		

			if ($check)
			{
				$this->custom_model->my_update(['otp' => $otp], ['phone' => $check_otpveify], 'otp_verify');

				$message = '' .$otp. ' is your MSM one time password. OTP is confidential. For security reasons, Do NOT share this OTP with anyone.';

				//echo "string";
				$emails = $email;
				$subject = "OTP Verification MSM";
				send_email($emails,$subject,$message);
				$this->load->library('twilio');
				$sms = $this->twilio->send_sms($check_otpveify,$message);

				echo json_encode( array("status" => true, "ws" => $ws, "message" => " Resend OTP successfully",'otp' => $otp ));die;
			}
			else
			{
				// $this->custom_model->my_insert(['otp' => $otp, 'phone' => $mobile,'user_id' => $user_id],'otp_verify');

				echo json_encode( array("status" => false, "ws" => $ws, "message" => "Invalid Request"));die;
			}
			
		}
	}
	/* End */

	/**
	 * profile function
	 */
	public function profile_info()
	{
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'profile_info':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// $json = '{"full_name":"asd","email":"vj@gmail.com","phone":"9552548220","country":"country","area_code":"area_code","city":"city","type":"save"}';

		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;
		$email 	= @$jsonobj->email;
		$full_name 	= @$jsonobj->full_name;
		$phone 	= @$jsonobj->phone;
		//$password 	= @$jsonobj->password;
		$country 	= @$jsonobj->country;
		$city 	= @$jsonobj->city;
		$area_code 	= @$jsonobj->area_code;
		$type 	= @$jsonobj->type;
   	 	$response = array();

   	 	if (!empty($user_id))
   	 	{
	   	 	if($type == "save")
			{
				// $password =password_hash($password, PASSWORD_BCRYPT);
				$res1 = $this->custom_model->my_where("users","*",array("phone" => $phone, "id !=" => $user_id),array(),"","","","", array(), "",array(),false  );
				if (!empty($res1))
				{
					echo json_encode( array("status" => false,"message" => 'Phone number already exists.') );die;
				}
				$res2 = $this->custom_model->my_where("users","*",array("email" => $email,"id !=" => $user_id),array(),"","","","", array(), "",array(),false  );
				if (!empty($res2))
				{
					echo json_encode( array("status" => false,"message" => 'Email Id already exists.') );die;
				}

				$this->custom_model->my_update(array("full_name" => $full_name,"city" => $city,"country" => $country,"area_code" => $area_code,"username" => $email,"email" => $email,"phone" => $phone),array("id" => $user_id),"users" );
				$response["message"] = "Profile updated successfully.";
			}

			$data = $this->custom_model->my_where("users","*",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );
			$response["status"] = true;
			$response["data"] = $data[0];
			echo json_encode( $response );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
   	}

	/**
	 * order_history 
	 */
	public function order_history()
	{

		$json = file_get_contents('php://input');
		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$uid = $this->validate_token($language,$ws);


		$language 	= @$jsonobj->language;
		$language = empty($language)? 'en':$language;
   	 	$response = array();
   	 	

		if (!empty($uid))
		{
			$data = array();
			$data = $this->custom_model->my_where("order_master","*",array("user_id" => $uid) );
			if (!empty($data))
			{
				echo json_encode( array("status" => true,"data" => $data) );die;
			}
			else{
	   	 		$response['status'] = false;
				$response['message'] = 'No orders yet!';
				echo json_encode($response);die;
	   	 	}

		}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
   	}

	/**
	 * address_book function
	 */
	public function address_book()
	{
		

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		// $json 		= '{"category":"30","vendor":"bonafide-restaurant"}';
		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;
		$email 	= @$jsonobj->email;
		$address_name 	= @$jsonobj->address_name;
		$address_1 	= @$jsonobj->address_1;
		$address_2 	= @$jsonobj->address_2;
		$city 	= @$jsonobj->city;
		$country 	= @$jsonobj->country;
		$state 	= @$jsonobj->state;
		$phone 	= @$jsonobj->phone;
		$type 	= @$jsonobj->type;
   	 	$response = array();

   	 	if (!empty($user_id))
   	 	{
   	 		if($type == "save")
   	 		{
				
				$this->custom_model->my_update(array("address_name" => $address_name,"address_1" => $address_1,"address_2" => $address_2,"city" => $city,"country" => $country,"state" => $state,"phone" => $phone),array("id" => $user_id),"users");
				
			}

			$data = $this->custom_model->my_where("users","*",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );

			echo json_encode( array("status" => true,"data" => $data[0]) );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
		
   	}

   	/** Store pick up **/

   	public function get_storepickup()
	{
		$json = file_get_contents('php://input');
	    //$json 		= '{"type":"store_pickup"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;

		$language 	= @$jsonobj->language;
		$ws 		= @$jsonobj->ws;
		$language 	= empty($language)? 'en':$language;
		$ws 		= empty($ws)? 'get_storepickup':$ws;


		$user_id = $this->validate_token($language ,$ws);

   	 	$response = array();
 		$data = $this->custom_model->my_where("storepickup","*");
 		/*if($language != "en"){
 			$datat = $this->custom_model->my_where("pages_trans","*",array('id' => $data[0]['id'] ) );
 			if(isset($datat[0]['title']) && !empty($datat[0]['title'])){
 				$data[0]['title'] = $datat[0]['title'];
 			}
 			if(isset($datat[0]['editor']) && !empty($datat[0]['editor'])){
 				$data[0]['editor'] = $datat[0]['editor'];
 			}
 		}*/

   	 	if(isset($data[0])){
   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data[0]) );die;
   	 	}else{
   	 		echo json_encode( array("status" => false,"ws"=>$ws ,"message" => 'Something went wrong.') );die;
   	 	}
   	}

	/**
	 * Payment Setting
	 */
	public function payment_setting()
	{
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		// $json 		= '{"user_id":"30","vendor":"bonafide-restaurant"}';
   	 	$response = $data = $post_arr = array();
		$jsonobj 	= json_decode($json);
		$post_arr['user_id'] 			= $uid 	= @$user_id;
		$post_arr['card_type'] 			= @$jsonobj->card_type;
		$post_arr['card_number'] 		= @$jsonobj->card_number;
		$post_arr['card_name'] 			= @$jsonobj->card_name;
		$post_arr['exp_month'] 			= @$jsonobj->exp_month;
		$post_arr['exp_year'] 			= @$jsonobj->exp_year;
		//$post_arr['cvv'] 				= @$jsonobj->cvv;
		$type 							= @$jsonobj->type;

   	 	if (!empty($uid))
		{
			
			if (!empty($post_arr) && $type == 'save')
			{
				$count = $this->custom_model->record_count('billing_info',array('user_id' => $uid));
				if ($count == 0) {
					$this->custom_model->my_insert($post_arr,'billing_info');
				}else{
					$this->custom_model->my_update($post_arr,array('user_id' => $uid),'billing_info');
				}
			}

			$data = $this->custom_model->my_where('billing_info','*',array('user_id'=>$uid));

			echo json_encode( array("status" => true,"data" => $data[0]) );die;
		}

		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * change password function
	 */
	public function change_pass()
	{
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'change_pass':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		// $json 		= '{"password":"123123","current_password":"123566"}';
		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;
		$password 		= @$jsonobj->password;
		$current_password 	= @$jsonobj->current_password;

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}
   	 	if(empty($password) || strlen($password) > 35 ){
	    	echo json_encode( array("status" => false,"message" => "Please enter valid password.") );die;
	    }
		if (empty($password) && strlen($password) < 6 ){
			echo json_encode(array("status" => false,"message" => trim("Please enter password atleast 6 character") )); die;
		}

		$logged_in = $this->custom_model->my_where('users','password',array('id'=>$user_id),array(),"","","","", array(), "",array(),false );
	    	
    	if (!empty($logged_in))
	 	{
	 		if(password_verify ( $current_password ,$logged_in[0]['password'] ))
			{
				$password =password_hash($password, PASSWORD_BCRYPT);
				
				$this->custom_model->my_update(array("password" => $password),array("id" => $user_id),"users" );

				echo json_encode( array("status" => true,"message" => 'Password Changed.') );die;
			}
	 	}

	 	echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * Check out
	 */
	public function checkout_page()
	{

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;
		$language 	= @$jsonobj->language;
		$language = empty($language)? 'en':$language;
   	 	$response = array();

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}

   	 	$address = $this->custom_model->my_where('users','*',array('id'=>$user_id),array(),"","","","", array(), "",array(),false );
   	 	unset($address[0]['password']);
		unset($address[0]['salt']);
		unset($address[0]['ip_address']);
		unset($address[0]['activation_code']);
		unset($address[0]['forgotten_password_code']);
		unset($address[0]['forgotten_password_time']);
		unset($address[0]['remember_code']);
		
   	 	$response['address'] = $address[0];

   	 	$billing = $this->custom_model->my_where('billing_info','*',array('user_id'=>$user_id));
   	 	$response['billing'] = !empty($billing)? $billing[0]:array();

   	 	$cart = $this->custom_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));
   	 	if(!empty($cart)) $content = unserialize($cart[0]['content']);

   	 	if (!empty($content)) {
				
			foreach ($content as $key => $value) {
				$res = $this->this_product_data($value['pid'],$language);

				/*$curr = $this->custom_model->my_where('product','*',array('id'=>$value['pid']));
				$curr1 = $this->custom_model->my_where('admin_users','first_name as vendor_name',array('id'=>$curr[0]['seller_id']));

				unset($curr[0]['user_like']);
				unset($curr[0]['rating']);
				unset($curr[0]['sale']);
				unset($curr[0]['slug']);
				unset($curr[0]['product_code']);
				unset($curr[0]['created_date']);
				unset($curr[0]['status']);
				$curr[0]['product_image'] = $this->get_product_path($curr[0]['product_image']);*/
				if ($res)
				{
					$arr = array_merge($res['curr'], $res['curr1'], array('uqty' => $value['qty']));
					$response['product'][] = $arr;
				}
				
			}
		}
		$default_tax = $this->custom_model->get_admin_option("default_tax");
		$default_replacement_policy = $this->custom_model->get_admin_option("default_replacement_policy");
		$default_transaction_cost = $this->custom_model->get_admin_option("default_transaction_cost");

		$response["default_tax"] = $default_tax;
		$response["default_transaction_cost"] = $default_transaction_cost;
		$response['default_replacement_policy'] = $default_replacement_policy;
		echo json_encode( array("status" => true,"data" => $response) );die;
   	}

	/**
	 * Search by category/vendor/product
	 */
	public function search()
	{

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);



		$json = file_get_contents('php://input');
		// $json 		= '{"string":"30"}';
		$jsonobj 	= json_decode($json);
		$string 	= @$jsonobj->string;
		$language 	= @$jsonobj->language;
		$user_id 	= @$jsonobj->user_id;
		$language = empty($language)? 'en':$language;
   	 	$response = array();

		$this->load->library('search');

   	 	$response = $this->search->search_lib($language,$string,'api');
		
		echo json_encode( array("status" => true,"data" => $response) );die;
   	}

	/**
	 * Forget password
	 */
	public function forgetpass()
	{
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'forgetpass':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		$string 	= @$jsonobj->string;
   	 	$response = array();

   	 	if (empty($string)) {
   	 		echo json_encode( array("status" => false,"message" => 'Please enter email address or phone number.') );die;
   	 	}
   	 	else
   	 	{
			$this->load->model('User_model');
   	 		$datas = $this->User_model->forget_password($string);
			if($datas)
			{
				$name = $datas->full_name;
				$email = $datas->username;
				$link = base_url()."Login/resetpassword/".en_de_crypt($datas->id)."/".$datas->forgotten_password_code;

				$message = forgetpass_content($name,$link);

				$emails = $email;
				$subject = "Reset Password";
				send_email($emails,$subject,$message);
				echo json_encode( array("status" => true,"message" => 'Please check your email to reset your password.') );die;
   	 		}
   	 		else{
   	 			echo json_encode( array("status" => false,"message" => 'Email address was not found. Please enter a valid email address or register for a new account.') );die;
   	 		}

   	 	}
		echo json_encode( array("status" => false,"message" => 'Something went wrong. Please contact admin.') );die;
   	}

	/**
	 * insert user rating a product
	 */
	public function insert_user_rating()
	{
	   

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		$rating 	= @$jsonobj->rating;
		$pid 	= @$jsonobj->product_id;
		$comment 	= @$jsonobj->comment;
   	 	$response = array();

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}
		if ($rating < 6) {
			echo json_encode( array("status" => false,"message" => 'Please choose rating.') );die;
		}
   	 	$data = array();
		$data['rating'] = $rating;
		$data['comment'] = $comment;
		$data['pid'] = $pid;
		$data['uid'] = $user_id;
		$data['status'] = 'active';
		$this->custom_model->my_insert($data, 'user_rating');
		$user_review = $this->custom_model->my_where("user_rating","*",array('pid' => $data['pid'], 'status' => 'active') );
		if (!empty($user_review))
		{
			$avg = 0;
			foreach ($user_review as $key => $value)
			{
				$avg += $value['rating'];
			}
			$response['rating'] = round($avg/count($user_review));
			$response['user_count'] = count($user_review);
		}

		$update['rating'] = $response['rating'];
		$update['reviews'] = $response['user_count'];
		$this->custom_model->my_update($update,array('id' => $data['pid']),'product');

		echo json_encode( array("status" => true) );die;
   	}

	/**
	 * Call when app opens
	 */
	public function start_up()
	{
		

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// $json 		= '{"user_id":"30"}';
		// $jsonobj 	= json_decode($json);
   	 	$response = array();

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}

		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * Call when app opens
	 */
	public function get_pages()
	{
		
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'get_pages':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		//$json 		= '{"slug":"about","language":"en"}';
		$jsonobj 	= json_decode($json);
		$slug 	= @$jsonobj->slug;
		$language 	= @$jsonobj->language;
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
   	 	if(isset($data[0])){
   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $data) );die;
   	 	}else{
   	 		echo json_encode( array("status" => false,"ws"=>$ws , "message" => 'Something went wrong.') );die;
   	 	}
   	}

	/**
	 * app_phone_no
	 */
	public function app_phone_no()
	{
		
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		//$json 			='{"app_id":"21", "data":[{"phone":"213123232132"},{"phone":"12332312323"}]}';
		$jsonobj = json_decode($json);
		$data 	 = @$jsonobj->data;
		$app_id  = @$jsonobj->app_id;
		if(empty($app_id)) $app_id = 0;
   	 	foreach ($data as $key => $value) {
   	 		$phone = strip_tags( $value->phone );
   	 		$adata['app_id'] = $app_id;
   	 		$adata['phone'] = $phone;
   	 		$this->custom_model->my_insert($adata, 'uphones');
   	 	}
		echo json_encode( array("status" => true,"message" => 'Phone number inserted successfully.') );die;
   	}
   	
	/**
	 * Check product quantity
	 */
	public function check_qty()
	{
		


		$json = file_get_contents('php://input');
		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		$pid 	= @$jsonobj->pid;
		$qty 	= @$jsonobj->qty;
   	 	$response = array();

   	 	if (empty($pid) || empty($qty)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}

   	 	$res = $this->custom_model->my_where('product','*',array('id' => $pid));
		if (isset($res[0]))
		{
			if ($qty > $res[0]['stock'])
			{
				$response['status'] = false;
				$response['message'] = 'Not enough stock to add quantity...';
			}
			else{
				$response['status'] = true;
				$response['message'] = 'Good to go...';
			}
		}

		echo json_encode( $response );die;
   	}

	/**
	 * standard dummy function
	 */
	public function example()
	{
		$token = $this->getBearerToken();
	    $Jwt_client = new Jwt_client(); 
	    $token = $Jwt_client->decode($token);
	    if($token){
	       if(@$token['api_key'] != $this->token_id ){
	       	echo json_encode( array("status" => false,"message" => "Invalid authentication.") );die;
	       }
	    }else{
	        echo json_encode( array("status" => false,"message" => "Invalid authentication.") );die;
	    }

	    $user_id 	= $this->check_user_login();

		$json = file_get_contents('php://input');
		// $json 		= '{"user_id":"30"}';
		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;
		$category 	= @$jsonobj->category;
		$vendor 	= @$jsonobj->vendor;
		$subcategory 	= @$jsonobj->subcategory;
   	 	$response = array();

   	 	if (empty($user_id)) {
   	 		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	 	}

		echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
   	}

	/**
	 * product image path
	 */
	public function get_product_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/products/'.$image;
			return $str;
		}
   	}


	/**
	 * vendor image path
	 */
	public function get_vendor_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/seller_img/'.$image;
			return $str;
		}
   	}


	/**
	 * categry image path
	 */
	public function get_category_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/admin/category/'.$image;
			return $str;
		}
   	}


	/**
	 * categry image path
	 */
	public function get_banner_path($image)
	{
		if (!empty($image))
		{
			$str = base_url().'assets/frontend/images/home/'.$image;
			return $str;
		}
   	}


	/**
	 * categry image path
	 */
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
	
	public function manual_wheelchair()
		{
			$uid = 0;
			
		
			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			
			//$uid = 1;
			$json = file_get_contents('php://input');

			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","hcpcs_code":"70",       
		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male", 
						"physician_upin":"Upin123","est_need":"12","diag_code":"Code123","ans_1":"pune",
						"ans_2":"Pune","ans_3":"Pune","ans_4":"Pune","ans_5":"Pune","ans_8":"Pune",              
						"ans_9":"Pune","op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/
			    	
			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;

			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin'] 		      = @$jsonobj->physician_upin;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['ans_1']= @$jsonobj->ans_1;
			$post_arr['ans_2'] 		= @$jsonobj->ans_2;
			$post_arr['ans_3'] 	= @$jsonobj->ans_3;
			$post_arr['ans_4']    = @$jsonobj->ans_4;
			$post_arr['ans_5'] 		= @$jsonobj->ans_5;
			$post_arr['ans_8'] 	= @$jsonobj->ans_8;
			$post_arr['ans_9'] 	    = @$jsonobj->ans_9;
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;

			$post_arr['attached_hcfa_form_854'] 	= @$jsonobj->attached_hcfa_form_854;

			$post_arr['date_final'] 		= @$jsonobj->date_final;
			$post_arr['signature'] 	= @$jsonobj->signature;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];
			
		
			$this->load->library('place_order');
			$response = $this->place_order->m_wheelchair($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   public function motorized_wheelchair()
		{
			$uid = 0;

	
			
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","hcpcs_code":"70",       
		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male",				        
						"physician_upin":"Upin123","est_need":"12","diag_code":"Code123","ans_1":"pune",
						"ans_2":"Pune","ans_3":"Pune","ans_4":"Pune","ans_5":"Pune","ans_6":"Pune",              
						"ans_7":"Pune","op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road", "attached_hcfa_form_854":"aundh","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;

			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin'] 		      = @$jsonobj->physician_upin;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['ans_1']= @$jsonobj->ans_1;
			$post_arr['ans_2'] 		= @$jsonobj->ans_2;
			$post_arr['ans_3'] 	= @$jsonobj->ans_3;
			$post_arr['ans_4']    = @$jsonobj->ans_4;
			$post_arr['ans_5'] 		= @$jsonobj->ans_5;
			$post_arr['ans_6'] 	= @$jsonobj->ans_6;
			$post_arr['ans_7'] 	    = @$jsonobj->ans_7;
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;

			$post_arr['attached_hcfa_form_854'] 	= @$jsonobj->attached_hcfa_form_854;

			$post_arr['date_final'] 		= @$jsonobj->date_final;
			$post_arr['signature'] 	= @$jsonobj->signature;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];
			
		
			$this->load->library('place_order');
			$response = $this->place_order->motorized_wheelchair($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	
	   	public function scooter()
		{	$uid = 0;
			

	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_date":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","hcpcs_code":"70",       
		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male",				        
						"physician_upin":"Upin123","est_need":"12","diag_code":"Code123","ans_6":"pune",
						"ans_7":"Pune","ans_8":"Pune","ans_12":"Pune","ans_13":"Pune","ans_14":"Pune",              
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;

			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_date']      = @$jsonobj->revised_date;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['phy_upin'] 		      = @$jsonobj->physician_upin;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['ans_6']= @$jsonobj->ans_6;
			$post_arr['ans_7'] 		= @$jsonobj->ans_7;
			$post_arr['ans_8'] 	= @$jsonobj->ans_8;
			$post_arr['ans_12']    = @$jsonobj->ans_12;
			$post_arr['ans_13'] 		= @$jsonobj->ans_13;
			$post_arr['ans_14'] 	= @$jsonobj->ans_14;
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;
			$post_arr['date_final'] 		= @$jsonobj->date_final;
			$post_arr['signature'] 	= @$jsonobj->signature;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->scooter($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function seat_lift()
		{	$uid = 0;

	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","recertification":"10/11/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","supply_item_pro_code":"70",       
		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male",				        
						"physician_upin":"Upin123","est_need":"12","diag_code":"Code123","ans_1":"pune",
						"ans_2":"Pune","ans_3":"Pune","ans_4":"Pune","ans_5":"Pune",              
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;

			$post_arr['recertification']      = @$jsonobj->recertification;


			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['supply_item_pro_code'] 		    = @$jsonobj->supply_item_pro_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin'] 		      = @$jsonobj->physician_upin;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['ans_1']= @$jsonobj->ans_1;
			$post_arr['ans_2'] 		= @$jsonobj->ans_2;
			$post_arr['ans_3'] 	= @$jsonobj->ans_3;
			$post_arr['ans_4']    = @$jsonobj->ans_4;
			$post_arr['ans_5'] 		= @$jsonobj->ans_5;
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->seat_lift($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   public function hospital_bed()
		{	$uid = 0;
			

			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

		/*	$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","hcpcs_code":"70",		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male",
						"physician_upin":"Upin123","est_need":"12","diag_code":"Code123","ans_1":"pune",
						"ans_3":"Pune","ans_4":"Pune","ans_5":"Pune","ans_6":"Pune","ans_7":"Pune",
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin'] = @$jsonobj->physician_upin;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['ans_1']= @$jsonobj->ans_1;
			$post_arr['ans_3'] 		= @$jsonobj->ans_3;
			$post_arr['ans_4'] 	= @$jsonobj->ans_4;
			$post_arr['ans_5']    = @$jsonobj->ans_5;
			$post_arr['ans_6'] 		= @$jsonobj->ans_6;
			$post_arr['ans_7'] 		= @$jsonobj->ans_7;

			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->hospital_bed($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function infusion_pump()
		{	$uid = 0;
			

	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			/*$json = '{"user_id":"1564","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","recertification":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune",

		               "supplier_name":"dsds","supplier_add":"Pune","supply_item_pro_code":"pune","supplier_tel":"12675234654","nsc_number":"nsc123","sex":"Male","physician_upin_NPI":"Upin123",
		               "ques_1_a":"dsds","ques_1_b":"dsds","ques_1_c":"dsds","ques_2_a":"dsds",
		               "ques_2_b":"dsds",
		               "ques_2_c":"dsds",
		               "ques_3":"dsds",
		               "ques_4":"dsds",
						"date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;
			$post_arr['recertification']      = @$jsonobj->recertification;


			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			//$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;

			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;
			$post_arr['supply_item_pro_code']= @$jsonobj->supply_item_pro_code;
							
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;

			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin_NPI'] = @$jsonobj->physician_upin_NPI;			
			//$post_arr['est_need'] 		  = @$jsonobj->est_need;
			//$post_arr['diag_code']  = @$jsonobj->diag_code;
			
			$post_arr['ques_1_a'] 		= @$jsonobj->ques_1_a;
			$post_arr['ques_1_b'] 		= @$jsonobj->ques_1_b;
			$post_arr['ques_1_c'] 		= @$jsonobj->ques_1_c;

			$post_arr['ques_2_a'] 		= @$jsonobj->ques_1_a;
			$post_arr['ques_2_b'] 		= @$jsonobj->ques_2_b;
			$post_arr['ques_2_c'] 		= @$jsonobj->ques_2_c;



			$post_arr['ques_3'] 	= @$jsonobj->ques_3;
			$post_arr['ques_4']    = @$jsonobj->ques_4;

			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->infusion_pump($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function parenteral_nutrition()
		{	$uid = 0;
			

	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_name":"10/6/2017","recertification":"16-6-2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","procedure_codes":"70",		       
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_number":"nsc123","sex":"Male",
						"physician_upin_NPI":"Upin123","est_need":"12","diag_code":"Code123","is_there_doc_in_medical":"pune",
						"is_the_enternal_nut":"Pune","item_services_p_code":"Pune","cal_per_day":"Pune","check_methof_for_admin":"Pune",              
						"days_per_week_admin":"Girish","its_medical_record":"Best","amino_acid":"GirishB","amino_acid_ml_day":"kalewadi phata chinchwad",
						"amino_acid_ml_day_concentration":"pune","Dextrose":"aundh","Dextrose_ml_day":"aundh","lipids":"aundh","lipids_mi_day":"aundh","lipids_day_week":"aundh","check_num_route_admin":"aundh","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_name']      = @$jsonobj->revised_name;
			$post_arr['recertification']      = @$jsonobj->recertification;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['procedure_codes'] 		    = @$jsonobj->procedure_codes;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;
			$post_arr['nsc_number'] 		= @$jsonobj->nsc_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['physician_upin_NPI'] = @$jsonobj->physician_upin_NPI;			
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;

			$post_arr['is_there_doc_in_medical']= @$jsonobj->is_there_doc_in_medical;
			$post_arr['is_the_enternal_nut'] 		= @$jsonobj->is_the_enternal_nut;
			$post_arr['item_services_p_code'] 	= @$jsonobj->item_services_p_code;
			$post_arr['cal_per_day']    = @$jsonobj->cal_per_day;
			$post_arr['check_methof_for_admin'] 		= @$jsonobj->check_methof_for_admin;
			$post_arr['days_per_week_admin'] 	    = @$jsonobj->days_per_week_admin;
			$post_arr['its_medical_record'] 	    = @$jsonobj->its_medical_record;
			$post_arr['amino_acid'] 	    = @$jsonobj->amino_acid;
			$post_arr['amino_acid_ml_day']   = @$jsonobj->amino_acid_ml_day;
			$post_arr['amino_acid_ml_day_concentration']  = @$jsonobj->amino_acid_ml_day_concentration;
			$post_arr['Dextrose'] 	= @$jsonobj->Dextrose;
			$post_arr['Dextrose_ml_day'] 	= @$jsonobj->Dextrose_ml_day;
			$post_arr['lipids'] 	= @$jsonobj->lipids;
			$post_arr['lipids_mi_day'] 	= @$jsonobj->lipids_mi_day;
			$post_arr['lipids_day_week'] 	= @$jsonobj->lipids_day_week;
			$post_arr['check_num_route_admin'] 	= @$jsonobj->check_num_route_admin;

			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->parenteral_nutrition($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function positive_airway_pressure()
		{	$uid = 0;
			
	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","recertification":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","hcpcs_code":"70",
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_or_npi_number":"nsc123","sex":"Male",
						"phy_nsc_npi":"Upin123","est_need":"12","diag_code":"Code123","is_the_device_is_ordered_s_appena":"pune",
						"initial_f_to_f_date":"Pune","date_of_sleep_test":"Pune","pat_test_conducted_on_lab":"Pune","ahi_rdi":"Pune", "documented_evidence":"Pune",
						"bilevel_device_cpap":"Pune",
						"bilevel_device_cpap":"Pune",
						"follow_up_date_f_to_f_evaluation":"Pune",

						"report_document_pap":"Pune",
						"did_pat_demon_impro":"Pune",						

						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad",
						"supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['recertification']      = @$jsonobj->recertification;
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;			
			$post_arr['nsc_or_npi_number'] 		= @$jsonobj->nsc_or_npi_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['phy_nsc_npi'] = @$jsonobj->phy_nsc_npi;
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['is_the_device_is_ordered_s_appena']= @$jsonobj->is_the_device_is_ordered_s_appena;
			$post_arr['initial_f_to_f_date'] 		= @$jsonobj->initial_f_to_f_date;
			$post_arr['date_of_sleep_test'] 	= @$jsonobj->date_of_sleep_test;
			$post_arr['pat_test_conducted_on_lab']    = @$jsonobj->pat_test_conducted_on_lab;
			$post_arr['ahi_rdi'] 		= @$jsonobj->ahi_rdi;
			$post_arr['documented_evidence'] 		= @$jsonobj->documented_evidence;
			$post_arr['bilevel_device_cpap'] 		= @$jsonobj->bilevel_device_cpap;
			$post_arr['follow_up_date_f_to_f_evaluation'] 	= @$jsonobj->follow_up_date_f_to_f_evaluation;
			$post_arr['report_document_pap'] 		= @$jsonobj->report_document_pap;
			$post_arr['did_pat_demon_impro'] 		= @$jsonobj->did_pat_demon_impro;			
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->positive_airway_pressure($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function oxygen()
		{	$uid = 0;
			

	
			
			//$uid = 1;
			$json = file_get_contents('php://input');


			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_date":"10/11/2017","recertification":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","item_service_procedure_codes":"70",
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_or_npi_number":"nsc123","sex":"Male",
						"phy_npi_upin":"Upin123","est_need":"12","diag_code":"Code123","arterial_blood_gas_po2":"pune",
						"oxygen_saturation_test":"Pune","recent_test_date":"Pune","was_test_in_question":"Pune","check_the_one_num_of_condition_test":"Pune", "ordering_portable_oxygen":"Pune",
						"enter_highest_oxy_rate_patient":"Pune","arterial_blood_gas_po2_if_lpmgreatoe_than4":"Pune","oxy_sat_tex_greatorthan4":"Pune","date_of_text_4_lpm":"Pune",

						"patient_depend_on_edema":"Pune",
						"pat_have_corpulmonal_pulmonary":"Pune",
						"does_pat_have_hematocrit":"Pune",
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad","supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_date'] 		= @$jsonobj->revised_date;
			$post_arr['recertification']      = @$jsonobj->recertification;			
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;
			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['item_service_procedure_codes'] 		    = @$jsonobj->item_service_procedure_codes;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;
			$post_arr['nsc_or_npi_number'] 		= @$jsonobj->nsc_or_npi_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['phy_npi_upin'] = @$jsonobj->phy_npi_upin;
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;
			$post_arr['arterial_blood_gas_po2']= @$jsonobj->arterial_blood_gas_po2;
			$post_arr['oxygen_saturation_test'] 		= @$jsonobj->oxygen_saturation_test;			
			$post_arr['recent_test_date'] 	= @$jsonobj->recent_test_date;
			$post_arr['was_test_in_question']    = @$jsonobj->was_test_in_question;
			$post_arr['check_the_one_num_of_condition_test'] 		= @$jsonobj->check_the_one_num_of_condition_test;
			$post_arr['ordering_portable_oxygen'] 		= @$jsonobj->ordering_portable_oxygen;
			$post_arr['enter_highest_oxy_rate_patient'] 		= @$jsonobj->enter_highest_oxy_rate_patient;
			$post_arr['arterial_blood_gas_po2_if_lpmgreatoe_than4'] 	= @$jsonobj->arterial_blood_gas_po2_if_lpmgreatoe_than4;
			$post_arr['oxy_sat_tex_greatorthan4'] 		= @$jsonobj->oxy_sat_tex_greatorthan4;
			$post_arr['date_of_text_4_lpm'] 		= @$jsonobj->date_of_text_4_lpm;
			$post_arr['patient_depend_on_edema'] 	    = @$jsonobj->patient_depend_on_edema;
			$post_arr['pat_have_corpulmonal_pulmonary'] 	    = @$jsonobj->pat_have_corpulmonal_pulmonary;
			$post_arr['does_pat_have_hematocrit'] 	    = @$jsonobj->does_pat_have_hematocrit;
			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->oxygen($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   		public function pneumatic_compression()
		{	$uid = 0;
			
			//$uid = 1;
			$json = file_get_contents('php://input');


			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_date":"10/11/2017","recertification":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","item_service_procedure_codes":"70",
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_or_npi_number":"nsc123","sex":"Male",
						"phy_npi_upin":"Upin123","est_need":"12","diag_code":"Code123","patient_have_chronic_venous":"pune",
						"pat_has_venous_stasis":"Pune","pat_had_radical_cancel":"Pune","pat_have_malignant_tumor":"Pune","pat_had_lymphedema":"Pune",
						"patient_depend_on_edema":"Pune",
						"pat_have_corpulmonal_pulmonary":"Pune",
						"does_pat_have_hematocrit":"Pune",
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad","supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_date'] 		= @$jsonobj->revised_date;
			$post_arr['recertification']      = @$jsonobj->recertification;			
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;

			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['item_service_procedure_codes'] = @$jsonobj->item_service_procedure_codes;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;
			$post_arr['nsc_or_npi_number'] 		= @$jsonobj->nsc_or_npi_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;

			$post_arr['phy_npi_upin'] = @$jsonobj->phy_npi_upin;
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  = @$jsonobj->diag_code;

			$post_arr['patient_have_chronic_venous']= @$jsonobj->patient_have_chronic_venous;			
			$post_arr['pat_has_venous_stasis'] 		= @$jsonobj->pat_has_venous_stasis;
			$post_arr['pat_had_radical_cancel'] 	= @$jsonobj->pat_had_radical_cancel;
			$post_arr['pat_have_malignant_tumor']    = @$jsonobj->pat_have_malignant_tumor;
			$post_arr['pat_had_lymphedema'] 		= @$jsonobj->pat_had_lymphedema;			

			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->pneumatic_compression($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function osteogenesis_stimulators()
		{	$uid = 0;
			
	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			/*$json = '{"user_id":"164","display_order_id":"1465464","initial_date":"10/11/2017","revised_date":"10/11/2017","recertification":"10/6/2017","hic_number":"1668","place_of_service_name":"Girish", "pos_address":"Pune","item_service_procedure_codes":"70",
		               "supplier_name":"dsds","supplier_add":"Pune","supplier_tel":"12675234654",
				        "nsc_or_npi_number":"nsc123","sex":"Male",
						"phy_npi_upin":"Upin123","est_need":"12","diag_code":"Code123","ques_6":"pune",
						"ques_7a":"Pune","ques_7b":"Pune","ques_8":"Pune","ques_9a":"Pune","ques_9b":"Pune",
						"ques_10a":"Pune",
						"ques_10b":"Pune",
						"ques_10c":"Pune",
						"ques_11":"Pune",
						"ques_12":"Pune",
						"patient_depend_on_edema":"Pune",
						"pat_have_corpulmonal_pulmonary":"Pune",
						"does_pat_have_hematocrit":"Pune",
						"op_name":"Girish","op_title":"Best","op_employer":"GirishB","Narrative_desc":"kalewadi phata chinchwad","supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['initial_date'] 		= @$jsonobj->initial_date;
			$post_arr['revised_date'] 		= @$jsonobj->revised_date;
			$post_arr['recertification']      = @$jsonobj->recertification;			
			$post_arr['hic_number'] 	= @$jsonobj->hic_number;

			// address details
			$post_arr['place_of_service_name'] 	= @$jsonobj->place_of_service_name;
			$post_arr['pos_address'] 	        = @$jsonobj->pos_address;
			$post_arr['item_service_procedure_codes'] = @$jsonobj->item_service_procedure_codes;
			$post_arr['supplier_name'] 		= @$jsonobj->supplier_name;
			// BILLING INFORMATION
			$post_arr['supplier_add'] 		= @$jsonobj->supplier_add;
			$post_arr['supplier_tel'] 	= @$jsonobj->supplier_tel;
			$post_arr['nsc_or_npi_number'] 		= @$jsonobj->nsc_or_npi_number;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['sex'] 		    = @$jsonobj->sex;
			$post_arr['phy_npi_upin'] 	= @$jsonobj->phy_npi_upin;
			$post_arr['est_need'] 		  = @$jsonobj->est_need;
			$post_arr['diag_code']  	= @$jsonobj->diag_code;
			
			$post_arr['ques_6']			= @$jsonobj->ques_6;			
			$post_arr['ques_7a'] 		= @$jsonobj->ques_7a;
			$post_arr['ques_7b'] 		= @$jsonobj->ques_7b;
			$post_arr['ques_8']    		= @$jsonobj->ques_8;
			$post_arr['ques_9a'] 		= @$jsonobj->ques_9a;
			$post_arr['ques_9b'] 		= @$jsonobj->ques_9b;
			$post_arr['ques_10a'] 		= @$jsonobj->ques_10a;
			$post_arr['ques_10b'] 		= @$jsonobj->ques_10b;
			$post_arr['ques_10c'] 		= @$jsonobj->ques_10c;
			$post_arr['ques_11'] 		= @$jsonobj->ques_11;
			$post_arr['ques_12'] 		= @$jsonobj->ques_12;

			$post_arr['op_name'] 	    = @$jsonobj->op_name;
			$post_arr['op_title'] 	    = @$jsonobj->op_title;
			$post_arr['op_employer'] 	    = @$jsonobj->op_employer;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->osteogenesis_stimulators($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function continuation_form()
		{	$uid = 0;
			
	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

		/*	$json = '{"user_id":"164","display_order_id":"1465464","patient_hicn":"10/11/2017","Narrative_desc":"kalewadi phata chinchwad","supplier_charge":"pune","medicare_fee":"aundh road","date_final":"11-11-2017","signature":"signature"

			    }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['display_order_id'] 		= @$jsonobj->display_order_id;
			$post_arr['patient_hicn'] 		= @$jsonobj->patient_hicn;
			$post_arr['Narrative_desc']   = @$jsonobj->Narrative_desc;
			$post_arr['supplier_charge']  = @$jsonobj->supplier_charge;
			$post_arr['medicare_fee'] 	= @$jsonobj->medicare_fee;			
			$post_arr['signature'] 	= @$jsonobj->signature;
			$post_arr['date_final'] 		= @$jsonobj->date_final;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->continuation_form($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function orderintake()
		{	$uid = 0;
			
	
			
			//$uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'place_order':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"14","sex":"male","pname":"1017","paddress":"10/6/2017","primary_insurance_cname":"1668","primary_insurance_number":"Girish", "diag_code":"Pune",

		               "diag_desc":"dsds","secondary_insurance_cname":"Pune","patient_height":"pune","other_insurance_number":"12675234654","patient_weight":"nsc123","patient_birth_of_date":"Male","mobile_no":"Upin123",
		               "email":"dsds","physician_name":"dsds","physician_facility_name":"dsds","physician_facility_address":"dsds",
		               "physician_npi":"dsds",
		               "physician_licence":"dsds",
		               "physician_phone":"dsds",
		               "physician_fax":"dsds",
						"order_date":"11-11-2017",
						"physician_email":"physician_email",
						"name_of_order":"11-11-2017",
						"qty_dosage":"11-11-2017","order_notes":"11-11-2017"}';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			$post_arr['sex'] 		= @$jsonobj->sex;
			$post_arr['pname']      = @$jsonobj->pname;
			$post_arr['paddress']      = @$jsonobj->paddress;
			$post_arr['primary_insurance_cname'] 	= @$jsonobj->primary_insurance_cname;
			$post_arr['primary_insurance_number'] 	= @$jsonobj->primary_insurance_number;
			$post_arr['diag_code'] 	        = @$jsonobj->diag_code;
			//$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
			$post_arr['diag_desc'] 		= @$jsonobj->diag_desc;
			// BILLING INFORMATION
			$post_arr['secondary_insurance_cname'] 		= @$jsonobj->secondary_insurance_cname;
			$post_arr['other_insurance_number'] 	= @$jsonobj->other_insurance_number;
			$post_arr['patient_height']= @$jsonobj->patient_height;							
			$post_arr['patient_weight'] 		= @$jsonobj->patient_weight;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['patient_birth_of_date'] 		    = @$jsonobj->patient_birth_of_date;
			$post_arr['mobile_no'] = @$jsonobj->mobile_no;			
			$post_arr['email'] 		= @$jsonobj->email;
			$post_arr['physician_name'] 		= @$jsonobj->physician_name;
			$post_arr['physician_facility_name'] 	= @$jsonobj->physician_facility_name;
			$post_arr['physician_facility_address'] = @$jsonobj->physician_facility_address;
			$post_arr['physician_npi'] 		= @$jsonobj->physician_npi;
			$post_arr['physician_licence'] 		= @$jsonobj->physician_licence;

			$post_arr['physician_phone'] 	= @$jsonobj->physician_phone;
			$post_arr['physician_fax']    = @$jsonobj->physician_fax;

			$post_arr['physician_email'] 	= @$jsonobj->physician_email;
			$post_arr['order_date'] 		= @$jsonobj->order_date;

			$post_arr['name_of_order'] 		= @$jsonobj->name_of_order;
			$post_arr['qty_dosage'] 		= @$jsonobj->qty_dosage;
			$post_arr['order_notes'] 		= @$jsonobj->order_notes;

	        //print_r($post_arr);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->orderintake($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function update_oi()
	{
		// $user_id 	= $this->check_user_login();

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'place_order':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

			
	/*	$user_id = 314;
		$json = '{"sex":"male","pname":"1017","paddress":"10/6/2017","primary_insurance_cname":"1668","primary_insurance_number":"Girish", "diag_code":"Pune",    "diag_desc":"dsds","secondary_insurance_cname":"Pune","patient_height":"pune","other_insurance_number":"12675234654","patient_weight":"nsc123","patient_birth_of_date":"Male","mobile_no":"Upin123","email":"dsds","physician_name":"dsds","physician_facility_name":"dsds","physician_facility_address":"dsds","physician_npi":"dsds",
		               "physician_licence":"dsds","physician_phone":"dsds","physician_fax":"dsds",
						"order_date":"11-11-2017","physician_email":"physician_email","name_of_order":"11-11-2017","qty_dosage":"11-11-2017","order_notes":"11-11-2017"}';
*/
		// $json 		= '{"category":"30","vendor":"bonafide-restaurant"}';
	    $jsonobj 	= json_decode($json);
	
			$sex						= @$jsonobj->sex;
			$pname      				= @$jsonobj->pname;
			$paddress    				= @$jsonobj->paddress;
			$primary_insurance_cname 	= @$jsonobj->primary_insurance_cname;
			$primary_insurance_number 	= @$jsonobj->primary_insurance_number;
			$diag_code	       			= @$jsonobj->diag_code;
			$diag_desc 					= @$jsonobj->diag_desc;

			$secondary_insurance_cname 	= @$jsonobj->secondary_insurance_cname;
			$other_insurance_number 	= @$jsonobj->other_insurance_number;
			$patient_height				= @$jsonobj->patient_height;							
			$patient_weight 			= @$jsonobj->patient_weight;
			$patient_birth_of_date 		= @$jsonobj->patient_birth_of_date;
			$mobile_no 					= @$jsonobj->mobile_no;			
			$email						= @$jsonobj->email;
			$physician_name 			= @$jsonobj->physician_name;
			$physician_facility_name 	= @$jsonobj->physician_facility_name;
			$physician_facility_address = @$jsonobj->physician_facility_address;
			$physician_npi 				= @$jsonobj->physician_npi;
			$physician_licence 			= @$jsonobj->physician_licence;

			$physician_phone 			= @$jsonobj->physician_phone;
			$physician_fax    			= @$jsonobj->physician_fax;
			$physician_email 			= @$jsonobj->physician_email;
			$order_date 				= @$jsonobj->order_date;

			$name_of_order 				= @$jsonobj->name_of_order;
			$qty_dosage					= @$jsonobj->qty_dosage;
			//$phone 				= @$jsonobj->phone;
			$order_notes 				= @$jsonobj->order_notes;
			//$type 						= @$jsonobj->type;
			$response = array();
			
			//print_r($json);die();

   	 	if (!empty($user_id))
   	 	{

				$this->custom_model->my_update(array(
					"sex" => $sex,"pname" => $pname,"paddress" => $paddress,"primary_insurance_cname" => $primary_insurance_cname,"primary_insurance_number" => $primary_insurance_number,
					"diag_code" => $diag_code,"secondary_insurance_cname" => $secondary_insurance_cname,
					"other_insurance_number" => $other_insurance_number,"patient_height" => $patient_height,"patient_weight" => $patient_weight,"patient_birth_of_date" => $patient_birth_of_date,"mobile_no" => $mobile_no,"physician_name" => $physician_name,"physician_facility_name" => $physician_facility_name,
					"physician_facility_address" => $physician_facility_address,"physician_npi" => $physician_npi,"physician_licence" => $physician_licence,"physician_phone" => $physician_phone,"physician_fax" => $physician_fax,"physician_email" => $physician_email,"order_date" => $order_date,"name_of_order" => $name_of_order,
					"qty_dosage" => $qty_dosage,"order_notes" => $order_notes),array("user_id" => $user_id),"orderintake");
				
			
			$data = $this->custom_model->my_where("orderintake","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
			

			echo json_encode( array("status" => true,"data" => $data) );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
		
   	}
   	
   		public function update_oi_patient()
	{
		

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


//  		$user_id = 446;
		
	/*	$json = '{"sex":"male","pname":"1017","paddress":"10/6/2017","primary_insurance_cname":"1668","primary_insurance_number":"Girish",
		"diag_code":"Pune",    "diag_desc":"dsds","secondary_insurance_cname":"Pune","patient_height":"pune","other_insurance_number":"12675234654",
		"patient_weight":"nsc123","patient_birth_of_date":"Male","mobile_no":"Upin123","email":"dsds"}';*/

		// $json 		= '{"category":"30","vendor":"bonafide-restaurant"}';
	    $jsonobj 	= json_decode($json);
	
			$sex						= @$jsonobj->sex;
			$pname      				= @$jsonobj->pname;
			$paddress    				= @$jsonobj->paddress;
			
			$patient_height				= @$jsonobj->patient_height;							
			$patient_weight 			= @$jsonobj->patient_weight;
			$patient_birth_of_date 		= @$jsonobj->patient_birth_of_date;
			$mobile_no 					= @$jsonobj->mobile_no;			
			$email						= @$jsonobj->email;
			
			$response = array();
			
// 			print_r($json);die();

   	 	if (!empty($user_id))
   	 	{
            $data_check = $this->custom_model->my_where("orderintake","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
            if(empty($data_check))
            {
                $this->custom_model->my_insert(array("sex" => $sex,"pname" => $pname,"patient_height" => $patient_height,"paddress" => $paddress,"patient_weight" => $patient_weight,"patient_birth_of_date" => $patient_birth_of_date,"mobile_no" => $mobile_no,"email" => $email,"user_id" => $user_id),"orderintake");
            }
            else
            {
                $this->custom_model->my_update(array("sex" => $sex,"pname" => $pname,"patient_height" => $patient_height,"paddress" => $paddress,"patient_weight" => $patient_weight,"patient_birth_of_date" => $patient_birth_of_date,"mobile_no" => $mobile_no,"email" => $email),array("user_id" => $user_id),"orderintake");    
            }
            
			
				
			
			$data = $this->custom_model->my_where("orderintake","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
			
            echo json_encode( array("status" => true,"data" => $data) );die;
       	 	}
    		else
    		{
    			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
    		}
		
   	}
   	
   	
   	public function update_oi_doctor()
	{
		

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		//$user_id = 314;
		//$json = '{"physician_name":"Salman Khna","physician_facility_name":"dsds","physician_facility_address":"dsds","physician_npi":"dsds","physician_licence":"dsds","physician_phone":"dsds","physician_fax":"dsds","order_date":"11-11-2017","physician_email":"physician_email"}';

		// $json 		= '{"category":"30","vendor":"bonafide-restaurant"}';
	    $jsonobj 	= json_decode($json);
	
		
			$physician_name 			= @$jsonobj->physician_name;
			$physician_facility_name 	= @$jsonobj->physician_facility_name;
			$physician_facility_address = @$jsonobj->physician_facility_address;
			$physician_npi 				= @$jsonobj->physician_npi;
			$physician_licence 			= @$jsonobj->physician_licence;

			$physician_phone 			= @$jsonobj->physician_phone;
			$physician_fax    			= @$jsonobj->physician_fax;
			$physician_email 			= @$jsonobj->physician_email;
			
			//$type 						= @$jsonobj->type;
			$response = array();
			
			//print_r($json);die();

   	 	if (!empty($user_id))
   	 	{
             $data_check = $this->custom_model->my_where("orderintake","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
            if(empty($data_check))
            {
                $this->custom_model->my_insert(array(
					"physician_name" => $physician_name,"physician_facility_name" => $physician_facility_name,
					"physician_facility_address" => $physician_facility_address,"physician_npi" => $physician_npi,"physician_licence" => $physician_licence,"physician_phone" => $physician_phone,
					"physician_fax" => $physician_fax,"physician_email" => $physician_email, "user_id" => $user_id),"orderintake");
            }
            else
            {
            
				$this->custom_model->my_update(array(
					"physician_name" => $physician_name,"physician_facility_name" => $physician_facility_name,
					"physician_facility_address" => $physician_facility_address,"physician_npi" => $physician_npi,"physician_licence" => $physician_licence,"physician_phone" => $physician_phone,
					"physician_fax" => $physician_fax,"physician_email" => $physician_email),array("user_id" => $user_id),"orderintake");
				
            }
            
			$data = $this->custom_model->my_where("orderintake","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
			

			echo json_encode( array("status" => true,"data" => $data) );die;
   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
		
   	}
   	
   	public function delivery_method()
		{
			$uid = 0;
			
			//$user_id = 101;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			//$json = '{"user_id":"101","delivery_type":"Home","delivery_address":"delivery_address(101 house/off no)","delivery_locality":"delivery_locality address","delivery_street":"1668 street ","delivery_city":"Ahmednagar", "delivery_country":"India","delivery_zip":"41105"}';

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 			= @$uid;
			
			$post_arr['house_number'] 		= @$jsonobj->house_number;
			
			$post_arr['delivery_type'] 		= @$jsonobj->delivery_type;
			$post_arr['delivery_address']  	= @$jsonobj->delivery_address;
			$post_arr['delivery_locality']  = @$jsonobj->delivery_locality;
			$post_arr['delivery_street'] 	= @$jsonobj->delivery_street;
			$post_arr['delivery_city'] 		= @$jsonobj->delivery_city;
			$post_arr['delivery_country'] 	= @$jsonobj->delivery_country;
			$post_arr['delivery_zip'] 		= @$jsonobj->delivery_zip;

			$this->load->library('place_order');
			$response = $this->place_order->delivery_method($post_arr,$uid);
			// print_r($jsonobj);
			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   public function update_delivery_method()
	{

		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// 		$user_id = 100;
		// 		$json = '{"delivery_type":"Ghar","delivery_address":"nagar 101","delivery_locality":"delivery_locality1234","delivery_street":"1668 nagar","delivery_city":"Girish City", "delivery_country":"India",    "delivery_zip":"411005"}';

		$jsonobj 	= json_decode($json);
		// $user_id 	= @$jsonobj->user_id;

			//$user_id					= @$jsonobj->user_id;

			$delivery_type				= @$jsonobj->delivery_type;			
			$delivery_address      		= @$jsonobj->delivery_address;
			$delivery_locality    		= @$jsonobj->delivery_locality;
			$house_number 		    	= @$jsonobj->house_number;
			$delivery_street 			= @$jsonobj->delivery_street;
			$delivery_city 	            = @$jsonobj->delivery_city;
			$delivery_country	       			= @$jsonobj->delivery_country;
			$delivery_zip 					= @$jsonobj->delivery_zip;
			//$type 						= @$jsonobj->type;
			$response = array();
			
			//print_r($json);die();

   	    if (!empty($user_id))
   	 	{

			$result =	$this->custom_model->my_update(array(
					"delivery_type" => $delivery_type,"delivery_address" => $delivery_address,"delivery_locality" => $delivery_locality,"delivery_street" => $delivery_street,"delivery_city" => $delivery_city,
					"delivery_country" => $delivery_country,"delivery_zip" => $delivery_zip),array("user_id" => $user_id),"delivery_method");
				
		//	print_r($result);die;
				
			$result = $this->custom_model->my_where("delivery_method","*",array("user_id" => $user_id),array(),"","","","", array(), "",array(),false  );	
			
			if ($result)
			{
				echo json_encode( array("status" => true,"data" => $result) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
		

   	 	}
		else
		{
			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
		}
		
   	}
   	
   	public function ordermaster_return()
	{	
		
		$json 		= file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		//$json 		= '{"email":"g@gmail.com","password":"123456"}';
		$jsonobj 	= json_decode($json);
		$password 	= @$jsonobj->password;
		$email 		= @$jsonobj->email;
		if (empty($email) || empty($password)) {
			echo json_encode(array("status" => false,"message" => "All fields are required." ));
			die;
		}
		$logged_in = $this->ion_auth->user_login($email, $password, FALSE);

		// result
		if ($logged_in)
		{	

			$user = $logged_in;
			unset($user[0]->password);
			unset($user[0]->salt);
			unset($user[0]->ip_address);
			unset($user[0]->activation_code);
			unset($user[0]->forgotten_password_code);
			unset($user[0]->forgotten_password_time);
			unset($user[0]->remember_code);
			// TODO: append API key
			$response["token"] = $Jwt_client->encode( array( "password" => $password,"id" => $user[0]->id ) );
			$response['status'] = true;
			$response["user"] = $user;


			// wish list
			$order_master = $this->custom_model->my_where('order_master','*',array('user_id' => $user[0]->id));
			$response["order_master"] = (isset($order_master[0]) && !empty($order_master[0])) ? $order_master[0] : '';

			// return result
			echo json_encode( $response );
		}
		else
		{
			echo json_encode(array("status" => false,"message" => "Incorrect Login." ));
		}
		die;
	}
	
	public function search_dme()
	{

	    $like = array();
		$json 		= file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);


		//$json 		= '{"zip":"10007","terms":""}';
		$jsonobj 	= json_decode($json);
		$zip 	= @$jsonobj->zip;
		
		$id 	= @$jsonobj->id;
		$vender_id 	= @$jsonobj->vender_id;
		
		$terms 	= @$jsonobj->terms;
		if ( !empty($zip) )
		{
			$where['zip'] = $zip;
		}else{
			echo json_encode(array("status" => false,"message" => "All fields are required." ));
			die;
		}
		if (!empty($terms)) {
			$like['terms'] = $terms;
		}
		$where['terms !='] = "";
		$data['dme'] = $this->custom_model->my_where("dme","*",$where,$like);
		echo json_encode(array("status" => true,"data" => $data ));
	}
    
    
    public function insert_patient_oi()
		{	$uid = 0;
			

	
			
			// $uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);

			/*$json = '{"user_id":"14","sex":"male","pname":"1017","paddress":"10/6/2017", "diag_code":"Pune",
		               "diag_desc":"dsds","patient_height":"pune","patient_weight":"nsc123","patient_birth_of_date":"Male","mobile_no":"Upin123","email":"sd@gmail.com"
		               }';*/

			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 	= @$jsonobj->user_id;
			$post_arr['sex'] 		= @$jsonobj->sex;
			$post_arr['pname']      = @$jsonobj->pname;
			$post_arr['paddress']      = @$jsonobj->paddress;
		//	$post_arr['diag_code'] 	        = @$jsonobj->diag_code;
			//$post_arr['hcpcs_code'] 		    = @$jsonobj->hcpcs_code;
		//	$post_arr['diag_desc'] 		= @$jsonobj->diag_desc;
			// BILLING INFORMATION
			$post_arr['patient_height']= @$jsonobj->patient_height;							
			$post_arr['patient_weight'] 		= @$jsonobj->patient_weight;
			//$post_arr['pt_dob'] 		= @$jsonobj->pt_dob;
			$post_arr['patient_birth_of_date'] 		    = @$jsonobj->patient_birth_of_date;
			$post_arr['mobile_no'] = @$jsonobj->mobile_no;			
			$post_arr['email'] 		= @$jsonobj->email;

			

	        //print_r($post_arr);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->insert_patient_oi($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function insert_doctor_oi()
		{	$uid = 0;
			

	
			
			// $uid = 1;
			$json = file_get_contents('php://input');

			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"14","physician_name":"dsds","physician_facility_name":"dsds","physician_facility_address":"dsds",
		               "physician_npi":"dsds",
		               "physician_licence":"dsds",
		               "physician_phone":"dsds",
		               "physician_fax":"dsds",
						"order_date":"11-11-2017",
						"physician_email":"physician_email"}';*/


			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();
			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;
			
			$post_arr['physician_name'] 		= @$jsonobj->physician_name;
			$post_arr['physician_facility_name'] 	= @$jsonobj->physician_facility_name;
			$post_arr['physician_facility_address'] = @$jsonobj->physician_facility_address;
			$post_arr['physician_npi'] 		= @$jsonobj->physician_npi;
			$post_arr['physician_licence'] 		= @$jsonobj->physician_licence;

			$post_arr['physician_phone'] 	= @$jsonobj->physician_phone;
			$post_arr['physician_fax']    = @$jsonobj->physician_fax;

			$post_arr['physician_email'] 	= @$jsonobj->physician_email;			

	        //print_r($post_arr);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];			
		
			$this->load->library('place_order');
			$response = $this->place_order->insert_doctor_oi($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	public function get_delivery_method()
		{   $uid = 0;
			$token = $this->getBearerToken();
		    $Jwt_client = new Jwt_client(); 
		    $token = $Jwt_client->decode($token);
		    
		    if($token){
		       if(@$token['api_key'] != $this->token_id ){
		       		$uid = $this->check_user_login();
		       }
		    }else{
		        $uid = $this->check_user_login();
		    }

			//echo $uid;
           //$uid = 155;
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{

		   	 	$delivery_method = $this->custom_model->my_where('delivery_method',"*",array('user_id' => $uid));
	          
	        		$response['status'] = true;
					$response['delivery_method'] = $delivery_method;
					$response['message'] = 'Success';
				
				if ($delivery_method)
				{
					echo json_encode( array("status" => true,"data" => $delivery_method) );die;
				}
				else{
				    $delivery_method = 0;
					echo json_encode( array("status" => false,"data" => 'empty') );die;
				}

	 		}

	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}
		
		public function get_oi_patient()
		{
			$json = file_get_contents('php://input');
			
			$jsonobj 	= json_decode($json);
		    
		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);
			

			//echo $uid;
           //$uid = 400;
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{

		   	 	// $delivery_method = $this->custom_model->my_where('orderintake',"*",array('user_id' => $uid));

		   	 	$delivery_method = $this->custom_model->get_data_array("SELECT * FROM orderintake WHERE user_id = '$uid' ORDER BY id  DESC LIMIT 1;");
		   	 	
	          
	        		$response['status'] = true;
					$response['delivery_method'] = $delivery_method;
					$response['message'] = 'Success';
				
				if ($delivery_method)
				{
					echo json_encode( array("status" => true,"data" => $delivery_method) );die;
				}
				else{
					echo json_encode( array("status" => false,"data" => 'data empty') );die;
				}

	 		}

	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}
		
		public function get_oi_doctor()
		{
		    $json = file_get_contents('php://input');
			
			$jsonobj 	= json_decode($json);
		    
		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'get_oi_doctor':$ws;
			
		    
		   $uid = $this->validate_token($language,$ws);
		   
			//echo $uid;
           //$uid = 400;
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{
		   	 	// $delivery_method = $this->custom_model->my_where('orderintake',"*",array('user_id' => $uid));

		   	 	$delivery_method = $this->custom_model->get_data_array("SELECT * FROM orderintake WHERE user_id = '$uid' ORDER BY id  DESC LIMIT 1;");

        		$response['status'] = true;
				$response['delivery_method'] = $delivery_method;
				$response['message'] = 'Success';
				
				if ($delivery_method)
				{
					echo json_encode( array("status" => true,"data" => $delivery_method) );die;
				}
				else{
					echo json_encode( array("status" => false,"data" => 'data empty') );die;
				}

	 		}

	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}
		
		
	public function upload_image_signature()
   	{
   		$uid = 0;
   		$json = file_get_contents('php://input');
			
		$jsonobj 	= json_decode($json);
	    
	    $language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'upload_image_signature':$ws;
		
	    
	   $uid = $this->validate_token($language,$ws);

	   // echo "<pre>";
	   // print_r($_FILES);
	   // die;

		/*
		    	$id = uniqid();
		    	$req_dump = "<br/>---------".$id."---------<br/>".print_r( $_REQUEST, true );
		    	file_put_contents( 'logs/'.$id.'_request.log', $req_dump );
		    	$ser_dump = "<br/>---------".$id."---------<br/>".print_r( $_SERVER, true );
		    	file_put_contents( 'logs/'.$id.'_server.log', $ser_dump );
		    	$file_dump = "<br/>---------".$id."---------<br/>".file_get_contents( 'php://input' );
		    	file_put_contents( 'logs/'.$id.'_file.log', $file_dump );
		    	$fil_dump = "<br/>---------".$id."---------<br/>".print_r( $_FILES, true );
		    	file_put_contents( 'logs/'.$id.'_fil.log', $fil_dump );
		*/

   	    $FILES = @$_FILES['club_image'];
   	    
    	if(!empty($FILES)){
    				if(isset($FILES["type"]))
    				{
    					$details = array( "caption" => "My Logo", "action" => "fiu_upload_file", "path" => "admin/usersdata/sign/" );
    					$path = $details['path'];
    					$upload_dir =  ASSETS_PATH.$path;
    					if (!file_exists($upload_dir)) {
    						mkdir($upload_dir, 0777, true);
    					}
    					$newFileName = time().rand(100,999);
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
    												'path' => $upload_dir,
    												'user_id' => $uid);
    							$img_id = $this->custom_model->my_insert($post_data,'image_master');
    							echo json_encode( array( "status" => true,"data" => $newFileName, "url" => base_url("assets/admin/usersdata/sign/").$newFileName ) );die;
    						}
    						else
    						{
    							echo json_encode( array( "status" => false,"data" => "Please try again." ) );die;
    						}
    					}
    					else
    					{ 
    						echo json_encode( array( "status" => false,"data" => "Please upload valid image." ) );die;
    					}
    				}
    	}else{
    		echo json_encode( array( "status" => false,"data" => "Please upload image." ) );die;
    	}
	    
   	}
   	
   	
   	public function face_to_face()
		{	$uid = 0;
			

			
			// $uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


			/*$json = '{"user_id":"164","yes_1":"yes","no_1":"no","yes_2":"yes","no_2":"no","yes_3":"yes", "no_3":"no","yes_4":"70","no_4":"70","yes_5":"yes","no_5":"Pune","yes_6":"12675234654","no_6":"nsc123","yes_7":"Male",
				        "no_7":"Upin123","explain_7":"12","yes_8":"Code123","no_8":"pune","yes_9":"Pune","no_9":"Pune","yes_10":"Pune","no_10":"Pune","signature":"Pune","date":"Pune","patient_name":"Girish","patient_mailing_address":"Best","patient_city":"GirishB","patient_state":"kalewadi phata chinchwad",
						"patient_zip":"pune","patient_dob":"aundh road","patient_age":"11-11-2017","phy_name":"phy_name","phy_mailing_add":"phy_mailing_add","phy_city":"phy_city","phy_state":"phy_state",
						"phy_zip":"phy_zip","date_of_last_visit":"date_of_last_visit","phy_telephone":"phy_telephone","pls_desc_evelaution":"pls_desc_evelaution","pls_list_pre_diz_visit":"pls_list_pre_diz_visit",
						"height":"height","weight":"weight","b_p":"b/p","pulse":"pulse","repositery":"repositery","is_o2_req":"is_o2_req","any_curr_press_store":"any_curr_press_store","location":"location",
						"poor_bal":"poor_bal","his_of_risk_fall":"his_of_risk_fall","poor_endurance":"poor_endurance","cachexia":"cachexia","obesity":"obesity","sig_edema":"sig_edema","hold_to_furniture":"hold_to_furniture",
						"neck_good":"neck_good","nack_limited":"nack_limited","neck_severely":"neck_severely"
			    
			}';*/
			    	
			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;

			$post_arr['yes_1'] 		= @$jsonobj->yes_1;
			$post_arr['no_1'] 		= @$jsonobj->no_1;
			$post_arr['yes_2']      = @$jsonobj->yes_2;
			$post_arr['no_2'] 	= @$jsonobj->no_2;
			// address details
			$post_arr['qus3'] 	= @$jsonobj->qus3;
			//$post_arr['no_3'] 	        = @$jsonobj->no_3;
			$post_arr['yes_4'] 		    = @$jsonobj->yes_4;
			$post_arr['no_4'] 		    = @$jsonobj->no_4;
			$post_arr['qus5'] 		= @$jsonobj->qus5;
			//$post_arr['no_5'] 		= @$jsonobj->no_5;
			$post_arr['yes_6'] 	= @$jsonobj->yes_6;
			$post_arr['no_6'] 		= @$jsonobj->no_6;
			$post_arr['yes_7'] 		    = @$jsonobj->yes_7;
			$post_arr['no_7'] 		      = @$jsonobj->no_7;						
			$post_arr['explain_7'] 		  = @$jsonobj->explain_7;
			$post_arr['qus8']  = @$jsonobj->qus8;
			// 			$post_arr['no_8']= @$jsonobj->no_8;
			$post_arr['yes_9'] 		= @$jsonobj->yes_9;
			$post_arr['no_9'] 	= @$jsonobj->no_9;
			$post_arr['qus10']    = @$jsonobj->yes_10;			
		//	$post_arr['no_10'] 		= @$jsonobj->no_10;			
			$post_arr['signature'] 	= @$jsonobj->signature;			
			$post_arr['date'] 	    = @$jsonobj->date;			
			$post_arr['patient_name'] 	    = @$jsonobj->patient_name;

			$post_arr['patient_mailing_address'] 	    = @$jsonobj->patient_mailing_address;
			$post_arr['patient_city'] 	    = @$jsonobj->patient_city;
			$post_arr['patient_state']   = @$jsonobj->patient_state;
			$post_arr['patient_zip']  = @$jsonobj->patient_zip;
			$post_arr['patient_dob'] 	= @$jsonobj->patient_dob;
			
			$post_arr['patient_hicn'] 	= @$jsonobj->patient_hicn;
			$post_arr['patient_telephone'] 	= @$jsonobj->patient_telephone;
			$post_arr['patient_ssn'] 	= @$jsonobj->patient_ssn;

			$post_arr['patient_age'] 	= @$jsonobj->patient_age;
			$post_arr['phy_name'] 	= @$jsonobj->phy_name;

			$post_arr['phy_mailing_add'] 	= @$jsonobj->phy_mailing_add;			
			$post_arr['phy_city'] 	= @$jsonobj->phy_city;
			$post_arr['phy_state'] 	= @$jsonobj->phy_state;			
			$post_arr['phy_zip'] 	= @$jsonobj->phy_zip;
			$post_arr['date_of_last_visit'] 	= @$jsonobj->date_of_last_visit;

			$post_arr['phy_telephone'] 	= @$jsonobj->phy_telephone;
			$post_arr['pls_desc_evelaution'] 	= @$jsonobj->pls_desc_evelaution;
			$post_arr['pls_list_pre_diz_visit'] 	= @$jsonobj->pls_list_pre_diz_visit;
			$post_arr['height'] 	= @$jsonobj->height;
			$post_arr['weight'] 	= @$jsonobj->weight;
			$post_arr['b_p'] 	= @$jsonobj->b_p;
			$post_arr['pulse'] 	= @$jsonobj->pulse;
			$post_arr['repositery'] 	= @$jsonobj->repositery;
			$post_arr['is_o2_req'] 	= @$jsonobj->is_o2_req;
			$post_arr['any_curr_press_store'] 	= @$jsonobj->any_curr_press_store;
			$post_arr['location'] 	= @$jsonobj->location;
			$post_arr['poor_bal'] 	= @$jsonobj->poor_bal;
			$post_arr['his_of_risk_fall'] 	= @$jsonobj->his_of_risk_fall;
			$post_arr['poor_endurance'] 	= @$jsonobj->poor_endurance;

			$post_arr['cachexia'] 	= @$jsonobj->cachexia;

			$post_arr['obesity'] 	= @$jsonobj->obesity;
			$post_arr['sig_edema'] 	= @$jsonobj->sig_edema;
			$post_arr['hold_to_furniture'] 	= @$jsonobj->hold_to_furniture;
			$post_arr['neck_good'] 	= @$jsonobj->neck_good;
			$post_arr['nack_limited'] 	= @$jsonobj->nack_limited;
			$post_arr['neck_severely'] 	= @$jsonobj->neck_severely;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];
			
		
			$this->load->library('place_order');
			$response = $this->place_order->f_to_f($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   	
	public function fav_dme()
		{	$uid = 0;
			

	
			
			// $uid = 1;
			$json = file_get_contents('php://input');

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


            //$json = '{"user_id":"164","dme_id":"50500"}';
			    	
			$jsonobj 	= json_decode($json);
	   	 	$response = $data = $post_arr = array();

			// CONTACT DETAILS
			$post_arr['user_id'] 		= @$jsonobj->user_id;

			$post_arr['dme_id'] 		= @$jsonobj->dme_id;

	        //print_r($post_pre);die;
			// $post_arr['Payment_mode'] 		= @$jsonobj['Payment_mode'];
			
		
			$this->load->library('place_order');
			$response = $this->place_order->fav_dme($post_arr,$uid);

			if ($response)
			{
				echo json_encode( array("status" => true,"data" => $response) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}
	   	
	   /*	public function get_fav_dme()
		{   $uid = 0;

			$token = $this->getBearerToken();
		    $Jwt_client = new Jwt_client(); 
		    $token = $Jwt_client->decode($token);
		    
		    if($token){

		         $uid = $this->check_user_login();
		    }

			//echo $uid;
		    // $uid = 164;

	   	 	$response = array();

	   	 	$data = $this->custom_model->my_where("fav_dme","*",array('user_id' => $uid),array(),"","","dme_id");

	   	 	if (!empty($uid))
	   	 	{	
	   	 		if($data){
	   	 		foreach ($data as $key => $value)

	   	 	//	print_r($data);
	   	 		{  $dmeid = $value['dme_id'];
			   	 	$dme = $this->custom_model->my_where('dme',"*",array('id' => $dmeid));
		          		
		          		$value['dme'] = $dme;
		          		$data[$key] = $value;

	 			}
	 			}

	 
				if ($data)
				{
					echo json_encode( array("status" => true,"data" => $data) );die;
				}
				else{
					echo json_encode( array("status" => false,"data" => 'empty') );die;
				}
	 		}

	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}*/
		
		
		public function get_fav_dme()
		{ 
		    

		    $language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$uid = $this->validate_token($language,$ws);


		    //$uid = "610";
	   	 	$response = array();

	   	 	if (!empty($uid))
	   	 	{	$data = $this->custom_model->my_where("fav_dme","*",array('user_id' => $uid),array(),"","","dme_id");
	   	 		if($data){

	   	 		foreach ($data as $key => $value)

	   	 		// print_r($data);
	   	 		{  $dmeid = $value['dme_id'];
	   	 	
			   	 	$dme = $this->custom_model->my_where('dme',"*",array('id' => $dmeid));
		          		
		          		$value['dme'] = $dme;
		          		$data[$key] = $value;

	 			}
	 			}

	 
				if ($data)
				{
					echo json_encode( array("status" => true,"data" => $data) );die;
				}
				else{
					echo json_encode( array("status" => false,"data" => 'empty') );die;
				}
	 		}

	 		else
	 		{
	 			$response['status'] = false;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);die;
	 		}
			
			die;
		}
   	    
   	   
   	public function add_dme()
	{
		
		// $uid = 1;
		$user_id = 0;
		$json = file_get_contents('php://input');

		$language 		= @$jsonobj->language;
		$language 		= empty($language)? 'en':$language;
		$ws 			= @$jsonobj->ws;
		$ws 			= empty($ws)? 'index':$ws;
		
		// $user_id 		= 627;
		$user_id = $this->validate_token($language,$ws);

		// $json = '{"address":"Ahmednagar","description":"rew ads","store":"store","city":"pune","state":"Maharashtra","zip":"Maharashtra","country":"Maharashtra","phone":"Maharashtra","fax":"Maharashtra", "email":"Maharashtra","type":"","id":""}';
		    	
		$jsonobj 	= json_decode($json);
   	 	$response = $data  = array();


		$id 			= @$jsonobj->id;
		$address 		= @$jsonobj->address;
		$description 	= @$jsonobj->description;
		$store 			= @$jsonobj->store;
		$city 			= @$jsonobj->city;
		$state 			= @$jsonobj->state;
		$zip 			= @$jsonobj->zip;
		$country 		= @$jsonobj->country;
		$phone 			= @$jsonobj->phone;
		$email 			= @$jsonobj->email;
		$type 			= @$jsonobj->type;

		$additional_data = $response = array();

		if(!empty($user_id)) $additional_data['user_id'] 				= $user_id;
		if(!empty($address)) $additional_data['address'] 				= $address;
		if(!empty($description)) $additional_data['description'] 		= $description;
		if(!empty($store)) $additional_data['store'] 					= $store;
        if(!empty($city)) $additional_data['city'] 						= $city;
        if(!empty($state)) $additional_data['state'] 					= $state;
        if(!empty($zip)) $additional_data['zip'] 						= $zip;
        if(!empty($country)) $additional_data['country'] 				= $country;
        if(!empty($phone)) $additional_data['phone'] 					= $phone;
        if(!empty($email)) $additional_data['email'] 					= $email;


        //print_r($post_pre);die;

		if (isset($user_id))
		{
			if ($type == 'save')
			{
				$inserted_id = $this->custom_model->my_insert($additional_data, 'dme');
				// echo "string";
				// die;
				
				if (empty($user_id))
				{
					echo json_encode(array("status" => true, "ws" => $ws ,"data" => $inserted_id ,"message" => ($language == 'ar'? 'بنجاح.':'Added Successfully') )); die;
				}
			}
			else if($type == 'update' && !empty($id))
			{
				$this->custom_model->my_update($additional_data ,array("id" => $id),"dme");
				// $data = $this->custom_model->my_where("dme","id,address,address2,description,store,city,state,zip,country",array("id" => $id));
				echo json_encode(array("status" => true, "ws" => $ws  ,"message" => ($language == 'ar'? 'بنجاح.':'Updated Successfully') )); die;
			}
			else if($type == 'delete' && !empty($id))
			{
				$this->custom_model->my_update(['soft_delete' => '1'] ,array("id" => $id),"dme");
				// $this->custom_model->my_delete(['id' => $id], 'dme');
				echo json_encode(array("status" => true, "ws" => $ws  ,"message" => ($language == 'ar'? 'بنجاح.':'Successfully deleted') )); die;

			}

			if ($user_id)
			{
				$get_data = $this->custom_model->get_data_array("SELECT dme_id FROM order_master WHERE user_id = '$user_id' AND dme_id != '' GROUP BY dme_id ORDER BY order_master_id DESC;");

				if (!empty($get_data))
				{
					foreach ($get_data as $key => $value)
					{
						$data = $this->custom_model->my_where("dme","id,phone,address,address2,description,store,email,city,state,zip,country,",array("id" => $value['dme_id'],"soft_delete" => ""),array(),"id","DESC","","", array(), "",array(),true );
						if (!empty($data))
						{
							$data1[] = $data[0];
						}
					}
				}

				// if (empty($data1))
				// {
				// 	echo json_encode( array("status" => false, "ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'No record found')) );die;
				// }
				// else
				// {
				// echo "<pre>";
				// print_r($data1);
				// die;

				$update_user_id = $response = array();
 				if(!empty($user_id)) $update_user_id['user_id'] = $user_id;

 				if (@$data1)
 				{
 					foreach ($data1 as $kcey => $cvalue)
					{
						$this->custom_model->my_update($update_user_id ,array("id" => $cvalue['id']),"dme");
					}
 				}
				
				$data_get = $this->custom_model->my_where("dme","id,address,phone,address2,description,store,city,email,state,zip,country,",array("user_id" => $user_id,"soft_delete" => ""),array(),"id","DESC","","", array(), "",array(),true );

				// echo "<pre>";
				// print_r($data_get);
				// die;


				echo json_encode( array("status" => true, "ws" => $ws ,"data" => $data_get) );die;
			}
			
			// }
		}
		else
		{
			echo json_encode(array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') )); die;
		}
   	}

   	    
   	    public function fav_remove()
		{		
			$json = file_get_contents('php://input');

			//$json = '{"dme_id":"50348"}';
			// $user_id = "610";

			$jsonobj 	= json_decode($json);

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$user_id = $this->validate_token($language,$ws);


	   	 	$response = $data = $post_arr = array();
	   	 	$dme_id 		= @$jsonobj->dme_id;
	   	 	
			if ( !empty($user_id) && $dme_id )
			{	$data = $this->custom_model->my_delete(array('dme_id' => $dme_id, 'user_id' => $user_id),"fav_dme");
				echo json_encode( array("status" => true,"message" => 'DME removed successfully.. ') );die;
			}
			else{
				echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
			}
	   	}

   	    public function view_dme()
		{	$uid = 0;
			
	
			
			$json = file_get_contents('php://input');

			//$json = '{"dme_id":"50751"}';
			    	
			$jsonobj 	= json_decode($json);

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$user_id = $this->validate_token($language,$ws);

	   	 	$response = $data = $post_arr = array();
	   	 	$dme_id 		= @$jsonobj->dme_id;
	   	 	$data = $this->custom_model->my_where("dme","*",array('id' => $dme_id));

			if ($data)
			{
				echo json_encode( array("status" => true,"data" => $data) );die;
			}
			else{
				echo json_encode( array("status" => false,"data" => 'data empty') );die;
			}
			
	   	}

	   	public function user_notify()
	   	{
	   		//$user_id = 1;
			$json = file_get_contents('php://input');
			//$json = '{"regno":"45dsd46"}';
			$jsonobj 	= json_decode($json);

			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'index':$ws;
			// $user_id 		= 627;
			$user_id = $this->validate_token($language,$ws);


			$regno 	= @$jsonobj->regno;
       	 	if (!empty($user_id) && !empty($regno))
       	 	{
    	   	 	
    			$res1 = $this->custom_model->my_where("user_notify","*",array("user_id" => $user_id) );
    			
    			if(isset($res1[0]['regno'])){
    				$this->custom_model->my_update(array("regno" => $regno),array("user_id" => $user_id),"user_notify" );
    			}else{
    				$this->custom_model->my_insert(array("regno" => $regno,"user_id" => $user_id),"user_notify" );
    			}
    			
    			$response["message"] = "Firebase key updated successfully.";
    			$response["status"] = true;
    			echo json_encode( $response );die;
       	 	}
    		else
    		{
    			echo json_encode( array("status" => false,"message" => 'Something went wrong.') );die;
    		}
	   	}
}