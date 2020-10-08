<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function index()
	{
		$this->Urender('index', 'udefault');
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
		
	}

	public function login()
	{
		$this->Urender('login', 'udefault');
	}

	public function about_us()
	{
		$this->Urender('about_us', 'udefault');
	}

	public function services()
	{
		$this->Urender('services', 'udefault');
	}


	public function contact()
	{
		$this->Urender('contact-us', 'udefault');
	}



}