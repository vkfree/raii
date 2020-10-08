<?php 

class Default_model extends MY_Model {


	public function navbar_data($language = 'en')
	{
		$data = $this->db->order_by('display_name', 'ASC')->get_where('category', array('status' => 'active','parent' => 0))->result_array();
		if ($language == 'ar')
		{
			foreach ($data as $key => $value)
			{
				$res = $this->db->get_where('category_trans', array('id' => $value['id']))->result_array();
					if(isset($res[0]['display_name']) && !empty($res[0]['display_name']))
				$data[$key]['display_name'] = $res[0]['display_name'];
			}
		}
		//echo $this->db->last_query();
		return $data;
	}

	public function get_category($cata,$language="en")
	{
		$this->db->select('display_name,slug');
		$this->db->where('slug', $cata);
		$this->db->where('status', 'active');
		$cate_info = $this->db->get('category')->result_array();
		$category_slug = $cate_info[0]['slug'];
		if (!empty($cate_info) && isset($cate_info[0]['slug']))
		{
			$this->db->select('email,slug,plan,first_name,logo,category,id,banner');
			$this->db->where('active', '1');
			$this->db->where('group_id', '5');
			$this->db->where('store_type', STORE_TYPE);
			$this->db->like('category',$cate_info[0]['slug']);
			$users = $this->db->get('admin_users')->result_array();
			//echo $this->db->last_query();
			if($language != "en"){
				if(!empty($users)){
					foreach ($users as $ukey => $uvalue) {
						$id = $uvalue['id'];
						if(!empty($id)){
							$this->db->select('first_name,logo,banner');
							$this->db->where('id', $id);
							$userst = $this->db->get('admin_users_trans')->result_array();
							if(isset($userst[0]['logo']) && !empty($userst[0]['logo'])){
								$users[$ukey]['logo'] = $userst[0]['logo'];
							}
							if(isset($userst[0]['first_name']) && !empty($userst[0]['first_name'])){
								$users[$ukey]['first_name'] = $userst[0]['first_name'];
							}
						}
					}
				}
				$this->db->select('display_name');
				$this->db->where('slug', $cata);
				$cate_info1 = $this->db->get('category_trans')->result_array();
				if(isset($cate_info1[0]['display_name']) && !empty($cate_info1[0]['display_name'])){
					$cate_info[0]['display_name'] = $cate_info1[0]['display_name'];
				}
			}
			$now = strtotime('today midnight');
			$year = date("Y",$now);
			$query = "SELECT * FROM admin_plan WHERE year='$year' AND category_slug ='$category_slug' AND (start_date <= '$now' AND end_date >= '$now') AND store_type = '".STORE_TYPE."'";
			$result = $this->db->query($query);
			$aresult = array();
			foreach ($result->result() as $row)
			{
				$user_id = $row->user_id;
				$plan_type = $row->plan_type;
			    $aresult[$user_id] = $plan_type;
			}
			if(!empty($users)){
				foreach ($users as $ukey => $uvalue) {
					$id = $uvalue['id'];
					if(!empty($id)){
						if(isset($aresult[$id]) && !empty($aresult[$id])){
							$users[$ukey]['plan'] = $aresult[$id];
						}else{
							$users[$ukey]['plan'] = 'silver';
						}
					}
				}
			}
			return array('cate_info' => $cate_info, 'users' => $users);
		}
		else{
			return false;
		}

	}

