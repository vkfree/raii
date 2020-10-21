<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library to add cart/ add wish list
 */
class User_account {

	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model('admin/Custom_model','custom_model');
	}

	public function add_remove_cart($pid, $uid, $type = 'add', $qty = 1)
	{
		$uncontent = $response = array();
		$status = false;
		$cart_qty = 0;

		if (!empty($uid))
		{
			$is_data = $this->CI->custom_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
			if (!empty($is_data))
			{
				$status = true;
				$db_content = $is_data[0]['content'];
				$id = $is_data[0]['id'];
				$uncontent = unserialize($db_content);
			}
		}
		else{
			$uncontent = unserialize($this->CI->session->userdata('content'));
		}

		if ($type == 'add')
		{
			$cnt['m'.$pid] = array('pid' => $pid, 'qty' => $qty);
			$data = array('meta_key' => 'cart', 'content' => serialize($cnt));

			if (!empty($uncontent))
			{
				if (!array_key_exists('m'.$pid, $uncontent))
				{
					$uncontent['m'.$pid] = array('pid' => $pid, 'qty' => $qty);
					$final_qty = $qty;
					$response = $uncontent;
				}
				else{
					if( $qty == 1 || $qty == -1){
						$final_qty = $uncontent['m'.$pid]['qty'] + $qty;
					}else{
						$final_qty = $qty;
					}

					if (!$final_qty)// if final qty is zero then set it to one
					{
						$final_qty = 1;
					}

					$uncontent['m'.$pid]['qty'] = $final_qty;
					$response = $uncontent;
				}
				
				// check if shock is present
				$res = $this->CI->custom_model->my_where('product','*',array('id' => $pid));
				if (isset($res[0]))
				{
					if (($final_qty > $res[0]['stock']) || $res[0]['stock_status'] == 'notinstock')
					{
						return false;
					}
				}

				foreach ($uncontent as $unkey => $unvalue)
				{
					$cart_qty += $unvalue['qty'];
				}
			}
			else{
				$cart_qty = $qty;
				$response = $cnt;
			}

			if (!empty($uid))
			{
				if ($status)
				{
					$this->CI->custom_model->my_update(array('content' => serialize($response)),array('id' => $id),'my_cart',true,true);
				}
				else{
					$data['user_id'] = $uid;
					$this->CI->custom_model->my_insert($data,'my_cart');
				}
			}
			$response['cart_qty'] = $cart_qty;

			// print_r($response);return;

			return $response;
		}
		else if($type == 'remove')
		{
			if (!empty($uncontent))
			{
				if (array_key_exists('m'.$pid, $uncontent))
				{
					unset($uncontent['m'.$pid]);
					$uncontent = array_filter($uncontent);
					$response = $uncontent;

					if (!empty($uid) && $status)
					{
						$this->CI->custom_model->my_update(array('content' => serialize($response)),array('id' => $id),'my_cart',true,true);
					}

					foreach ($uncontent as $unkey => $unvalue)
					{
						$cart_qty += $unvalue['qty'];
					}
					$response['cart_qty'] = $cart_qty;

					return $response;
				}
				else{
					return '-1';
				}
			}
			else{
				return '-1';
			}
		}

	}

	public function delete_for_multiple($id, $type)
	{
		$table = '';

   	 	if (!empty($id) && !empty($type))
   	 	{
   	 		if ($type == 'address')
   	 		{
   	 			$table = 'user_address';
   	 		}
   	 		elseif ($type == 'insurance')
   	 		{
   	 			$table = 'order_insurance';
   	 		}
   	 		elseif ($type == 'prescription')
   	 		{
   	 			$table = 'image_master';
   	 		}
   	 		elseif ($type == 'card')
   	 		{
   	 			$table = 'billing_info';
   	 		}
   	 		else{
   	 			return false;
   	 		}

   	 		$data = $this->CI->custom_model->my_where($table, '*', array('id' => $id));
   	 		if (!empty($data))
   	 		{
   	 			$this->CI->custom_model->my_insert(array('type' => $type, 'data' => serialize($data[0])), 'deleted_backup');
   	 		}
   	 		else{
   	 			return false;
   	 		}
   	 		
   	 		$this->CI->custom_model->my_delete(array('id' => $id), $table, false);

   	 		$this->CI->custom_model->my_update(array('store_type' => ''), array('id' => $id), $table);
   	 		return true;
   	 	}

		return false;
   	}


}