<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library to search from website or app
 */
class Search {

	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model('admin/Custom_model','custom_model');
	}

	public function search_lib($language, $string, $call_by = '', $user_id = 0)
	{
		$response = array();
		$main_cate_index = $sub_cate_index = $vendor_index = $product_index = $index = 0;
		$style = '';

		// search by main category
		if($language == "ar"){
			$cate_data = $this->CI->custom_model->my_where("category_trans","*",array('status' => 'active','parent' => 0), array('display_name' => $string) );
		}
		else{
			$cate_data = $this->CI->custom_model->my_where("category","*",array('status' => 'active','parent' => 0), array('display_name' => $string) );
		}

		if (!empty($cate_data))
		{
			$main_cate_index = 1;
			foreach ($cate_data as $key => $value)
			{
				if ($call_by == 'web')
				{
					if (!$index)
					{
						$style = 'searchactive';
					}else{
						$style = '';
					}$index++;
					
					$response[] = '<div  onclick="location.href=\''.base_url($language.'/category/c/').$value['id'].'\'" class="point_me search_drop_down '.$style.'" >'.$value['display_name'].'</div>';
				}
				else if ($call_by == 'api')
				{
					$parameter = array(
						'category' => $value['id'],
						'vendor' => '',
						'sub_category' => '',
						'subcategory' => '',
						'product_id' => '',
						'user_id' => $user_id,
						'language' => $language
						);

					$response[] = array('API' => 'sub_sub_category','parameters' => $parameter,'display_name' => $value['display_name'], 'sub_name' => '');
				}
				
			}
		}

		if ($main_cate_index && $call_by == 'web') $response[count($response)] = '<hr style="margin: 0;" >';

		// search by vendor
		//if (empty($response) || count($response) < 8)
		/*{
			$ven_data = $this->CI->custom_model->my_where("admin_users","*",array('active' => '1','category != ' => ''), array('first_name' => $string) );
			if(!empty($ven_data)){
				$asort = array('platinum' => array(), 'gold' => array(), 'silver' => array());
				foreach ($ven_data as $vkey => $vvalue) {
					$plan = $vvalue['plan'];
					$asort[$plan][] = $vvalue;
				}
			}
			if(!empty($asort)){
				$ven_data = array();
				foreach ($asort['platinum'] as $skey => $svalue) {
					$ven_data[] = $svalue;
				}
				foreach ($asort['gold'] as $skey => $svalue) {
					$ven_data[] = $svalue;
				}
				foreach ($asort['silver'] as $skey => $svalue) {
					$ven_data[] = $svalue;
				}
			}

			if (!empty($ven_data))
			{
				$vendor_index = 1;
				foreach ($ven_data as $key => $value)
				{

					if ($call_by == 'web')
					{
						if (!$index)
						{
							$style = 'searchactive';
						}else{
							$style = '';
						}$index++;

						$response[] = '<div  onclick="location.href=\''.base_url($language.'/category/c/').$value['category'].'/'.$value['slug'].'\'" class="point_me search_drop_down '.$style.'" >'.$value['first_name'].'</div>';
					}
					else if ($call_by == 'api')
					{
						$parameter = array(
							'category' => $value['category'],
							'vendor' => $value['slug'],
							'sub_category' => '',
							'subcategory' => '',
							'product_id' => '',
							'user_id' => $user_id,
							'language' => $language
							);

						$response[] = array('API' => 'vendor','parameters' => $parameter,'display_name' => $value['first_name'], 'sub_name' => '');
					}
				}
			}
		}*/

		//if ($vendor_index && $call_by == 'web') $response[count($response)] = '<hr style="margin: 0;" >';

		// search by sub category
		if (empty($response) || count($response) < 8)
		{
			if($language == "ar"){
				$sub_cate_data = $this->CI->custom_model->my_where("category_trans","*",array('status' => 'active','parent !=' => 0), array('display_name' => $string) );
			}else{
				$sub_cate_data = $this->CI->custom_model->my_where("category","*",array('status' => 'active','parent !=' => 0), array('display_name' => $string) );
			}
			
		// print_r($sub_cate_data);die;
			if(!empty($sub_cate_data))
			{
				$all_cate_data = $this->CI->custom_model->my_where("category","*",array('status' => 'active') );
			}
		 //print_r($sub_cate_data); die;
			if (!empty($sub_cate_data))
			{
				$sub_cate_index = 1;
				foreach ($sub_cate_data as $key => $value)
				{
					if ($value['parent'])
					{
						// print_r($value['parent']);
						if ($call_by == 'web')
						{
							if (!$index)
							{
								$style = 'searchactive';
							}else{
								$style = '';
							}$index++;

							$response[] = '<div  onclick="location.href=\''.base_url($language.'/category/product_listing').'/'.$value['id'].'\'" class="point_me search_drop_down '.$style.'" >'.$value['display_name'].'</div>';
						}
						else if($call_by == 'api')
						{
							$parameter = array(
								'category' => $value['id'],
								'parent' => $value['parent'] ,
								'sub_category' => '',
								'subcategory' => '',
								'product_id' => '',
								'user_id' => $user_id,
								'language' => $language
								);

						$response[] = array('API' => 'sub_sub_category','parameters' => $parameter,'display_name' => $value['display_name'], 'sub_name' => '');
						}
						
					}
					else{
						if ($call_by == 'web')
						{
							if (!$index)
							{
								$style = 'searchactive';
							}else{
								$style = '';
							}$index++;

							$response[] = '<div  onclick="location.href=\''.base_url($language.'/category/c/').$value['cate_slug'].'/'.$value['ven_slug'].'?active='.en_de_crypt($value['cate_id']).'#all-cate\'" class="point_me search_drop_down '.$style.'" >'.$value['category_name'].' <span class="search-seller-name">'.$value['vendor_name'].'</span>'.'</div>';
						}
						else if($call_by == 'api')
						{
							$parameter = array(
								'category' => $value['cate_slug'],
								'vendor' => $value['ven_slug'],
								'sub_category' => $value['cate_id'],
								'subcategory' => '',
								'product_id' => '',
								'user_id' => $user_id,
								'language' => $language
								);

							$response[] = array('API' => 'sub_sub_category','parameters' => $parameter,'display_name' => $value['category_name'], 'sub_name' => $value['vendor_name']);
						}
					}
					
				}
			}
		}

		if ($sub_cate_index && $call_by == 'web') $response[count($response)] = '<hr style="margin: 0;" >';
		

		// search by product
		if (empty($response) || count($response) < 8)
		{
			if($language == "ar"){
				$ven_data = $this->CI->custom_model->my_where("product_trans","*",array('status' => '1'), array('product_name' => $string) );
			}else{
				$ven_data = $this->CI->custom_model->my_where("product","*",array('status' => '1'), array('product_name' => $string) );
			}			
			// print_r($ven_data); die; ( change $ response change $value and url )
			if (!empty($ven_data))
			{
				$product_index = 1;
				foreach ($ven_data as $key => $value)
				{
					$seller_data = $this->CI->custom_model->my_where("admin_users","first_name",array('id'=>$value['seller_id']));
					if ($call_by == 'web')
					{
						if (!$index)
						{
							$style = 'searchactive';
						}else{
							$style = '';
						}$index++;

						$response[] = '<div  onclick="location.href=\''.base_url($language.'/category/product_listing/').$value['category'].'\'" class="point_me search_drop_down '.$style.'" >'.$value['product_name'].' <span class="search-seller-name"></span>'.'</div>';
					}
					else if($call_by == 'api')
					{
						$parameter = array(
							'category' => $value['category'],
							'vendor' => '',
							'sub_category' => '',
							'subcategory' => '',
							'product_id' => $value['id'],
							'user_id' => $user_id,
							'language' => $language
							);
							
						$response[] = array('API' => 'product_detail','parameters' => $parameter,'display_name' => $value['product_name'], 'sub_name' => @$seller_data[0]['first_name']);
					}
				}
			}
		}
		
		return $response;
	}

	public function get_parent_category($sub_cate,$all_cat)
	{
		for ($i=0; $i < 10; $i++)
		{ 
			if (isset($all_cat[$sub_cate]))
			{
				$info = $all_cat[$sub_cate];
				if ($info['parent'] == 0)
				{
					return $info;
				}
				$sub_cate = $info['parent'];
			}
		}
	}

}