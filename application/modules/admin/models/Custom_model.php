<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_categories()
	{
		return $this->db->get_where('category', array('status' => 'active','parent' => 0))->result();
	}

	public function get_pre_slug($table,$slug)
	{
		$this->db->select('COUNT(*) AS NumHits');
		$this->db->like('slug', $slug);
		$row = $this->db->get($table)->result();

		return $row[0]->NumHits;
	}
    
    public  function get_meta_value_trans($id)
	{
        return $this->db->get_where('admin_option_trans',array('id =' => $id))->result_array();
    }
    
    public  function update_meta_key_trans($id,$data,$key="")
	{
		if(!empty($key)){
			$mdata = $this->db->get_where('admin_option_trans',array('meta_key =' => $id))->result();
		}else{
			$mdata = $this->db->get_where('admin_option_trans',array('id =' => $id))->result();
		}
		if(!empty($mdata)){
			return $this->db->update('admin_option_trans',$data,array('id' => $id));
		}else{
			return $this->db->insert('admin_option_trans',$data);
		}
	}
	
	public function record_count($table,$where = array())
	{
		$this->db->select('COUNT(*) AS NumHits');
		
		if (!empty($where) && is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		$row = $this->db->get($table)->result();

		return $row[0]->NumHits;
	}

	public function my_insert($data,$table)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	public function my_where($table,$select = '*',$where = array(),$like = array(), $order="",$orderby="",$group_by="",$where_in="", $where_in_data = array(), $return = "", $join = array(),$chk =true)
	{
		$this->db->select($select);
		if(!empty($where_in) && !empty($where_in_data)){
			$this->db->where_in($where_in,$where_in_data);
		}
		if (!empty($where) && is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}

		if (!empty($like) && is_array($like))
		{
			foreach ($like as $key => $value)
			{
				$this->db->like($key, $value);
			}
		}

		if (!empty($join) && is_array($join))
		{
			foreach ($join as $vkey => $vvalue)
			{
				$this->db->join($vkey, $vvalue);
			}
		}

		if(!empty($order) && !empty($orderby) ){
			$this->db->order_by($order, $orderby);
		}
		if(!empty($group_by) ){
			$this->db->group_by($group_by);
		}
		if($return == "object"){
			return $this->db->get($table)->result();
		}else

		{
			return $this->db->get($table)->result_array();
		}
		
	}

	public function my_update($field,$where,$table)
	{

		if (!empty($field) && is_array($field) && !empty($where) && is_array($where) && !empty($table))
		{
			foreach ($where as $key1 => $value1)
			{
				$this->db->where($key1, $value1);
			}

			$this->db->update($table,$field);
			return true;
		}
		else
		{
			return false;
		}
	}

	
	public function my_delete($where,$table)
	{

		if (!empty($where) && is_array($where) && !empty($table))
		{
			$this->db->delete($table, $where);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_data($query)
	{
		$result = $this->db->query($query);
		$aresult = array();
		foreach ($result->result() as $row)
		{
		    $aresult[] = $row;
		}
		return $aresult;
	}
    
    public function get_data_array($query)
	{
		$result = $this->db->query($query);
		return $result->result_array();
	}
    
    
    
    
    
    
    public  function update_meta_key($id,$data,$key="")
	{
		if(!empty($key)){
			$mdata = $this->db->get_where('admin_option',array('meta_key =' => $id))->result();
		}else{
			$mdata = $this->db->get_where('admin_option',array('id =' => $id))->result();
		}
		if(!empty($mdata)){
			return $this->db->update('admin_option',$data,array('id' => $id));
		}else{
			return $this->db->insert('admin_option',$data);
		}
	}

    public  function get_meta_value($id)
	{
        return $this->db->get_where('admin_option',array('id =' => $id))->result_array();
    }

    public  function update_vender_key($id,$data,$key="")
	{
		if(!empty($key)){
			$mdata = $this->db->get_where('vender_option',$id)->result();
		}else{
			$mdata = $this->db->get_where('vender_option',array('id =' => $id))->result();
		}
		if(!empty($mdata)){
			if(!empty($key)){
				return $this->db->update('vender_option',$data,array('key' => $id));
			}else{
				return $this->db->update('vender_option',$data,array('id' => $id));
			}
		}else{
			return $this->db->insert('vender_option',$data);
		}
	}
    public  function get_vender_value($user_id)
	{	$ares = array();
        $result = $this->db->get_where('vender_option',array('user_id' => $user_id))->result_array();
        if(!empty($result)){
        	foreach ($result as $rkey => $rvalue) {
        		$key = $rvalue['key'];
        		$value = $rvalue['value'];
        		$ares[$key] = $value;
        	}
        }
        return $ares;
    }
    public function get_admin_option($key){
    	$result = $this->db->get_where('admin_option',array('meta_key =' => $key))->result_array();
    	if(isset($result[0]['meta_value']) && !empty($result[0]['meta_value']) ){
    		return $result[0]['meta_value'];
    	}else{
    		return false;
    	}
    }
    public function get_vendor_option($key,$user_id){
    	$result = $this->db->get_where('vender_option',array('key' => $key,"user_id" => $user_id))->result_array();
    	if(isset($result[0]['value']) && !empty($result[0]['value']) ){
    		return $result[0]['value'];
    	}else{
    		return false;
    	}
    }
    
    public function RANDOM($user_id)
    {
        $this->db->where('seller_id !=', $user_id);
		$this->db->where('status' , 1);
		$this->db->where('stock_status' , 'instock');
		$this->db->order_by('id', 'RANDOM');
		$product = $this->db->get('product')->result_array();
		return $product;
    }
   
}