	public function seller_data($cata,$ven,$call_by='',$language="en")
	{
		$data = array();

		$this->db->select('id,display_name');
		$this->db->where('slug', $cata);
		$this->db->where('status', 'active');
		$cate_info = $this->db->get('category')->result();
		if($language != "en"){
			$this->db->select('display_name');
			$this->db->where('id',$cate_info[0]->id);
			$cate_infot = $this->db->get('category_trans')->result_array();
			if(isset($cate_infot[0]['display_name']) && !empty($cate_infot[0]['display_name'])){
				$cate_info[0]->display_name = $cate_infot[0]['display_name'];
			}
		}

		if (!empty($cate_info) && isset($cate_info[0]->id))
			
		{
			$this->db->where('parent', $cate_info[0]->id);
			$this->db->where('status', 'active');
			$this->db->order_by('display_name', 'ASC');
			$sub_cate_info = $this->db->get('category')->result_array();
	        $this->db->select('id,email,slug,plan,first_name,logo,phone,category,streat,state,state,locality,landmark,country,banner');
			$this->db->where('slug',$ven);
			$this->db->where('category',$cata);
			// $this->db->where('group_id', '5');
			$seller_info = $this->db->get('admin_users')->result_array();

			if (empty($seller_info))
			{
				return false;
			}

			$seller_info[0]['estimated_delivery'] = "4-6 days";
			if($language != "en"){
				$seller_info[0] = $this->get_arabic_vendor($seller_info[0]);
				$seller_info[0]['estimated_delivery'] = "أيام 4-6";
			}
			foreach ($sub_cate_info as $key => $value)
			{
				$this->db->where('parent', $value['id']);
				$this->db->where('status', 'active');
				$this->db->order_by('display_name', 'ASC');
				$sub_sub_cate_info = $this->db->get('category')->result_array();
				if($language != "en"){
					$this->db->select('display_name,image');
					$this->db->where('id', $value['id']);
					$catt = $this->db->get('category_trans')->result_array();
					if(isset($catt[0]['display_name']) && !empty($catt[0]['display_name'])){
						$sub_cate_info[$key]['display_name'] = $catt[0]['display_name'];
					}
					if(isset($catt[0]['image']) && !empty($catt[0]['image'])){
						$sub_cate_info[$key]['image'] = $catt[0]['image'];
					}
				}

				$sub_cate_info[$key]['sub_cate'] = $sub_sub_cate_info;
				$this->db->select('id,text');
				$this->db->where('category_id', $value['id'] );
				$this->db->where('vendor_id', $seller_info[0]['id'] );
				$this->db->where('status', 'active');
				$ads_info = $this->db->get('ven_category')->result();
				$ads = @$ads_info[0]->text;
				if($language != "en"){
					$this->db->select('id,text');
					$this->db->where('category_id', $value['id'] );
					$this->db->where('vendor_id', $seller_info[0]['id'] );
					$this->db->where('status', 'active');
					$ads_info = $this->db->get('ven_category_trans')->result();
					$ads1 = @$ads_info[0]->text;
					if(!empty($ads1)){
						$ads = $ads1;
					}
				}
				$sub_cate_info[$key]['ads'] = $ads;
			}
	        
			if ($call_by == 'app')
			{
				$this->db->where('seller_id',$seller_info[0]['id']);
				$this->db->where('status','1' );
				$this->db->order_by('id', 'RANDOM');
				$this->db->limit(12);
				$product_info = $this->db->get('product')->result_array();
				$data['product'] = $product_info;
			}	
			$this->db->select('category');
			$this->db->where('seller_id',$seller_info[0]['id'] );
			$this->db->where('status','1' );
			$this->db->order_by('id');
			$category_info = $this->db->get('product')->result_array();
			$catarray = $fsub_cate_info = array();
			if(!empty($category_info)){
				foreach ($category_info as $ckey => $cvalue) {
					$catarray[] = $cvalue['category'];
				}
			}
			$catarray = array_unique($catarray);
			if(!empty($sub_cate_info)){
				foreach ($sub_cate_info as $sckey => $scvalue) {
					$flag = false;$ids = array();
					$sub_cate = $scvalue['sub_cate'];
					if(!empty($sub_cate)){
						foreach ($sub_cate as $kcey => $vcalue) {
							$ids[] = $vcalue['id'];
						}
					}
					if(!empty($ids)){
						$intersect = array_intersect($ids, $catarray);
					}
					if(!empty($intersect)){
						$flag = true;
						foreach ($sub_cate as $kcey => $vcalue) {
							$id = $vcalue['id'];
							if(!in_array($id, $intersect)){
								unset($sub_cate[$kcey]);
							}else{
								if($language != "en"){
									$this->db->select('display_name,image');
									$this->db->where('id', $id);
									$catt1 = $this->db->get('category_trans')->result_array();
									if(isset($catt1[0]['display_name']) && !empty($catt1[0]['display_name'])){
										$sub_cate[$kcey]['display_name'] = $catt1[0]['display_name'];
									}
									if(isset($catt1[0]['image']) && !empty($catt1[0]['image'])){
										$sub_cate[$kcey]['image'] = $catt1[0]['image'];
									}
								}
							}
						}
					}
					if($flag == true){
						$scvalue['sub_cate'] = $sub_cate;
						$fsub_cate_info[] = $scvalue;
					}
				}
			}
		
			$data['seller_info'] = $seller_info;
			$data['sub_category'] = $fsub_cate_info;
			$data['category_name'] = $cate_info[0]->display_name;

			return $data;
		}
		else{
			return false;
		}
	}

