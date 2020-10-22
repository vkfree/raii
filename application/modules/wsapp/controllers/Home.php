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

	 public function home()
   		{
	   		$json = file_get_contents('php://input');
			$language 		= @$jsonobj->language;
			$language 		= empty($language)? 'en':$language;
			$ws 			= @$jsonobj->ws;
			$ws 			= empty($ws)? 'home':$ws;
			// $user_id 		= 627;
			//$user_id = $this->validate_token($language,$ws);
			//$json 		= '{"user_id":"3"}';
			$jsonobj 	= json_decode($json);
	   	 	$response = array();
	   	 	$questions = array();
	   	 	$options = array();

	 		$response1 = $this->custom_model->get_data_array("SELECT a.*,q.* FROM `survey` AS a INNER JOIN `survey_questions` AS q ON a.survey_id = q.survey_id");
			foreach ($response1 as $qkey => $qval)
		 		{
		 			$survey_id = $qval['survey_id'];
		 			$question_id = $qval['id'];
		 			$response[$qkey]['questions'] = $qval['question'];
		 			$response[$qkey]['survey_id'] = $qval['survey_id'];
		 			$response[$qkey]['survey_name'] = $qval['survey_name'];
		 			$options = $this->custom_model->get_data_array("SELECT * FROM survey_questions WHERE `id` = '$question_id'");
		 			foreach ($options as $ookey => $oovalue)
			 			{ 	
			 				$response[$qkey]['options'][0]['key'] = 'a';
							$response[$qkey]['options'][0]['value'] = $oovalue['a'];

							$response[$qkey]['options'][1]['key'] = 'b';
							$response[$qkey]['options'][1]['value'] = $oovalue['b'];

							$response[$qkey]['options'][2]['key'] = 'c';
							$response[$qkey]['options'][2]['value'] = $oovalue['c'];

							$response[$qkey]['options'][3]['key'] = 'd';
							$response[$qkey]['options'][3]['value'] = $oovalue['d'];
						}
			 	}

	   	 	if($response)
		   	 	{
		   	 		echo json_encode( array("status" => true,"ws"=>$ws ,"data" => $response) );die;
		   	 	}
	   	 	else
		   	 	{
		   	 		echo json_encode( array("status" => false,"ws"=>$ws , "message" => 'Something went wrong.') );die;
		   	 	}
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
	
	
   
}