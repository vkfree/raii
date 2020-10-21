<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	public function __construct()
	{
		$this->load->model('Default_model');
	}

	/**
	 * Login page and submission
	 */
	public function index()
	{
		$json 		= file_get_contents('php://input');
		// $json 		= '{"email":"vj@gmail.com","password":"123123"}';
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
			// $user->token = $Jwt_client->encode( array( "password" => $password,"email" => $email ) );
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
}
