<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_parent_category()
	{
		$this->db->select('id,display_name');
		$this->db->where('parent',0,get_store_type());
		$this->db->where('status','active',get_store_type());
		

		return $this->db->get('category')->result();
	}
}