<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * v1 Controller with Swagger annotations
 * Reference: https://github.com/zircote/swagger-php/
 */
class V1 extends API_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('v1_model');
	    $this->load->model('default_model');
	    $this->token_id = "s56by73212343289fdsfitdsdne";
	}

	/**
	 * @SWG\Post(
	 * 	path="/v1/sign_up",
	 * 	tags={"v1"},
	 * 	summary="User sign up registration.",
	 * 	@SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description=" ",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/v1SignUp")
	 * 	),
	 *  @SWG\Parameter(
  	 *  type="string",
  	 *  name="Token",
     *  in="header",
  	 *  required=true),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Successful operation"
	 * 	)
	 * )
	 */
	public function sign_up_post()
	{
		// required fields
        /*
		Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJDSSBCb290c3RyYXAgMyIsImlhdCI6MTQ5NjQ3MjUzNiwianRpIjoiZDA4MjA4MDkwODcwZWI5MjU3NzIwNzczYWRmZDFjMWEiLCJhcGlfa2V5IjoiczU2Ynk3MzIxMjM0MzI4OWZkc2ZpdGRzZG5lIn0.3SbeLxvOO2yqIUP6IVVSq1DQmigWw1KPxprrXAC2eD8
		*/		
  
		$this->load->library("Jwt_client");
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

		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$password 	= @$jsonobj->password;
		$email 		= @$jsonobj->email;
		$username 	= $email;
		$first_name 	= @$jsonobj->first_name;
		$last_name 		= @$jsonobj->last_name;
		$mobile 		= @$jsonobj->mobile;
		$group 			= @$jsonobj->group;
		
		if(empty($email) || strlen($email) > 50 || filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	    	echo json_encode( array("status" => false,"message" => "Please enter valid email address.") );die;
	    }
	    if(empty($password) || strlen($password) > 35 ){
	    	echo json_encode( array("status" => false,"message" => "Please enter valid password.") );die;
	    }
		if (empty($password) && strlen($password) < 6 ){
		  echo json_encode(array("status" => false,"message" => trim("Please enter password atleast 6 character") )); die;
		}
		if (empty($first_name)) {
		  echo json_encode(array("status" => false,"message" => trim("Please Enter a first name") )); die;
		}
		if (empty($last_name)) {
		  echo json_encode(array("status" => false,"message" => trim("Please Enter a last name") )); die;
		}

		if (!preg_match('/^\d{10}$/',$mobile)) {
		  echo json_encode(array("status" => false,"message" => trim("Phone number invalid !") )); die;
		}

		if(empty($group) || $group != '2' ){
			$group = '1';
		}
		$response = array();
		$groups = array($group);
			$additional_data = array();
			if(!empty($first_name)) $additional_data['first_name'] = $first_name;
			if(!empty($last_name)) $additional_data['last_name'] = $last_name;
			if(!empty($mobile)) $additional_data['mobile'] = $mobile;
			// proceed to create user
			$user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);
			// result
			if($user_id){
				$text=str_ireplace('<p>','',$this->ion_auth->messages());
				$text=str_ireplace('</p>','',$text);
				$response['status'] = true;
				$response['message'] = $text;
				echo json_encode($response);die;
			}else{
				$text=str_ireplace('<p>','',$this->ion_auth->errors());
				$text=str_ireplace('</p>','. ',$text);  
				if( $group == '1' ){
					$text .= " Please wait for approve.";
				}
				echo json_encode(array("status" => false,"message" => trim($text),"body" => array() ));die;
			}

		echo json_encode($response); die;
	}

	/**
	 * @SWG\Post(
	 * 	path="/v1/login",
	 * 	tags={"v1"},
	 * 	summary="Retrieve user’s information.",
	 * 	@SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="Login info",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/v1Login")
	 * 	),
	 *  @SWG\Parameter(
  	 *  type="string",
  	 *  name="Token",
     *  in="header",
  	 *  required=true),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Successful operation"
	 * 	)
	 * )
	 */
	public function login_post()
	{	
		$this->load->library("Jwt_client");
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

		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$password 	= @$jsonobj->password;
		$email 		= @$jsonobj->email;
   	 
		$this->logout();
		$logged_in = $this->ion_auth->login($email, $password, FALSE);

		// result
		if ($logged_in)
		{	

			$user = $this->ion_auth->user()->row();
			unset($user->password);
			unset($user->salt);
			unset($user->ip_address);
			unset($user->activation_code);
			unset($user->forgotten_password_code);
			unset($user->forgotten_password_time);
			unset($user->remember_code);
			// TODO: append API key
			$user->token = $Jwt_client->encode( array( "password" => $password,"email" => $email ) );
			$response['status'] = true;
			$response["user"] = $user;
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
	 * @SWG\Post(
	 * 	path="/v1/updateuserinfo",
	 * 	tags={"v1"},
	 * 	summary="Update user’s information.",
	 * 	@SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="",
	 * 		required=false,
	 * 		@SWG\Schema(ref="#/definitions/v1UpdateUserInfo")
	 * 	),
	 *  @SWG\Parameter(
  	 *  type="string",
  	 *  name="Token",
     *  in="header",
  	 *  required=true),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Successful operation"
	 * 	)
	 * )
	 */
	public function updateuserinfo_post()
	{
		$this->load->library("Jwt_client");
		$token = $this->getBearerToken();
	    $Jwt_client = new Jwt_client(); 
	    $token = $Jwt_client->decode($token);
	    if($token){
	    	$aData = array();
	    	$email = @$token['email'];
	    	$password = @$token['password'];
	    	$this->logout();
	    	$logged_in = $this->ion_auth->login($email, $password, FALSE);
	    	if ($logged_in)
   	 		{
		    	$json = file_get_contents('php://input');
		    	$jsonobj 	= json_decode($json);
		    	$mobile 		= @$jsonobj->mobile;
		    	$last_name 	= @$jsonobj->last_name;
		    	$first_name 		= @$jsonobj->first_name;
		    	if(!empty($mobile)) $aData['mobile'] = $mobile;
		    	if(!empty($first_name)) $aData['first_name'] = $first_name;
		    	if(!empty($last_name)) $aData['last_name'] = $last_name;
		    	if(empty($aData)){
		    		echo json_encode( array("status" => false,"message" => "Please enter atlease one field") );die;
		    	}
		       	$user = $this->ion_auth->user()->row();
		       	$this->v1_model->update_user($user->id,$aData);
				$response['status'] = true;
		       	echo json_encode( $response );die;
		    }else{
		    	header('X-PHP-Response-Code: 401', true, 401);
		        echo json_encode( array("status" => false,"message" => "Invalid authentication.") );die;
    		}
	    }else{
	    	header('X-PHP-Response-Code: 401', true, 401);
	        echo json_encode( array("status" => false,"message" => "Invalid authentication.") );die;
	    }
	}

	/**
	 * @SWG\Post(
	 * 	path="/v1/home",
	 * 	tags={"v1"},
	 * 	summary="Retrieve user’s information.",
	 * 	@SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description=" ",
	 * 		required=false,
	 * 		@SWG\Schema(ref="#/definitions/v1Home")
	 * 	),
	 *  @SWG\Parameter(
  	 *  type="string",
  	 *  name="Token",
     *  in="header",
  	 *  required=true),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Successful operation"
	 * 	)
	 * )
	 */
	public function home_post()
	{	
		$this->load->library("Jwt_client");
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

		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$category 	= @$jsonobj->category;
   	 	$response = array();

   	 	$nav_list = $this->default_model->navbar_data();
		
		$response['navbsr_list'] = $nav_list->result_array();

   	 	if (!empty($category))
   	 	{
   	 		$vendor_list = $this->default_model->get_category($category);
   	 		if ($vendor_list)
   	 		{
   	 			$user_sort = array();
   	 			foreach ($vendor_list['users'] as $key => $value) {
   	 				$value->logo = base_url().'assets/admin/seller_img/'.$value->logo;
   	 				// $vendor_list['users'][$key]->logo = $value->logo;

   	 				$plan = $value->plan;
   	 				$user_sort[$plan][] = $value;
   	 			}

   	 			$vendor_list['users'] = $user_sort;

   	 			$response['status'] = true;
				$response['vendor'] = $vendor_list;
				$response['message'] = 'Success';
   	 		}
   	 		else
   	 		{
   	 			$response['status'] = false;
				$response['message'] = 'Invalid category code';
   	 		}

   	 		echo json_encode($response);die;
   	 	}
   	 	else{
   	 		$vendor_list = $this->default_model->get_random_vendor();

   	 		foreach ($vendor_list as $k => $val) {

   	 			foreach ($val as $key => $value) {
   	 				$vendor_list[$k][$key]->logo = base_url().'assets/admin/seller_img/'.$value->logo;
   	 			}
 				
 			}

	 		$response['status'] = true;
			$response['vendor'] = $vendor_list;
			$response['message'] = 'Success';
			echo json_encode($response);die;
   	 	}
		
		die;
	}

	/**
	 * @SWG\Post(
	 * 	path="/v1/vendor",
	 * 	tags={"v1"},
	 * 	summary="Retrieve user’s information.",
	 * 	@SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description=" ",
	 * 		required=false,
	 * 		@SWG\Schema(ref="#/definitions/v1Vendor")
	 * 	),
	 *  @SWG\Parameter(
  	 *  type="string",
  	 *  name="Token",
     *  in="header",
  	 *  required=true),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Successful operation"
	 * 	)
	 * )
	 */
	public function vendor_post()
	{	
		$this->load->library("Jwt_client");
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

		$json = file_get_contents('php://input');
		$jsonobj 	= json_decode($json);
		$category 	= @$jsonobj->category;
		$vendor 	= @$jsonobj->vendor;
   	 	$response = array();

   	 	if (!empty($category) && !empty($vendor))
   	 	{
   	 		$data = $this->default_model->seller_data($category,$vendor);

   	 		if ($data)
   	 		{
	 			$response['status'] = true;
				$response['vendor'] = $data;
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
	 * Get hearder Authorization
	 * */
	function getAuthorizationHeader(){
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