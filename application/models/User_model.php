<?php 

class User_model extends MY_Model {


	function validate_user($user_name, $password,$table='users')
	{
		$this->db->select('id,password,first_name,username,phone,type');
		$this->db->where('username', $user_name);
		$this->db->or_where('phone', $user_name);
		$re = $this->db->get($table)->result();
		$data = 0;
		foreach ($re as $krey => $userdata) {
			if(!empty($userdata))
			{
				$pass_word = $userdata->password;
				$firstname = $userdata->first_name;
				$username = $userdata->username;
				$phone = $userdata->phone;
				$id = $userdata->id;
				$type = $userdata->type;
				if(password_verify($password,$pass_word))
				{
					$data = array('firstname' => $firstname, 'uid' => $id, 'email' => $username, 'phone' => $phone,'type'=>$type);
					
					return $data;
				}
				else{
					$data = 1;
				}
			}
			else{
				$data = 0;
			}	
		}	
		return $data;
	}
	
    function validate_admin($identity,$password,$remember='on')
	    {
	    	$table="admin_users";
			$this->db->select('*');
			$condition=array('username'=>$identity,'active'=>1);
			$this->db->where($condition);
			$re = $this->db->get($table)->result_array();
			
			$pass_word=$re[0]['password'];
			if(password_verify($password,$pass_word))
			    {
			    	$this->session->set_userdata('identity',$re[0]['username']);
			    	$this->session->set_userdata('username',$re[0]['username']);
			    	$this->session->set_userdata('email',$re[0]['email']);
			    	$this->session->set_userdata('user_id',$re[0]['id']);
			    	$this->session->set_userdata('old_last_login',$re[0]['last_login']);
			    	$this->session->set_userdata('last_check',$re[0]['last_login']);
			    	$this->session->set_userdata('group_id',$re[0]['group_id']);
			    	$data=$re[0]['id'];
				}
			else
				{
					$data = 0;
				}	
			return $data;
	    }



	function create_member($new_member_insert_data)
	{
		// print_r($new_member_insert_data);
		$this->db->where('username', $new_member_insert_data['username']);
		$query = $this->db->get('users')->result();

        if(!empty($query)){
        	return 'email';
		}else{
			$st="phone='".$new_member_insert_data['phone']."'";
			/*$st="phone='".$new_member_insert_data['phone']."' AND country_code='".$new_member_insert_data['country_code']."' ";*/
  			$this->db->where($st, NULL, FALSE);  
			//$this->db->where('phone', $new_member_insert_data['phone']);
			$query = $this->db->get('users')->result();

	        if(!empty($query)){
	        	return 'phone';
			}else{

				$insert = $this->db->insert('users', $new_member_insert_data);
			    return $this->db->insert_id();
			}
		}    
	}

	function forget_password($username){
		$this->db->select('id,password,full_name,username');
		$this->db->where('username', $username);
		$this->db->or_where('phone', $username);
		$q = $this->db->get('users');
		$userdata = $q->row();
		if(!empty($userdata))
		{	$forgotten_password_code = uniqid();
			$this->db->where("id", $userdata->id);
			$this->db->update("users",array("forgotten_password_code" => $forgotten_password_code));
			$userdata->forgotten_password_code = $forgotten_password_code;
			return $userdata;
		}
		else
		{
			
			return 0;
		}
	}

	function forget_password_admin($username){
		$this->db->select('id,password,first_name,username,email');
		$this->db->where('username', $username);
		$this->db->or_where('phone', $username);
		$this->db->or_where('email', $username);
		$q = $this->db->get('admin_users');
		$userdata = $q->row();
		if(!empty($userdata))
		{	$forgotten_password_code = uniqid();
			$this->db->where("id", $userdata->id);
			$this->db->update("admin_users",array("forgotten_password_code" => $forgotten_password_code));
			$userdata->forgotten_password_code = $forgotten_password_code;
			return $userdata;
		}else{
			return 0;
		}
	}








}