	public function products_data($cata,$ven,$sub='',$language="en",$brand_name=array(),$max_price='',$offset=0)
	{
		$get_max_price = 0;
		$product_limit = 6;
		$offset = $product_limit * $offset;
		
		$this->db->select('id,display_name');
		$this->db->where('slug', $cata);
		$this->db->where('status', 'active');
		$cate_info = $this->db->get('category')->result();
		if($language != "en"){
			$this->db->select('display_name');
			$this->db->where('id',$cate_info[0]->id);
			$cate_infot = $this->db->get('category_trans')->result_array();
			if(isset($cate_infot[0]['display_name']) && !empty($cate_infot[0]['display_name'])){
				$cate_info[0]->display_name = $cate_infot[0]['display_name'];
			}
		}
		if (!empty($cate_info))
		{
			$this->db->where('slug',$ven);
			$seller_info = $this->db->get('admin_users')->result_array();
			if($language != "en")
			{
				$seller_info[0] = $this->get_arabic_vendor($seller_info[0]);
			}
			if (!empty($seller_info))
			{
				$query = "SELECT product_brand,COUNT(product_brand) AS pcount, MAX(sale_price) AS price FROM `product` WHERE seller_id = ".$seller_info[0]['id']." AND category = $sub AND status = '1' group by product_brand";
				$result = $this->db->query($query);
				$brand_info = array();
				foreach ($result->result() as $row)
				{
					$product_brand = $row->product_brand;

					$brand_info[$product_brand]['name'] = $product_brand;
					$brand_info[$product_brand]['count'] = $row->pcount;
					$brand_info[$product_brand]['slug'] = $product_brand;
				}

				$query1 = "SELECT sale_price FROM `product` WHERE seller_id = ".$seller_info[0]['id']." AND category = $sub AND status = '1' ";
				$result1 = $this->db->query($query1);
				foreach ($result1->result() as $row1)
				{
					$price = $row1->sale_price;

					if ($price > $get_max_price)
					{
						$get_max_price = $price;
					}
				}

				$this->db->where('seller_id',$seller_info[0]['id']);
				if (!empty($brand_name))
				{
					$this->db->where_in('product_brand',$brand_name);
				}
				if (!empty($max_price))
				{
					$this->db->where("sale_price <= $max_price");
				}
				$this->db->where('category',$sub);
				$this->db->where('status','1' );
				$this->db->order_by('id');
				$product_info = $this->db->get('product', $product_limit, $offset)->result_array();
		// echo "<pre>";print_r($product_info);die;
				if(!empty($product_info)){
					foreach ($product_info as $pkey => $pvalue) {

						$price = !empty($pvalue['sale_price'])? $pvalue['sale_price']:$pvalue['price'];
						
						
						$product_brand_en = $product_brand = $pvalue['product_brand'];
						if($language != "en"){
							$product_info[$pkey] = $this->get_arabic_product($pvalue);
							$product_brand = $product_info[$pkey]['product_brand'];

							if(isset($brand_info[$product_brand_en])){

								// $brand_info[$product_brand] = $brand_info[$product_brand_en];
								// unset($brand_info[$product_brand_en]);
								$brand_info[$product_brand_en]['name'] = $product_brand;
							}
						}
						
					}
				}
				$brand_info = array_filter($brand_info);

				$this->db->select('id,display_name,parent');
				$this->db->where('id', $sub);
				$this->db->where('status', 'active');
				$subcate_info = $this->db->get('category')->result();
				if($language != "en"){
					$this->db->select('display_name,image');
					$this->db->where('id', $subcate_info[0]->id);
					$catt1 = $this->db->get('category_trans')->result_array();
					if(isset($catt1[0]['display_name']) && !empty($catt1[0]['display_name'])){
						$subcate_info[0]->display_name = $catt1[0]['display_name'];
					}
					if(isset($catt1[0]['image']) && !empty($catt1[0]['image'])){
						$subcate_info[0]->image = $catt1[0]['image'];
					}
				}

				$this->db->select('id,text');
				$this->db->where('category_id', $subcate_info[0]->parent );
				$this->db->where('vendor_id', $seller_info[0]['id'] );
				$this->db->where('status', 'active');
				$ads_info = $this->db->get('ven_category')->result();
				$ads = @$ads_info[0]->text;
				if($language != "en"){
					$this->db->select('id,text');
					$this->db->where('category_id', $subcate_info[0]->parent  );
					$this->db->where('vendor_id', $seller_info[0]['id'] );
					$this->db->where('status', 'active');
					$ads_info = $this->db->get('ven_category_trans')->result();
					$ads1 = @$ads_info[0]->text;
					if(!empty($ads1)){
						$ads = $ads1;
					}
				}
				return array('seller_info' => $seller_info,'product_info' =>$product_info,'category_name' => $subcate_info[0]->display_name, 'main_cate' => $cate_info[0]->display_name, 'brand_info' => $brand_info, 'ads' => $ads, 'max_price' => $get_max_price);
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	public function get_arabic_product($product_arr)
	{
		if(!empty($product_arr))
		{
			$id = $product_arr['id'];
			if (!empty($id))
			{
				$this->db->where('id',$id );
				$productt = $this->db->get('product_trans')->result_array();
				if(isset($productt[0]['product_brand']) && !empty($productt[0]['product_brand'])){
					$product_arr['product_brand'] = $productt[0]['product_brand'];
				}
				if(isset($productt[0]['product_name']) && !empty($productt[0]['product_name'])){
					$product_arr['product_name'] = $productt[0]['product_name'];
				}
				if(isset($productt[0]['description']) && !empty($productt[0]['description'])){
					$product_arr['description'] = str_replace('pre','div',$productt[0]['description']);
				}
				if(isset($productt[0]['measurement']) && !empty($productt[0]['measurement'])){
					$product_arr['measurement'] = $productt[0]['measurement'];
				}
				if(isset($productt[0]['measure_unit']) && !empty($productt[0]['measure_unit'])){
					$product_arr['measure_unit'] = $productt[0]['measure_unit'];
				}
				if(isset($productt[0]['product_image']) && !empty($productt[0]['product_image'])){
					$product_arr['product_image'] = $productt[0]['product_image'];
				}
				if(isset($productt[0]['tags']) && !empty($productt[0]['tags'])){
					$product_arr['tags'] = $productt[0]['tags'];
				}
			}
		}
		return $product_arr;
	}

	public function get_arabic_vendor($vendor_arr)
	{
		if (!empty($vendor_arr))
		{
			$id = $vendor_arr['id'];
			if(!empty($id))
			{
				$this->db->select('first_name,logo,phone,email,streat,locality,landmark,state,country');
				$this->db->where('id', $id);
				$userst = $this->db->get('admin_users_trans')->result_array();
				if(isset($userst[0]['logo']) && !empty($userst[0]['logo'])){
					$vendor_arr['logo'] = $userst[0]['logo'];
				}
				if(isset($userst[0]['first_name']) && !empty($userst[0]['first_name'])){
					$vendor_arr['first_name'] = $userst[0]['first_name'];
				}
				if(isset($userst[0]['phone']) && !empty($userst[0]['phone'])){
					$vendor_arr['phone'] = $userst[0]['phone'];
				}
				if(isset($userst[0]['email']) && !empty($userst[0]['email'])){
					$vendor_arr['email'] = $userst[0]['email'];
				}
				if(isset($userst[0]['streat']) && !empty($userst[0]['streat'])){
					$vendor_arr['streat'] = $userst[0]['streat'];
				}
				if(isset($userst[0]['state']) && !empty($userst[0]['state'])){
					$vendor_arr['state'] = $userst[0]['state'];
				}
				if(isset($userst[0]['locality']) && !empty($userst[0]['locality'])){
					$vendor_arr['locality'] = $userst[0]['locality'];
				}
				if(isset($userst[0]['landmark']) && !empty($userst[0]['landmark'])){
					$vendor_arr['landmark'] = $userst[0]['landmark'];
				}
				if(isset($userst[0]['country']) && !empty($userst[0]['country'])){
					$vendor_arr['country'] = $userst[0]['country'];
				}
			}
		}
		return $vendor_arr;
	}

	public function get_random_vendor()
	{
		$this->db->select('email,slug,plan,first_name,logo,category,banner');
		$this->db->where('active' , 1);
		$this->db->where('plan' , 'platinum');
		$this->db->order_by('id', 'RANDOM');
		$this->db->limit(1);
		$platinum = $this->db->get('admin_users')->result_array();

		$this->db->select('email,slug,plan,first_name,logo,category,banner');
		$this->db->where('active' , 1);
		$this->db->where('plan' , 'gold');
		$this->db->order_by('id', 'RANDOM');
		$this->db->limit(6);
		$gold = $this->db->get('admin_users')->result_array();

		$this->db->select('email,slug,plan,first_name,logo,category,banner');
		$this->db->where('active' , 1);
		$this->db->where('plan' , 'silver');
		$this->db->order_by('id', 'RANDOM');
		$this->db->limit(9);
		$silver = $this->db->get('admin_users')->result_array();

		$data = array('platinum' => $platinum, 'gold' => $gold, 'silver' => $silver);

		return $data;
	}

	public function get_sub_sub_category($sub_category,$language = "en")
	{
		$this->db->where('parent', $sub_category);
		$this->db->where('status', 'active');
		$subcate_info = $this->db->get('category')->result_array();
		if($language != "en"){
			$this->db->select('display_name,image');
			$this->db->where('id', $subcate_info[0]['id']);
			$catt1 = $this->db->get('category_trans')->result_array();
			if(isset($catt1[0]['display_name']) && !empty($catt1[0]['display_name'])){
				$subcate_info[0]['display_name'] = $catt1[0]['display_name'];
			}
			if(isset($catt1[0]['image']) && !empty($catt1[0]['image'])){
				$subcate_info[0]['image'] = $catt1[0]['image'];
			}
		}
		return $subcate_info;
	}
}